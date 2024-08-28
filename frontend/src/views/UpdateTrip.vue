<script>
import { useTripsStore } from "../stores/trips";

export default {
  name: "UpdateTrip",
  data() {
    return {
      form: {
        title: "",
        description: "",
        cover_img: null,
      },
      loading: false,
      error: null,
      tripId: this.$route.params.trip_id,
    };
  },
  computed: {
    tripsStore() {
      return useTripsStore();
    },
  },
  watch: {
    'tripsStore.currentTrip': {
      handler(trip) {
        if (trip) {
          this.form.title = trip.title;
          this.form.description = trip.description;
        }
      },
      immediate: true
    }
  },
  methods: {
    handleFileUpload(event) {
      this.form.cover_img = event.target.files[0];
    },
    async fetchTripData() {
      try {
        await this.tripsStore.fetchTrip(this.tripId);
      } catch (error) {
        console.error("Error fetching trip data:", error);
        this.error = "Could not load trip data.";
      }
    },
    async submitForm() {
      this.loading = true;
      this.error = null;

      const formData = new FormData();
      formData.append("id", this.tripId);
      formData.append("title", this.form.title);
      formData.append("description", this.form.description);
      if (this.form.cover_img) {
        formData.append("cover_img", this.form.cover_img);
      }

      console.log([...formData]);

      try {
        await this.tripsStore.updateTrip(formData);
        this.$router.push(`/trip/${this.tripId}`);
      } catch (error) {
        console.error("Error updating trip:", error);
        this.error = "There was an error updating the trip. Please try again.";
      } finally {
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchTripData();
  },
};
</script>

<template>
  <div class="container py-5">
    <h2>Update Trip</h2>
    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="title" class="form-label">Trip Title</label>
        <input
          type="text"
          class="form-control"
          id="title"
          v-model="form.title"
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

      <div class="mb-3">
        <label for="cover-img" class="form-label">Upload Cover Image</label>
        <input
          @change="handleFileUpload"
          accept="image/*"
          class="form-control"
          type="file"
          id="cover-img"
        />
      </div>

      <div v-if="loading" class="mt-3">
        <p>Updating trip, please wait...</p>
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
          Update Trip
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
