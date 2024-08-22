<script>
import { dateMixin } from "../mixins/dateMixin";
import { useTripsStore } from "../stores/trips";

export default {
  name: "TripsDetail",
  props: ["trip_id"],
  mixins: [dateMixin],
  computed: {
    trip() {
      const tripsStore = useTripsStore();
      return tripsStore.currentTrip;
    },
  },
  created() {
    const tripsStore = useTripsStore();
    tripsStore.fetchTrip(this.trip_id);
  },
};
</script>

<template>
  <div class="container">
    <!-- Trip details -->
    <div v-if="trip">
      <h2 class="text-center">{{ trip?.title }}</h2>
      <p>{{ trip?.description }}</p>
      <p>
        Dates: {{ formatDate(trip?.start_date) }} -
        {{ formatDate(trip?.end_date) }}
      </p>
    </div>
    <!-- Trip details -->
    <!-- No trip found message -->
     <div v-else class="text-center">
      <p class="no-trips-msg">Trip not found</p>
     </div>
    <!-- /No trip found message -->
    <router-link to="/" class="btn btn-home" aria-current="page"
      >Home</router-link
    >
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;
@use "../scss/partial/mixins" as *;

.btn-home {
  @include button;
}

.no-trips-msg {
  @include message;
}
</style>
