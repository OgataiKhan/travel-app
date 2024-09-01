<script>
import { dateMixin } from "../mixins/dateMixin";
import { useTripsStore } from "../stores/trips";

export default {
  name: "UpdateDay",
  mixins: [dateMixin],
  data() {
    return {
      form: {
        id: this.$route.params.day_id,
        description: "",
        images: [] // To hold the selected images
      },
      dayDate: "",
      loading: false,
      error: null,
    };
  },
  mounted() {
    this.fetchDayDetails();
  },
  methods: {
    async fetchDayDetails() {
      const tripsStore = useTripsStore();
      this.loading = true;
      this.error = null;

      try {
        // Fetch day details from store
        const day = await tripsStore.fetchDay(this.form.id);
        if (day) {
          this.form.description = day.description;
          this.dayDate = this.formatDate(day.date);
        }
      } catch (error) {
        console.error("Error fetching day details:", error);
        this.error = "There was an error fetching the day details.";
      } finally {
        this.loading = false;
      }
    },
    handleFileChange(event) {
      this.form.images = event.target.files; // Store the selected files
    },
    async submitForm() {
      this.loading = true;
      this.error = null;
      const tripsStore = useTripsStore();

      try {
        const formData = new FormData();
        formData.append("id", this.form.id);
        formData.append("description", this.form.description);

        // Append each selected image to the form data
        for (let i = 0; i < this.form.images.length; i++) {
          formData.append("images[]", this.form.images[i]);
        }

        await tripsStore.updateDay(formData);
        this.$router.push(`/trip/${this.$route.params.trip_id}`);
      } catch (error) {
        console.error("Error updating day:", error);
        this.error = "There was an error updating the day. Please try again.";
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<template>
  <div class="container py-5">
    <h2>Edit Day - {{ dayDate }}</h2>

    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          class="form-control"
          id="description"
          v-model="form.description"
          rows="3"
          required
        ></textarea>
      </div>

      <div class="mb-3">
        <label for="images" class="form-label">Upload Images</label>
        <input
          type="file"
          accept="image/*"
          class="form-control"
          id="images"
          @change="handleFileChange"
          multiple
        />
      </div>

      <div v-if="loading" class="mt-3">
        <p>Updating day, please wait...</p>
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
          Update Day
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