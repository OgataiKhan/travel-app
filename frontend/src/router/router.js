import { createRouter, createWebHistory } from "vue-router";
import TripsView from "../views/TripsView.vue";
import TripDetail from "../views/TripDetail.vue";
import CreateTrip from "../views/CreateTrip.vue";
import UpdateTrip from "../views/UpdateTrip.vue";
import CreateDestination from "../views/CreateDestination.vue";
import ErrorPage from "../views/ErrorPage.vue";

const routes = [
  {
    path: "/",
    name: "TripsView",
    component: TripsView,
  },
  {
    path: "/trip/:trip_id",
    name: "TripDetail",
    component: TripDetail,
    props: true,
  },
  {
    path: "/create-trip",
    name: "CreateTrip",
    component: CreateTrip,
  },
  {
    path: "/trip/:trip_id/update",
    name: "UpdateTrip",
    component: UpdateTrip,
    props: true,
  },
  {
    path: "/trip/:trip_id/day/:day_id/add-destination",
    name: "CreateDestination",
    component: CreateDestination,
    props: true,
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/404",
  },
  {
    path: "/404",
    name: "404",
    component: ErrorPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
