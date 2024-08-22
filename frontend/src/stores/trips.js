import { defineStore } from "pinia";
import axios from "axios";

export const useTripsStore = defineStore("trips", {
  state: () => ({
    trips: [],
    currentTrip: null,
  }),
  actions: {
    fetchTrips() {
      axios
        .get("http://localhost:8000/api/trips/get_trips.php")
        .then((response) => {
          this.trips = response.data;
        })
        .catch((error) => {
          console.error("Error fetching trips:", error);
        });
    },
    fetchTrip(id) {
      axios
        .get(`http://localhost:8000/api/trips/get_trips.php?id=${id}`)
        .then((response) => {
          // Check if trip exists
          if (response.data && response.data.length > 0) {
            this.currentTrip = response.data[0];
          } else {
            this.currentTrip = null; // Set to null if no trip found
          }
        })
        .catch((error) => {
          console.error("Error fetching trip:", error);
          this.currentTrip = null; // Set to null in case of error
        });
    },
  },
});
