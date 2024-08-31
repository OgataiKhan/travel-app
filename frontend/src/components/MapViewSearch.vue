<script>
import tt from "@tomtom-international/web-sdk-maps";
import * as ttServices from "@tomtom-international/web-sdk-services";
import "@tomtom-international/web-sdk-maps/dist/maps.css";
import SearchBox from "@tomtom-international/web-sdk-plugin-searchbox";
import { markRaw } from "vue";

export default {
  name: "MapViewSearch",
  props: ["apiKey"],
  data() {
    return {
      map: null,
      searchBox: null,
      markers: [],
    };
  },
  mounted() {
    this.initializeMap();
  },
  methods: {
    initializeMap() {
      // Initialize map
      this.map = markRaw(tt.map({
        key: this.apiKey,
        container: this.$refs.map,
        center: [0, 0],
        zoom: 2,
      }));

      // Set up SearchBox options
      const searchBoxOptions = {
        searchOptions: {
          key: this.apiKey,
          language: "en-GB",
          limit: 5,
        },
        autocompleteOptions: {
          key: this.apiKey,
          language: "en-GB",
        },
        minNumberOfCharacters: 3,
        labelsFormat: "full",
        noResultsMessage: "No results found",
      };

      // Initialize SearchBox and mark it as raw to prevent Vue from making it reactive
      this.searchBox = markRaw(new SearchBox(ttServices.services, searchBoxOptions));
      this.map.addControl(this.searchBox, "top-left");

      // Listen to SearchBox events
      this.searchBox.on("tomtom.searchbox.resultsfound", this.handleResultsFound);
      this.searchBox.on("tomtom.searchbox.resultselected", this.handleResultSelection);
      this.searchBox.on("tomtom.searchbox.resultfocused", this.handleResultSelection);
      this.searchBox.on("tomtom.searchbox.resultscleared", this.handleResultClearing);
    },
    handleResultsFound(event) {
      const results = event.data.results.fuzzySearch.results;
      this.clearMarkers();
      results.forEach((result) => {
        const marker = new tt.Marker().setLngLat(result.position).addTo(this.map);
        this.markers.push(marker);
      });
    },
    handleResultSelection(event) {
      const result = event.data.result;
      if (result && result.position) {
        this.clearMarkers();
        const marker = new tt.Marker().setLngLat(result.position).addTo(this.map);
        this.markers.push(marker);
        this.map.flyTo({ center: result.position, zoom: 14 });
        this.$emit("location-selected", result);
      }
    },
    handleResultClearing() {
      this.clearMarkers();
    },
    clearMarkers() {
      this.markers.forEach((marker) => marker.remove());
      this.markers = [];
    },
  },
};


</script>

<template>
  <div>
    <!-- Map container -->
    <div ref="map" class="map-container"></div>
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
