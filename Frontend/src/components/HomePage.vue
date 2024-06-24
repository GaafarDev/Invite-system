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
    <div class="events-page">
      <h1>All Events</h1>
      <div class="filters">
        <button class="filter-btn">All</button>
        <button class="filter-btn">Today</button>
        <button class="filter-btn">Tomorrow</button>
        <button class="filter-btn">This Weekend</button>
        <button class="filter-btn">Free</button>
      </div>

      <div class="upcoming-events">
        <h2>Upcoming Events</h2>
        <div class="event-cards">
          <EventCard
            v-for="(event) in displayedUpcomingEvents"
            :key="event.id"
            @click="goToEventDetails(event)"
            :eventType="event.category"
            :eventMonth="getMonth(event.start_datetime)"
            :eventDays="getDays(event.start_datetime, event.end_datetime)"
            :eventTitle="event.title"
            :eventLocation="event.location"
            :eventTime="getTime(event.start_datetime, event.end_datetime)"
            :eventPrice="getPrice(event.tickets)"
            :eventInterested="event.interests.length"
          />
        </div>
        <button v-if="showMoreUpcomingButton" @click="loadMoreUpcoming" class="see-more-btn">See More</button>
      </div>

      <div class="past-events">
        <h2>Past Events</h2>
        <div class="event-cards">
          <EventCard
            v-for="(event) in displayedPastEvents"
            :key="event.id"
            @click="goToEventDetails(event)"
            :eventType="event.category"
            :eventMonth="getMonth(event.start_datetime)"
            :eventDays="getDays(event.start_datetime, event.end_datetime)"
            :eventTitle="event.title"
            :eventLocation="event.location"
            :eventTime="getTime(event.start_datetime, event.end_datetime)"
            :eventPrice="getPrice(event.tickets)"
            :eventInterested="event.interests.length"
          />
        </div>
        <button v-if="showMorePastButton" @click="loadMorePast" class="see-more-btn">See More</button>
      </div>
    </div>
  </div>
</template>

<script>
import EventCategories from './EventCategories.vue';
import EventCard from './EventCard.vue';
import apiClient from '../services/api';

export default {
  components: {
    EventCategories,
    EventCard,
  },
  data() {
    return {
      events: [],
      searchQuery: '',
      filteredEvents: [],
      displayedUpcomingEvents: [],
      displayedPastEvents: [],
      upcomingLimit: 6,
      pastLimit: 6,
    };
  },
  computed: {
    showMoreUpcomingButton() {
      return this.displayedUpcomingEvents.length < this.upcomingEvents.length;
    },
    showMorePastButton() {
      return this.displayedPastEvents.length < this.pastEvents.length;
    },
    upcomingEvents() {
      const now = new Date();
      return this.events.filter(event => new Date(event.start_datetime) > now).sort((a, b) => new Date(a.start_datetime) - new Date(b.start_datetime));
    },
    pastEvents() {
      const now = new Date();
      return this.events.filter(event => new Date(event.end_datetime) < now).sort((a, b) => new Date(b.start_datetime) - new Date(a.start_datetime));
    }
  },
  methods: {
    async fetchEvents() {
      try {
        const response = await apiClient.get('/api/events');
        this.events = response.data;
        this.updateDisplayedUpcomingEvents();
        this.updateDisplayedPastEvents();
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
    loadMoreUpcoming() {
      this.upcomingLimit += 6;
      this.updateDisplayedUpcomingEvents();
    },
    loadMorePast() {
      this.pastLimit += 6;
      this.updateDisplayedPastEvents();
    },
    updateDisplayedUpcomingEvents() {
      this.displayedUpcomingEvents = this.upcomingEvents.slice(0, this.upcomingLimit);
    },
    updateDisplayedPastEvents() {
      this.displayedPastEvents = this.pastEvents.slice(0, this.pastLimit);
    },
    getMonth(datetime) {
      const date = new Date(datetime);
      return date.toLocaleString('default', { month: 'short' }).toUpperCase();
    },
    getDays(start, end) {
      const startDate = new Date(start);
      const endDate = new Date(end);
      if (startDate.getDate() === endDate.getDate()) {
        return startDate.getDate();
      }
      return `${startDate.getDate()} - ${endDate.getDate()}`;
    },
    getTime(start, end) {
      const startTime = new Date(start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      const endTime = new Date(end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      return `${startTime} - ${endTime}`;
    },
    getPrice(tickets) {
      if (tickets.length === 0) {
        return 'Free';
      }
      return `RM ${Math.min(...tickets.map(ticket => ticket.ticket_price))}`;
    },
    goToEventDetails(event) {
      this.$router.push({ name: 'ViewEventDetails', params: { eventId: event.id } });
    }
  },
  mounted() {
    this.fetchEvents();
  },
};
</script>

<style scoped>
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
  border-radius: 0 0 5px 5px;
}

.dropdown ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.dropdown ul li {
  padding: 10px;
  cursor: pointer;
  border-bottom: 1px solid #eee;
}

.dropdown ul li:hover {
  background: #f5f5f5;
}

.dropdown .no-events {
  padding: 10px;
}

.events-page {
  padding: 2em 0;
}

.filters {
  display: flex;
  justify-content: center;
  margin-bottom: 1em;
}

.filter-btn {
  margin: 0 0.5em;
  padding: 0.5em 1em;
  border: 1px solid #2D2C3C;
  border-radius: 20px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.filter-btn:hover {
  background-color: #ffdd57;
  border-color: #ffdd57;
}

.upcoming-events,
.past-events {
  margin: 2em 0;
}

.event-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.see-more-btn {
  padding: 0.5em 2em;
  border: none;
  border-radius: 5px;
  background-color: #ffdd57;
  cursor: pointer;
  transition: background-color 0.3s;
}

.see-more-btn:hover {
  background-color: #ffcc00;
}
</style>
