import { createRouter, createWebHistory } from "vue-router";
import TripsView from "../views/TripsView.vue";
import TripDetail from "../views/TripDetail.vue";
import CreateTrip from "../views/CreateTrip.vue";
import UpdateTrip from "../views/UpdateTrip.vue";
import UpdateDay from '../views/UpdateDay.vue';
import CreateDestination from "../views/CreateDestination.vue";
import UpdateDestination from '../views/UpdateDestination.vue';
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
    path: '/trip/:trip_id/day/:day_id/edit-day',
    name: 'UpdateDay',
    component: UpdateDay,
    props: true,
  },
  {
    path: "/trip/:trip_id/day/:day_id/add-destination",
    name: "CreateDestination",
    component: CreateDestination,
    props: true,
  },
  {
    path: '/trip/:trip_id/day/:day_id/edit-destination/:destination_id',
    name: 'UpdateDestination',
    component: UpdateDestination,
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
