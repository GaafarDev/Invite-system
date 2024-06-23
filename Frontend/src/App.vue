<template>
  <div class="container">
    <NavBar v-if="showNavBarFooter" />
    <router-view></router-view>
    <PageFooter v-if="showNavBarFooter" />
  </div>
</template>

<script>
import NavBar from './components/NavBar.vue';
import PageFooter from './components/PageFooter.vue';

export default {
  name: 'App',
  components: {
    NavBar,
    PageFooter,
  },
  computed: {
    showNavBarFooter() {
      return !this.$route.meta.hideNavBarFooter;
    }
  }
}
</script>

<style scoped>
@import './assets/css/styles.css';
</style>
