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


</script>

<style scoped>
</style>



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