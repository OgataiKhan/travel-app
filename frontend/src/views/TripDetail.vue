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
    days() {
      const tripsStore = useTripsStore();
      return tripsStore.days;
    },
    destinations() {
      const tripsStore = useTripsStore();
      return tripsStore.destinations;
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
      <h2 class="text-center py-4">{{ trip?.title }}</h2>
      <p>{{ trip?.description }}</p>
      <p class="trip-dates">
        {{ formatDate(trip?.start_date) }} -
        {{ formatDate(trip?.end_date) }}
      </p>
    </div>
    <!-- Trip details -->
    <!-- No trip found message -->
    <div v-else class="text-center">
      <p class="no-trips-msg">Trip not found</p>
    </div>
    <!-- /No trip found message -->
    <!-- Days -->
    <div class="accordion">
      <div v-for="day in days" :key="day.id" class="accordion-item rounded my-4">
        <h2 class="accordion-header">
          <button
            class="accordion-days-btn accordion-button rounded collapsed"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#panelsStayOpen-collapse' + day.id"
            aria-expanded="false"
            :aria-controls="'panelsStayOpen-collapse' + day.id"
          >
            <h5 class="card-title">{{ formatDate(day?.date) }} - Day {{ day.id + 1 }}</h5>
          </button>
        </h2>
        <div
          :id="'panelsStayOpen-collapse' + day.id"
          class="accordion-collapse collapse"
        >
          <div class="accordion-body">
            <!-- Carousel -->
            <div class="d-flex justify-content-center pb-4">
              <div class="img-box">
                <img
                  src="/img/temp-thumbnail.jpg"
                  alt="TEMP"
                  class="img-fluid"
                />
              </div>
            </div>
            <!-- /Carousel -->
            <p>{{ day?.description }}</p>
            <div class="div-content row">
              <div class="day-description-box col-12 col-lg-7">
                <!-- Destinations -->
                <div class="accordion">
                  <div v-for="destination in destinations[day.id]" :key="destination.id" class="accordion-item accordion-inner-bg rounded my-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-destinations-btn accordion-button rounded collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="'#destinationCollapse' + destination.id"
                        aria-expanded="false"
                        :aria-controls="'destinationCollapse' + destination.id"
                      >
                        <h5 class="card-title">{{ destination.name }} - <span>STARS</span></h5>
                      </button>
                    </h2>
                    <div
                      :id="'destinationCollapse' + destination.id"
                      class="accordion-collapse collapse"
                    >
                      <div class="accordion-body">{{ destination.description }}</div>
                    </div>
                  </div>
                </div>
                <!-- /Destinations -->
                <a href="#" class="btn btn-adddestination ms-1 me-5">Add new destination</a>
              </div>
              <div class="day-map-box col-12 col-lg-5">Map Tomtom</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Days -->
    <router-link to="/" class="btn btn-home my-4" aria-current="page"
      >Home</router-link
    >
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;
@use "../scss/partial/mixins" as *;

.btn-home,
.btn-adddestination {
  @include button;
}

.no-trips-msg {
  @include message;
}

.accordion-days-btn.accordion-button:not(.collapsed) {
  background-color: #fff;
}

.accordion-button {
  box-shadow: none;
}

.accordion-inner-bg,
.accordion-destinations-btn {
  background-color: $bg-primary;
}

.img-box {
  max-width: 800px;
  max-height: 600px;
}

.day-map-box {
  background-color: yellow;
}
</style>
