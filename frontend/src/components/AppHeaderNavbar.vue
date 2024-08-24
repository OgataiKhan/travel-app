<script>
export default {
  name: "AppHeaderNavbar",
};
</script>

<template>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <button
        class="navbar-toggler ms-auto"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div
        class="collapse navbar-collapse text-end"
        id="navbarSupportedContent"
      >
        <ul class="navbar-nav me-auto mb-lg-0 mt-2">
          <li class="nav-item rounded">
            <router-link to="/" class="nav-link" aria-current="page">Home</router-link>
          </li>
          <li class="nav-item rounded">
            <a class="nav-link" href="#">New Trip</a>
          </li>
          <li class="nav-item rounded">
            <a class="nav-link" href="#">About</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style lang="scss" scoped>
@use '../scss/partial/variables' as *;

li a.nav-link {
  color: $font-secondary;
}

@media only screen and (min-width: 992px) {
  ul li:hover {
    background: #dedbcf;
  }
}

</style>
