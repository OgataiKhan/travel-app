import { defineStore } from 'pinia'
import axios from 'axios'

export const useTripsStore = defineStore('trips', {
  state: () => ({
    trips: []
  }),
  actions: {
    fetchTrips() {
      axios.get('http://localhost:8000/api/trips/get_trips.php')
        .then(response => {
          this.trips = response.data;
        })
        .catch(error => {
          console.error('Error fetching trips:', error);
        });
    }
  }
})
