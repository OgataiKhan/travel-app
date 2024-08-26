import { useTripsStore } from "../stores/trips";

export const deleteTripMixin = {
  methods: {
    async deleteTrip(tripId) {
      const tripsStore = useTripsStore();
      if (confirm("Are you sure you want to delete this trip?")) {
        try {
          await tripsStore.deleteTrip(tripId);
          // alert("Trip deleted successfully!");
          this.$router.push("/");
        } catch (error) {
          console.error("Error deleting trip:", error);
          alert("Failed to delete trip. Please try again.");
        }
      }
    },
  },
};
