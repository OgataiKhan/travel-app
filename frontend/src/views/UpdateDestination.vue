<script>
import { useTripsStore } from "../stores/trips";
import MapViewSearch from "../components/MapViewSearch.vue";
import { ref, onMounted } from 'vue';

export default {
  name: "UpdateDestination",
  components: { MapViewSearch },
  data() {
    return {
      form: {
        id: this.$route.params.destination_id, // Get destination ID from URL
        name: "",
        latitude: "",
        longitude: "",
        description: "",
      },
      apiKey: import.meta.env.VITE_TOMTOM_API_KEY,
      loading: false,
      error: null,
    };
  },
  mounted() {
    this.fetchDestinationDetails();
  },
  methods: {
    async fetchDestinationDetails() {
      const tripsStore = useTripsStore();
      this.loading = true;
      this.error = null;

      try {
        // Fetch destination details from store
        const destination = await tripsStore.fetchDestination(this.form.id);
        if (destination) {
          this.form.name = destination.name;
          this.form.latitude = destination.latitude;
          this.form.longitude = destination.longitude;
          this.form.description = destination.description;
        }
      } catch (error) {
        console.error("Error fetching destination:", error);
        this.error = "There was an error fetching the destination details.";
      } finally {
        this.loading = false;
      }
    },
    async submitForm() {
      this.loading = true;
      this.error = null;
      const tripsStore = useTripsStore();

      try {
        await tripsStore.updateDestination(this.form);
        this.$router.push(`/trip/${this.$route.params.trip_id}`);
      } catch (error) {
        console.error("Error updating destination:", error);
        this.error =
          "There was an error updating the destination. Please try again.";
      } finally {
        this.loading = false;
      }
    },
    handleLocationSelected(result) {
      // Update form with selected location
      this.form.latitude = result.position.lat;
      this.form.longitude = result.position.lng;
    },
  },
};
</script>

<template>
  <div class="container py-5">
    <h2>Edit Destination</h2>

    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="name" class="form-label">Destination Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="form.name"
          required
        />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          class="form-control"
          id="description"
          v-model="form.description"
          rows="3"
        ></textarea>
      </div>

      <!-- Map Component -->
      <MapViewSearch
        ref="mapViewSearch"
        :apiKey="apiKey"
        @location-selected="handleLocationSelected"
      />
      <!-- /Map Component -->

      <div v-if="loading" class="mt-3">
        <p>Updating destination, please wait...</p>
      </div>

      <div v-if="error" class="alert alert-danger mt-3">
        {{ error }}
      </div>

      <!-- Buttons -->
      <div class="d-flex justify-content-between mt-4">
        <router-link to="/" class="btn btn-home" aria-current="page">
          Home
        </router-link>
        <button type="submit" class="btn btn-submit" :disabled="loading">
          Update Destination
        </button>
      </div>
      <!-- /Buttons -->
    </form>
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;
@use "../scss/partial/mixins" as *;

.btn-home,
.btn-submit {
  @include button;
}
</style>
