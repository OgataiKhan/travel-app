import { createRouter, createWebHistory } from 'vue-router';
import TripsView from '../views/TripsView.vue';
import TripDetail from '../views/TripDetail.vue';
import DayDetail from '../views/DayDetail.vue';

const routes = [
  {
    path: '/',
    name: 'TripsView',
    component: TripsView,
  },
  {
    path: '/trip/:trip_id',
    name: 'TripDetail',
    component: TripDetail,
  },
  {
    path: '/trip/:trip_id/day/:day_id',
    name: 'DayDetail',
    component: DayDetail,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;