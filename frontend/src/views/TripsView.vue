<script>
import { format } from 'date-fns';
import { useTripsStore } from "../stores/trips";
import AppMainJumbo from "../components/AppMainJumbo.vue";

export default {
  name: "TripsView",
  components: {
    AppMainJumbo,
  },
  data() {
    return {
      searchQuery: "",
    };
  },
  computed: {
    filteredTrips() {
      const tripsStore = useTripsStore();
      if (!this.searchQuery) {
        return tripsStore.trips;
      }
      return tripsStore.trips.filter((trip) =>
        trip.title.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    },
  },
  methods: {
    formatDate(date) {
      return date ? format(new Date(date), 'dd/MM/yyyy') : '';
    }
  },
  created() {
    const tripsStore = useTripsStore();
    tripsStore.fetchTrips();
  },
};
</script>

<template>
  <!-- Jumbotron -->
  <AppMainJumbo />
  <!-- /Jumbotron -->
  <div class="container">
    <!-- Search bar -->
    <div class="search-box input-group input-group-lg py-4">
      <input
        v-model="searchQuery"
        type="text"
        class="form-control"
        placeholder="Search trips..."
        aria-label="Trip search"
      />
    </div>
    <!-- /Search bar -->
    <div class="row gy-4 pb-5">
      <!-- Trip card -->
      <div v-for="trip in filteredTrips" class="col col-lg-4 col-xxl-3">
        <div class="card" style="min-width: 18rem">
          <img src="/img/temp-thumbnail.jpg" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">{{ trip.title }}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">
              {{ formatDate(trip.start_date) }} - {{ formatDate(trip.end_date) }}
            </h6>
            <p class="card-text">
              {{ trip.description }}
            </p>
            <a href="#" class="btn btn-tripcard">Go somewhere</a>
          </div>
        </div>
      </div>
      <!-- /Trip card -->
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;

.btn-tripcard {
  background-color: $bg-secondary;
  color: $font-secondary;
}
</style>
