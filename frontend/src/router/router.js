import { createRouter, createWebHistory } from "vue-router";
import TripsView from "../views/TripsView.vue";
import TripDetail from "../views/TripDetail.vue";
import DayDetail from "../views/DayDetail.vue";
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
  },
  {
    path: "/trip/:trip_id/day/:day_id",
    name: "DayDetail",
    component: DayDetail,
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
