<template>
  <div>
    <h1>Events</h1>
    <ul>
      <li v-for="event in events" :key="event.id">{{ event.title }}</li>
    </ul>
  </div>
</template>

<script>
import apiClient from '@/services/api';

export default {
  data() {
    return {
      events: []
    };
  },
  created() {
    this.fetchEvents();
  },
  methods: {
    async fetchEvents() {
      try {
        const response = await apiClient.get('/events');
        this.events = response.data;
      } catch (error) {
        console.error('Failed to fetch events:', error);
      }
    }
  }
};
</script>
