import { defineStore } from "pinia";
import axios from "axios";
import { format, parseISO, addDays, eachDayOfInterval } from "date-fns";

const BASE_URL = "http://localhost:8000/api/";

export const useTripsStore = defineStore("trips", {
  state: () => ({
    trips: [],
    currentTrip: null,
    days: [],
    destinations: {},
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
    fetchDays(trip_id) {
      axios
        .get(`${BASE_URL}days/get_days.php?trip_id=${trip_id}`)
        .then((response) => {
          this.days = response.data;
          this.days.forEach(day => {
            this.fetchDestinations(day.id); // Fetch destinations for each day
          });
        })
        .catch((error) => {
          console.error("Error fetching days:", error);
          this.days = [];
        });
    },
    fetchDestinations(day_id) {
      axios
        .get(`${BASE_URL}destinations/get_destinations.php?day_id=${day_id}`)
        .then((response) => {
          this.$patch(state => {
            state.destinations[day_id] = response.data;
          });
        })
        .catch((error) => {
          console.error("Error fetching destinations:", error);
          this.$patch(state => {
            state.destinations[day_id] = [];
          });
        });
    },
    async createTrip(tripData) {
      try {
    
        // Create the trip and get the new trip ID
        const tripResponse = await axios.post(
          `${BASE_URL}trips/create_trip.php`,
          tripData,
          {
            headers: {
              'Content-Type': 'application/json'
            }
          }
        );
    
        const newTripId = tripResponse.data.id;
    
        // Ensure newTripId is not undefined or null
        if (!newTripId) {
          throw new Error("Failed to create trip: newTripId is undefined or null.");
        }
        
        // Convert start_date and end_date to Date objects
        const startDate = parseISO(tripData.start_date);
        const endDate = parseISO(tripData.end_date);
    
        // Create an array of dates between startDate and endDate
        const dateArray = eachDayOfInterval({ start: startDate, end: endDate }).map(date =>
          format(date, 'yyyy-MM-dd')
        );
        
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
                'Content-Type': 'application/json' 
              }
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
    }    
  },
});
