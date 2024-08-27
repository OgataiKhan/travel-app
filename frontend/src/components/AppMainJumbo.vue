<script>
export default {
  name: "AppMainJumbo",
};
</script>

<template>
  <div class="jumbo">
    <div class="gradient">
      <div class="container">
        <div class="textbox">
          <h2>Explore the World</h2>
          <router-link to="/create-trip" class="btn">Create New Trip</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@use "../scss/partial/variables" as *;

.jumbo {
  min-height: 400px;
  background-image: url("/img/travel-jumbo.jpeg");
  background-size: cover;
  background-position: center;
  .gradient {
    min-height: 400px;
    background: linear-gradient(
      0deg,
      rgba(0, 0, 0, 0.4) 10%,
      rgba(0, 0, 0, 0) 40%
    );
    color: $font-secondary;
    position: relative;
    .textbox {
      position: absolute;
      bottom: 30px;
      h2 {
        font-family: "Rakkas", serif;
        font-size: 4rem;
      }
      .btn {
        background-color: $bg-primary;
        color: $font-primary;
        font-weight: 500;
        margin-top: 10px;
        padding: 10px 30px;
      }
    }
  }
}
</style>
