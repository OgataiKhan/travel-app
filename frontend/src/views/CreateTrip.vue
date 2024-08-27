<script>
import { useTripsStore } from "../stores/trips";

export default {
  name: "CreateTrip",
  data() {
    return {
      form: {
        title: "",
        description: "",
        start_date: "",
        end_date: "",
      },
      loading: false,
      error: null,
    };
  },
  watch: {
    "form.start_date"(newStartDate) {
      if (newStartDate > this.form.end_date) {
        this.form.end_date = newStartDate;
      }
    },
    "form.end_date"(newEndDate) {
      if (newEndDate < this.form.start_date) {
        this.form.end_date = this.form.start_date;
      }
    },
  },
  methods: {
    handleFileUpload(event) {
      this.form.cover_img = event.target.files[0];
    },
    async submitForm() {
      this.loading = true;
      this.error = null;
      const tripsStore = useTripsStore();
      const formData = new FormData();

      formData.append("title", this.form.title);
      formData.append("description", this.form.description);
      formData.append("start_date", this.form.start_date);
      formData.append("end_date", this.form.end_date);
      formData.append("cover_img", this.form.cover_img);

      try {
        const newTripId = await tripsStore.createTrip(formData);
        this.$router.push(`/trip/${newTripId}`);
      } catch (error) {
        console.error("Error creating trip:", error);
        this.error = "There was an error creating the trip. Please try again.";
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<template>
  <div class="container py-5">
    <h2>Create a New Trip</h2>
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
      <div class="row mb-3">
        <div class="col">
          <label for="start_date" class="form-label">Start Date</label>
          <input
            type="date"
            class="form-control"
            id="start_date"
            v-model="form.start_date"
            required
          />
        </div>
        <div class="col">
          <label for="end_date" class="form-label">End Date</label>
          <input
            type="date"
            class="form-control"
            id="end_date"
            v-model="form.end_date"
            required
          />
        </div>
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
        <p>Creating trip and days, please wait...</p>
      </div>

      <div v-if="error" class="alert alert-danger mt-3">
        {{ error }}
      </div>

      <div class="d-flex justify-content-between mt-4">
        <!-- Buttons -->
        <router-link to="/" class="btn btn-home" aria-current="page">
          Home
        </router-link>
        <button type="submit" class="btn btn-submit" :disabled="loading">
          Create Trip
        </button>
        <!-- /Buttons -->
      </div>
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
