<script>
import { dateMixin } from '../mixins/dateMixin';
import { deleteTripMixin } from "../mixins/deleteTripMixin";
import { useTripsStore } from "../stores/trips";
import AppMainJumbo from "../components/AppMainJumbo.vue";

export default {
  name: "TripsView",
  components: {
    AppMainJumbo,
  },
  mixins: [dateMixin, deleteTripMixin],
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
    <!-- No trips found message -->
    <p v-if="filteredTrips.length === 0" class="no-trips-msg text-center py-5">
      There's nothing here! Please try a different search or add new trips
    </p>
    <!-- /No trips found message -->
    <div class="row gy-4 pb-5">
      <!-- Trip card -->
      <div v-for="trip in filteredTrips" class="col col-lg-4 col-xxl-3">
        <div class="card" style="min-width: 18rem">
          <img src="/img/temp-thumbnail.jpg" class="card-img-top" :alt="trip.title" />
          <div class="card-body">
            <h5 class="card-title">{{ trip.title }}</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">
              {{ formatDate(trip.start_date) }} -
              {{ formatDate(trip.end_date) }}
            </h6>
            <p class="card-text">
              {{ trip.description }}
            </p>
            <!-- Buttons -->
            <a :href="`/trip/${trip.id}`" class="btn btn-tripcard">View trip</a>
            <button type="button" @click="deleteTrip(trip.id)" class="btn btn-danger ms-3">Delete trip</button>
            <!-- /Buttons -->
          </div>
        </div>
      </div>
      <!-- /Trip card -->
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;
@use "../scss/partial/mixins" as *;

.btn-tripcard {
  @include button;
}

.no-trips-msg{
  @include message;
}

</style>
