<script>
import { dateMixin } from "../mixins/dateMixin";
import { deleteTripMixin } from "../mixins/deleteTripMixin";
import { getImageUrlMixin } from "../mixins/getImageUrlMixin";
import { useTripsStore } from "../stores/trips";
import MapView from "../components/MapView.vue";

export default {
  name: "TripsDetail",
  components: { MapView },
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
    async deleteDestination(destinationId, dayId) {
      const tripsStore = useTripsStore();
      if (confirm("Are you sure you want to delete this destination?")) {
        try {
          await tripsStore.deleteDestination(destinationId, dayId);
          console.log("Destination deleted successfully!");
        } catch (error) {
          console.error("Error deleting destination:", error);
          alert("Failed to delete destination. Please try again.");
        }
      }
    },
    async deleteImage(imageId, dayId) {
    const tripsStore = useTripsStore();
    if (confirm("Are you sure you want to delete this image?")) {
      try {
        await tripsStore.deleteDayImage(imageId, dayId);
        console.log("Image deleted successfully and images re-fetched.");
      } catch (error) {
        console.error("Error deleting image:", error);
        alert("Failed to delete image. Please try again.");
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
    dayImages() {
      const tripsStore = useTripsStore();
      return tripsStore.images;
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
          <img
            :src="
              trip.cover_img
                ? getImageUrl(trip.cover_img)
                : '/img/temp-thumbnail.jpg'
            "
            class="card-img-top"
            :alt="trip.title"
          />
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
        v-for="(day, index) in days"
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
              {{ formatDate(day?.date) }} - Day {{ index + 1 }}
            </h5>
          </button>
        </h2>
        <div
          :id="'panelsStayOpen-collapse' + day.id"
          class="accordion-collapse collapse"
        >
          <div class="accordion-body">
            <p>{{ day?.description }}</p>
            <div class="div-content row">
              <div
                :class="[
                  'day-description-box',
                  'col-12',
                  dayImages[day.id]?.length > 0 ? 'col-lg-5' : '',
                ]"
              >
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
                      <router-link
                        :to="{
                          name: 'UpdateDestination',
                          params: {
                            trip_id: trip.id,
                            day_id: day.id,
                            destination_id: destination.id,
                          },
                        }"
                        class="btn btn-update ms-3 mb-3"
                      >
                        Edit destination
                      </router-link>
                      <button
                        type="button"
                        @click="deleteDestination(destination.id, day.id)"
                        class="btn btn-danger ms-3 mb-3"
                      >
                        Remove destination
                      </button>
                      <!-- /Buttons -->
                    </div>
                  </div>
                </div>
                <!-- /Destinations -->
              </div>
              <div class="col">
                <!-- Carousel -->
                <div
                  v-if="dayImages[day.id]?.length > 0"
                  :id="'dayImagesCarousel' + day.id"
                  class="carousel slide mb-4"
                  data-bs-ride="true"
                >
                  <div class="carousel-indicators">
                    <button
                      v-for="(image, imageIndex) in dayImages[day.id] || []"
                      :key="imageIndex"
                      :data-bs-target="'#dayImagesCarousel' + day.id"
                      :data-bs-slide-to="imageIndex"
                      :class="{ active: imageIndex === 0 }"
                      :aria-label="'Slide ' + (imageIndex + 1)"
                      :aria-current="imageIndex === 0 ? 'true' : ''"
                    ></button>
                  </div>
                  <div class="carousel-inner">
                    <div
                      v-for="(image, imageIndex) in dayImages[day.id || []]"
                      :key="imageIndex"
                      :class="['carousel-item', { active: imageIndex === 0 }]"
                    >
                      <!-- "X" button for deleting the image -->
                      <button @click.stop="deleteImage(image.id, day.id)"
                        class="delete-image-btn"
                        aria-label="Delete image"
                      >
                        &times;
                      </button>
                      <!-- /"X" button for deleting the image -->
                      <img
                        :src="getImageUrl(image.image_path)"
                        class="d-block w-100"
                        :alt="
                          'Image ' + (imageIndex + 1) + ' for Day ' + day.id
                        "
                      />
                    </div>
                  </div>
                  <button
                    class="carousel-control-prev"
                    type="button"
                    :data-bs-target="'#dayImagesCarousel' + day.id"
                    data-bs-slide="prev"
                  >
                    <span
                      class="carousel-control-prev-icon"
                      aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button
                    class="carousel-control-next"
                    type="button"
                    :data-bs-target="'#dayImagesCarousel' + day.id"
                    data-bs-slide="next"
                  >
                    <span
                      class="carousel-control-next-icon"
                      aria-hidden="true"
                    ></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
                <!-- /Carousel -->
              </div>
            </div>
            <!-- Buttons -->
            <router-link
              :to="`/trip/${trip_id}/day/${day.id}/add-destination`"
              class="btn btn-adddestination"
            >
              Add new destination
            </router-link>
            <router-link
              :to="{
                name: 'UpdateDay',
                params: { trip_id: trip_id, day_id: day.id },
              }"
              class="btn btn-update ms-3"
            >
              Edit day
            </router-link>
            <!-- /Buttons -->
          </div>
        </div>
      </div>
    </div>
    <!-- /Days -->
    <!-- Buttons -->
    <div class="my-4">
      <router-link to="/" class="btn btn-home" aria-current="page"
        >Home</router-link
      >
      <router-link :to="`/trip/${trip_id}/update`" class="btn btn-update ms-3"
        >Edit trip</router-link
      >
      <button
        type="button"
        @click="deleteTrip(trip.id)"
        class="btn btn-danger ms-3"
      >
        Delete trip
      </button>
    </div>
    <!-- Buttons -->
    <!-- Map -->
    <div class="d-flex justify-content-center mt-2 mb-5">
      <div class="day-map-box">
        <MapView />
      </div>
    </div>
    <!-- /Map -->
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;
@use "../scss/partial/mixins" as *;

.btn-home,
.btn-adddestination {
  @include button;
}

.btn-update {
  background-color: $bg-tertiary;
  color: $font-secondary;
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
  width: 100%;
}

.carousel-inner {
  height: 0;
  padding-bottom: 66%; /* this sets carousel aspect ratio (3:2 here) */
}

.carousel-item {
  position: absolute !important;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.carousel-item img {
  height: 100%;
  object-fit: cover;
}

.delete-image-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  color: $font-secondary;
  font-size: 24px;
  cursor: pointer;
  z-index: 2;
}

.delete-image-btn:hover {
  color: #ff0000;
}
</style>
