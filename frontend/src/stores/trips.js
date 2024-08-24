import { defineStore } from "pinia";
import axios from "axios";

const BASE_URL = "http://localhost:8000/api/";

export const useTripsStore = defineStore("trips", {
  state: () => ({
    trips: [],
    currentTrip: null,
    days: [],
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
          }
        })
        .catch((error) => {
          console.error("Error fetching trip:", error);
          this.currentTrip = null;
          this.days = [];
        });
    },
    fetchDays(trip_id) {
      axios
        .get(`${BASE_URL}days/get_days.php?trip_id=${trip_id}`)
        .then((response) => {
          this.days = response.data;
        })
        .catch((error) => {
          console.error("Error fetching days:", error);
          this.days = [];
        });
    },
  },
});
