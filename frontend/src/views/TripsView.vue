<script>
import AppMainJumbo from "../components/AppMainJumbo.vue";

export default {
  name: "TripsView",
  components: {
    AppMainJumbo,
  },
};
</script>

<template>
  <AppMainJumbo />
  <div class="container">
    <div class="search-box input-group input-group-lg py-4">
      <input
        type="text"
        class="form-control"
        placeholder="Search trips..."
        aria-label="Trip search"
      />
    </div>
    <div class="row gy-4 pb-5">
      <div class="col col-lg-4 col-xxl-3">
        <div class="card" style="min-width: 18rem">
          <img src="/img/temp-thumbnail.jpg" class="card-img-top" alt="..." />
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">
              11/09/2024 - 15/09/2024
            </h6>
            <p class="card-text">
              Some quick example text to build on the card title and make up the
              bulk of the card's content.
            </p>
            <a href="#" class="btn btn-tripcard">Go somewhere</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;

.btn-tripcard {
  background-color: $bg-secondary;
  color: $font-secondary;
}

</style>
