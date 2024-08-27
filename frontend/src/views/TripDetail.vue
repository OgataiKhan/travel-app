<script>
import { dateMixin } from "../mixins/dateMixin";
import { deleteTripMixin } from "../mixins/deleteTripMixin";
import { getImageUrlMixin } from "../mixins/getImageUrlMixin";
import { useTripsStore } from "../stores/trips";

export default {
  name: "TripsDetail",
  props: ["trip_id"],
  mixins: [dateMixin, deleteTripMixin, getImageUrlMixin],
  methods: {
    async deleteDay(dayId) {
      const tripsStore = useTripsStore();
      if (confirm("Are you sure you want to delete this day?")) {
        try {
          await tripsStore.deleteDay(dayId);
          console.log("Day deleted successfully!");
        } catch (error) {
          console.error("Error deleting day:", error);
          alert("Failed to delete day. Please try again.");
        }
      }
    },
  },
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
      <h2 class="text-center pt-4">{{ trip?.title }}</h2>
      <p class="trip-dates text-center pb-2">
        {{ formatDate(trip?.start_date) }} -
        {{ formatDate(trip?.end_date) }}
      </p>
      <div class="d-flex justify-content-center">
        <div class="cover-box mb-3">
          <img :src="trip.cover_img ? getImageUrl(trip.cover_img) : '/img/temp-thumbnail.jpg'" class="card-img-top" :alt="trip.title" />
        </div>
      </div>
      <p>{{ trip?.description }}</p>
    </div>
    <!-- Trip details -->
    <!-- No trip found message -->
    <div v-else class="text-center">
      <p class="no-trips-msg">Trip not found</p>
    </div>
    <!-- /No trip found message -->
    <!-- Days -->
    <div class="accordion">
      <div
        v-for="day in days"
        :key="day.id"
        class="accordion-item rounded my-4"
      >
        <h2 class="accordion-header">
          <button
            class="accordion-days-btn accordion-button rounded collapsed"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#panelsStayOpen-collapse' + day.id"
            aria-expanded="false"
            :aria-controls="'panelsStayOpen-collapse' + day.id"
          >
            <h5 class="card-title">
              {{ formatDate(day?.date) }} - Day {{ day.id + 1 }}
            </h5>
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
                  <div
                    v-for="destination in destinations[day.id]"
                    :key="destination.id"
                    class="accordion-item accordion-inner-bg rounded my-3"
                  >
                    <h2 class="accordion-header">
                      <button
                        class="accordion-destinations-btn accordion-button rounded collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="
                          '#destinationCollapse' + destination.id
                        "
                        aria-expanded="false"
                        :aria-controls="'destinationCollapse' + destination.id"
                      >
                        <h5 class="card-title">
                          {{ destination.name }} - <span>STARS</span>
                        </h5>
                      </button>
                    </h2>
                    <div
                      :id="'destinationCollapse' + destination.id"
                      class="accordion-collapse collapse"
                    >
                      <div class="accordion-body">
                        {{ destination.description }}
                      </div>
                      <!-- Buttons -->
                      <button type="button" class="btn btn-danger ms-3 mb-3">
                        Remove destination
                      </button>
                      <!-- /Buttons -->
                    </div>
                  </div>
                </div>
                <!-- /Destinations -->
                <!-- Buttons -->
                <a href="#" class="btn btn-adddestination"
                  >Add new destination</a
                >
                <!-- /Buttons -->
              </div>
              <div class="day-map-box col-12 col-lg-5">Map Tomtom</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Days -->
    <!-- Buttons -->
    <router-link to="/" class="btn btn-home my-4" aria-current="page"
      >Home</router-link
    >
    <button
      type="button"
      @click="deleteTrip(trip.id)"
      class="btn btn-danger ms-3"
    >
      Delete trip
    </button>
    <!-- Buttons -->
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

.trip-dates {
  font-size: 1.3rem;
  color: #585c5e;
}

.cover-box {
  max-width: 800px;
  img {
    max-height: 480px;
  }
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
