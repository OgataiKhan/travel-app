import { useTripsStore } from "../stores/trips";

export const getImageUrlMixin = {
  computed: {
    backendUrl() {
      const tripsStore = useTripsStore();
      return tripsStore.BACKEND_URL;
    },
  },
  methods: {
    getImageUrl(imagePath) {
      return `${this.backendUrl}uploads/${imagePath}`;
    },
  },
};
