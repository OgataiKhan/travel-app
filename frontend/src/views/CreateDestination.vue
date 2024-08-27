<script>
import { useTripsStore } from "../stores/trips";

export default {
  name: "CreateDestination",
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
      loading: false,
      error: null,
    };
  },
  methods: {
    async submitForm() {
      this.loading = true;
      this.error = null;
      const tripsStore = useTripsStore();

      console.log("Form Data:", this.form);

      try {
        await tripsStore.createDestination(this.form);
        this.$router.push(`/trip/${tripsStore.currentTrip.id}`);
      } catch (error) {
        console.error("Error adding destination:", error);
        this.error =
          "There was an error adding the destination. Please try again.";
      } finally {
        this.loading = false;
      }
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
        <label for="latitude" class="form-label">Latitude</label>
        <input
          type="text"
          class="form-control"
          id="latitude"
          v-model="form.latitude"
        />
      </div>
      <div class="mb-3">
        <label for="longitude" class="form-label">Longitude</label>
        <input
          type="text"
          class="form-control"
          id="longitude"
          v-model="form.longitude"
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
