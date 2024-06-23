<template>
  <div class="home-page">
    <div class="banner">
      <img src="../assets/Images/homeBanner.jpg" alt="homeBanner" class="homeBanner">
      <div class="banner-content">
        <h1>Don't miss out!</h1>
        <h2>Explore the <span class="highlight">vibrant events</span> happening locally and globally.</h2>
        <div class="search-bar">
          <input 
            type="text" 
            placeholder="Search Events Name..." 
            v-model="searchQuery"
            @keyup="dynamicSearch" />
          <button @click="searchEvents">Search</button>
          <div class="dropdown" v-if="searchQuery.length > 2">
            <ul v-if="filteredEvents.length">
              <li v-for="event in filteredEvents" :key="event.id" @click="selectEvent(event)">
                {{ event.title }}
              </li>
            </ul>
            <div v-else class="no-events">
              No events found
            </div>
          </div>
        </div>
      </div>
    </div>
    <EventCategories />
    <OrganizerEventsPage/>
  </div>
</template>


<script>
import EventCategories from './EventCategories.vue';
import apiClient from '../services/api';
import OrganizerEventsPage from './OrganizerEventsPage.vue';

export default {
  components: {
    EventCategories,
    OrganizerEventsPage,
  },
  data() {
    return {
      events: [],
      searchQuery: '',
      filteredEvents: [],
    };
  },
  mounted() {
    this.fetchEvents();
  },
  methods: {
    async fetchEvents() {
      try {
        const response = await apiClient.get('/api/events');
        this.events = response.data;
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    },
    async dynamicSearch() {
      if (this.searchQuery.length > 2) {
        this.filteredEvents = this.events.filter(event => 
          event.title.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
      } else {
        this.filteredEvents = [];
      }
    },
    selectEvent(event) {
      this.$router.push({ name: 'ViewEventDetails', params: { eventId: event.id } });
    },
    async searchEvents() {
      try {
        const response = await apiClient.get(`/api/events?search=${this.searchQuery}`);
        this.events = response.data;
      } catch (error) {
        console.error('Error searching events:', error);
      }
    },
  },
};
</script>

<style scoped>
.dropdown {
  position: absolute;
  top: 40px;
  left: 79px;
  background: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 500px;
  max-height: 200px;
  overflow-y: auto;
  z-index: 1000;
  color: #2D2C3C;
  text-align: left;
}

.dropdown ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.dropdown li {
  padding: 10px;
  cursor: pointer;
}

.dropdown li:hover {
  background-color: #f0f0f0;
}

.no-events {
  padding: 10px;
  color: #2D2C3C; 
  text-align: center;
}

.home-page {
  text-align: center;
}

.banner {
  position: relative;
  width: 100%;
  height: 20em;
}

.homeBanner {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.banner-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  text-align: center;
}

.banner-content h1 {
  font-size: 2.5em;
  margin: 0;
}

.banner-content h2 {
  font-size: 1.5em;
  margin: 0.5em 0;
}

.banner-content .highlight {
  color: #ffdd57;
}

.search-bar {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 1em;
  position: relative;
}

.search-bar input {
  padding: 0.8em;
  width: 500px;
  border: none;
  border-radius: 5px 0 0 5px;
}

.search-bar button {
  padding: 0.8em 1em;
  border: none;
  border-radius: 0 5px 5px 0;
  background-color: #ffdd57;
  cursor: pointer;
  transition: background-color 0.3s;
}

.search-bar button:hover {
  background-color: #ffcc00;
}

</style>
