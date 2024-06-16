// src/App.vue
<template>
  <div id="app">
    <AppEvents />
  </div>
</template>

<script>
import AppEvents from './components/AppEvents.vue';

export default {
  name: 'App',
  components: {
    AppEvents
  }
};
</script>

<style>
/* Add your styles here */
</style>
