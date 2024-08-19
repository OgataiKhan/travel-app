<script>
import AppHeader from "./components/AppHeader.vue";
import AppMain from "./components/AppMain.vue";
import AppFooter from "./components/AppFooter.vue";

export default {
  name: "AppComponent",
  components: {
    AppHeader,
    AppMain,
    AppFooter,
  },
};
</script>

<template class="page-content">
  <AppHeader />
  <AppMain />
  <AppFooter />
</template>

<style lang="scss" scoped>

  
</style>
