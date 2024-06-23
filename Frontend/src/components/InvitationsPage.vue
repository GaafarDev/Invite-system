<template>
    <div class="appContainer">
      <InvitationCard :userId="userId" />
    </div>
  </template>
  
  <script>
  import InvitationCard from './InvitationCard.vue';
  
  export default {
    components: {
      InvitationCard,
    },
    data() {
      return {
        userId: 2  // Replace this with the logic to get the current user's ID dynamically
      };
    }
  }
  </script>
  
  <style>
  .appContainer {
    display: flex;
    justify-content: center; /* Centers horizontally */
    align-items: center; /* Centers vertically */
    margin: 20px; /* Full viewport height */
  }
  </style>
  


<style>
.appContainer {
  display: flex;
  justify-content: center; /* Centers horizontally */
  align-items: center; /* Centers vertically */
  margin: 20px; /* Full viewport height */
}
</style>