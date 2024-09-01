import { defineStore } from "pinia";
import axios from "axios";
import { format, parseISO, addDays, eachDayOfInterval } from "date-fns";

const BASE_URL = `${import.meta.env.VITE_BACKEND_URL}api/`;

export const useTripsStore = defineStore("trips", {
  state: () => ({
    BACKEND_URL: import.meta.env.VITE_BACKEND_URL,
    trips: [],
    currentTrip: null,
    days: [],
    destinations: {},
    images: {},
  }),
  actions: {
    fetchTrips() {
      axios
        .get(`${BASE_URL}trips/get_trips.php`)
        .then((response) => {
          this.trips = response.data;
        })
        .catch((error) => {
          console.error("Error fetching trips:", error);
        });
    },
    fetchTrip(id) {
      axios
        .get(`${BASE_URL}trips/get_trips.php?id=${id}`)
        .then((response) => {
          if (response.data && response.data.length > 0) {
            this.currentTrip = response.data[0];
            // Fetch the days after fetching the trip details
            this.fetchDays(id);
          } else {
            this.currentTrip = null;
            this.days = [];
            this.destinations = {};
          }
        })
        .catch((error) => {
          console.error("Error fetching trip:", error);
          this.currentTrip = null;
          this.days = [];
          this.destinations = {};
        });
    },
    // Fetch all days
    fetchDays(trip_id) {
      axios
        .get(`${BASE_URL}days/get_days.php?trip_id=${trip_id}`)
        .then((response) => {
          this.days = response.data;
    
          // Fetch destinations and images for each day
          this.days.forEach((day) => {
            this.fetchDestinations(day.id); // Fetch destinations for each day
            this.fetchDayImages(day.id); // Fetch images for each day
          });
        })
        .catch((error) => {
          console.error("Error fetching days:", error);
          this.days = [];
        });
    },    
    fetchDayImages(day_id) {
      axios
        .get(`${BASE_URL}days/get_day_images.php?day_id=${day_id}`)
        .then((response) => {
          if (response.data) {
            this.$patch((state) => {
              state.images[day_id] = response.data;
            });
          } else {
            this.$patch((state) => {
              state.images[day_id] = [];
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching images:", error);
          this.$patch((state) => {
            state.images[day_id] = [];
          });
        });
    },    
    fetchDestinations(day_id) {
      axios
        .get(`${BASE_URL}destinations/get_destinations.php?day_id=${day_id}`)
        .then((response) => {
          this.$patch((state) => {
            state.destinations[day_id] = response.data;
          });
        })
        .catch((error) => {
          console.error("Error fetching destinations:", error);
          this.$patch((state) => {
            state.destinations[day_id] = [];
          });
        });
    },
    async createTrip(tripData) {
      try {
        // Create trip and get new trip ID
        const tripResponse = await axios.post(
          `${BASE_URL}trips/create_trip.php`,
          tripData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );

        const newTripId = tripResponse.data.id;

        // Ensure newTripId is not undefined or null
        if (!newTripId) {
          throw new Error(
            "Failed to create trip: newTripId is undefined or null."
          );
        }

        // Convert start_date and end_date to Date objects
        const startDate = parseISO(tripData.get("start_date"));
        const endDate = parseISO(tripData.get("end_date"));

        // Create an array of dates between startDate and endDate
        const dateArray = eachDayOfInterval({
          start: startDate,
          end: endDate,
        }).map((date) => format(date, "yyyy-MM-dd"));

        // Create days for each date
        const dayCreationPromises = dateArray.map((date) => {
          return axios.post(
            `${BASE_URL}days/create_day.php`,
            {
              trip_id: newTripId,
              date: date,
              description: "",
            },
            {
              headers: {
                "Content-Type": "application/json",
              },
            }
          );
        });

        await Promise.all(dayCreationPromises);

        // Fetch updated trip data
        await this.fetchTrip(newTripId);

        return newTripId;
      } catch (error) {
        console.error("Error creating trip and days:", error);
        throw error;
      }
    },
    async updateTrip(tripData) {
      try {
        const response = await axios.post(
          `${BASE_URL}trips/update_trip.php`,
          tripData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        console.log("Trip updated successfully:", response.data.message);
        await this.fetchTrip(tripData.get("id")); // Fetch updated trip details
      } catch (error) {
        console.error("Error updating trip:", error);
        throw error;
      }
    },
    async deleteTrip(id) {
      try {
        await axios.post(
          `${BASE_URL}trips/delete_trip.php`,
          { id },
          {
            headers: {
              "Content-Type": "application/json",
            },
          }
        );
        // Remove deleted trip from state
        this.trips = this.trips.filter((trip) => trip.id !== id);
        console.log(`Trip with ID ${id} deleted successfully.`);
      } catch (error) {
        console.error("Error deleting trip:", error);
        throw error;
      }
    },
    // Fetch individual day
    async fetchDay(day_id) {
      try {
        const response = await axios.get(`${BASE_URL}days/get_days.php?day_id=${day_id}`);
        if (response.data) {
          return response.data;
        } else {
          throw new Error("Day not found");
        }
      } catch (error) {
        console.error("Error fetching day:", error);
        throw error;
      }
    },
    async updateDay(dayData) {
      try {
        await axios.post(
          `${BASE_URL}days/update_day.php`,
          dayData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        // Fetch updated days for the current trip
        await this.fetchDays(this.currentTrip.id);
        console.log("Day updated successfully.");
      } catch (error) {
        console.error("Error updating day:", error);
        throw error;
      }
    },
    async createDestination(destinationData) {
      try {
        await axios.post(
          `${BASE_URL}destinations/create_destination.php`,
          destinationData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        // Fetch updated destinations for specific day
        await this.fetchDestinations(destinationData.day_id);
        console.log("Destination created successfully.");
      } catch (error) {
        console.error("Error creating destination:", error);
        throw error;
      }
    },
    async fetchDestination(id) {
      try {
        const response = await axios.get(`${BASE_URL}destinations/get_destinations.php?id=${id}`);
        if (response.data) {
          return response.data;
        } else {
          throw new Error("Destination not found");
        }
      } catch (error) {
        console.error("Error fetching destination:", error);
        throw error;
      }
    },
    async updateDestination(destinationData) {
      try {
        await axios.post(
          `${BASE_URL}destinations/update_destination.php`,
          destinationData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        // Fetch updated destinations for specific day
        await this.fetchDestinations(destinationData.day_id);
        console.log("Destination updated successfully.");
      } catch (error) {
        console.error("Error updating destination:", error);
        throw error;
      }
    },
    async deleteDestination(destinationId, dayId) {
      try {
        await axios.post(
          `${BASE_URL}destinations/delete_destination.php`,
          { id: destinationId },
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        console.log(`Destination with ID ${destinationId} deleted successfully.`);

        // Refresh destinations after deletion
        await this.fetchDestinations(dayId);
      } catch (error) {
        console.error("Error deleting destination:", error);
        throw error;
      }
    },
    async deleteDayImage(imageId, dayId) {
      try {
        await axios.post(`${BASE_URL}days/delete_day_images.php`, {
          image_id: imageId,
        },
        {
          headers: {
            "Content-Type": "application/json",
          },
        });

        console.log("Image deleted successfully!");

        // Re-fetch the images for the specified day
        await this.fetchDayImages(dayId);
      } catch (error) {
        console.error("Error deleting image:", error);
        throw error;
      }
    },
  },
});
