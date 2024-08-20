<script>

export default {
  name: 'AppFooter',
};

</script>

<template>
  <footer class="py-5">
    <div class="container">
      Footer
    </div>
  </footer>
</template>

<style lang="scss" scoped>
@use '../scss/partial/variables' as *;

footer {
  background-color: $font-primary;
  color: $font-secondary;
}

</style>