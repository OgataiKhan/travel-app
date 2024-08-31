<script>
import { useTripsStore } from "../stores/trips";
import MapViewSearch from "../components/MapViewSearch.vue";

export default {
  name: "CreateDestination",
  components: { MapViewSearch },
  props: ["day_id"],
  data() {
    return {
      form: {
        day_id: this.day_id,
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
  methods: {
    async submitForm() {
      this.loading = true;
      this.error = null;
      const tripsStore = useTripsStore();

      try {
        await tripsStore.createDestination(this.form);
        this.$router.push(`/trip/${this.$route.params.trip_id}`);
      } catch (error) {
        console.error("Error adding destination:", error);
        this.error =
          "There was an error adding the destination. Please try again.";
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
    <h2>Add a New Destination</h2>

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
        <p>Adding destination, please wait...</p>
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
          Add Destination
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
