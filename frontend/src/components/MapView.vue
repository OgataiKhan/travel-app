<script>
import tt from '@tomtom-international/web-sdk-maps';
import '@tomtom-international/web-sdk-maps/dist/maps.css';
import { useTripsStore } from "../stores/trips";
import { markRaw, watch } from "vue";

export default {
  name: 'MapView',
  data() {
    return {
      map: null,
      tripsStore: useTripsStore(),
    };
  },
  mounted() {
    this.loadMap();
    this.watchDestinations();
  },
  methods: {
    loadMap() {
      // Initialize map
      this.map = markRaw(tt.map({
        key: import.meta.env.VITE_TOMTOM_API_KEY,
        container: this.$refs.map,
        center: [0, 0],
        zoom: 2,
      }));

      this.map.on('load', () => {
        this.loadAllDestinations();
      });
    },
    loadAllDestinations() {
      const allDestinations = Object.values(this.tripsStore.destinations).flat();
      if (!allDestinations) return;

      allDestinations.forEach(destination => {
        const { latitude, longitude, name } = destination;
        if (latitude && longitude) {
          const marker = new tt.Marker()
            .setLngLat([longitude, latitude])
            .addTo(this.map);

          const popup = new tt.Popup({ offset: 35 }).setText(name);
          marker.setPopup(popup);
        }
      });

      // Adjust map view to fit all markers
      if (allDestinations.length > 0) {
        const bounds = new tt.LngLatBounds();
        allDestinations.forEach(destination => {
          if (destination.latitude && destination.longitude) {
            bounds.extend([destination.longitude, destination.latitude]);
          }
        });
        this.map.fitBounds(bounds, { padding: 60 });
      }
    },
    watchDestinations() {
      watch(
        () => this.tripsStore.destinations,
        (newDestinations, oldDestinations) => {
          if (newDestinations && Object.keys(newDestinations).length > 0) {
            this.loadAllDestinations();
          }
        },
        { deep: true }
      );
    },
    addMarker(latitude, longitude, name) {
      // Add marker for selected location
      const marker = new tt.Marker()
        .setLngLat([longitude, latitude])
        .addTo(this.map);

      const popup = new tt.Popup({ offset: 35 }).setText(name);
      marker.setPopup(popup);

      // Center map on selected location
      this.map.flyTo({ center: [longitude, latitude], zoom: 14 });
    },
    resizeMap() {
      if (this.map) {
        this.map.resize();
      }
    }
  }
};
</script>

<template>
  <div class="map-container">
    <div ref="map" class="map"></div>
  </div>
</template>

<style scoped>
.map-container {
  position: relative;
  width: 100%;
  height: 500px;
}

.map {
  width: 100%;
  height: 100%;
}
</style>
