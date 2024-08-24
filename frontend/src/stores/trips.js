import { defineStore } from "pinia";
import axios from "axios";

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
  },
});
