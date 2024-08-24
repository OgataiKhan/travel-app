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
      <div v-for="(day, index) in days" :key="day.id" class="accordion-item rounded my-4">
        <h2 class="accordion-header">
          <button
            class="accordion-days-btn accordion-button rounded collapsed"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#panelsStayOpen-collapse' + index"
            aria-expanded="false"
            :aria-controls="'panelsStayOpen-collapse' + index"
          >
            <h5 class="card-title">{{ formatDate(day?.date) }} - Day {{ index + 1 }}</h5>
          </button>
        </h2>
        <div
          :id="'panelsStayOpen-collapse' + index"
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
                  <div class="accordion-item accordion-inner-bg rounded my-3">
                    <h2 class="accordion-header">
                      <button
                        class="accordion-destinations-btn accordion-button rounded collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#panelsStayOpenDestination-collapseOne"
                        aria-expanded="false"
                        aria-controls="panelsStayOpenDestination-collapseOne"
                      >
                        <h5 class="card-title">Destination Title - <span>STARS</span></h5>
                      </button>
                    </h2>
                    <div
                      id="panelsStayOpenDestination-collapseOne"
                      class="accordion-collapse collapse"
                    >
                      <div class="accordion-body">Destination description</div>
                    </div>
                  </div>
                </div>
                <!-- /Destinations -->
              </div>
              <div class="day-map-box col-12 col-lg-5">Map Tomtom</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Days -->
    <a href="#" class="btn btn-addday me-3">Add day</a>
    <router-link to="/" class="btn btn-home my-4" aria-current="page"
      >Home</router-link
    >
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;
@use "../scss/partial/mixins" as *;

.btn-home,
.btn-addday {
  @include button;
}

.no-trips-msg {
  @include message;
}

.accordion-days-btn.accordion-button:not(.collapsed) {
  background-color: #fff;
}

// .accordion-destinations-btn.accordion-button:not(.collapsed) {
//   background-color: $bg-primary;
// }

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
