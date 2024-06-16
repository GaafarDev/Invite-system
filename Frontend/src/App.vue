<template>
  <div class="container">
      <NavBar/>
      <router-view></router-view>
      <PageFooter/>
  </div>
</template>

<script>
import NavBar from './components/NavBar.vue'
import PageFooter from './components/PageFooter.vue'

export default {
  name: 'App',
  components: {
    NavBar,
    PageFooter,
  }
}
</script>

<style scoped>
@import './assets/css/styles.css';
</style>