<script>

export default {
  name: 'AppFooter',
};

</script>

<template>
  <footer class="text-center py-5">
    <div class="container">
      Made with &hearts; by Kevin
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