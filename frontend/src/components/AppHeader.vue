<script>
import AppHeaderNavbar from "./AppHeaderNavbar.vue";

export default {
  name: "AppHeader",
  components: {
    AppHeaderNavbar,
  },
};
</script>

<template>
  <header>
    <div
      class="container d-flex justify-content-between align-items-center py-1 py-lg-2"
    >
      <div class="logo">
        <h1><router-link to="/">TravelApp</router-link></h1>
      </div>
      <AppHeaderNavbar />
    </div>
  </header>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;

header {
  background-color: $font-primary;

  .logo {
    font-style: italic;
    a {
      color: $font-secondary;
      text-decoration: none;
    }
  }
}
</style>
