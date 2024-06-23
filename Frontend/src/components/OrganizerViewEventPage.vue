<template>
  <div class="view-event-details-page">
    <div class="event-details" v-if="eventDetails">
      <h2>View Event Details</h2>
      <div class="review-details">
        <!-- Event Image -->
        <div class="event-image">
          <img :src="eventDetails.image_link" alt="Event Image" />
        </div>
        
        <!-- Event Title -->
        <h1>{{ eventDetails.title }}</h1>

        <!-- Date and Time -->
        <div class="date-time-section">
          <h3>Date and Time</h3>
          <div class="date-time">
            <p><b>Starts:</b> {{ formatDateTime(eventDetails.start_datetime) }}</p>
            <p><b>Ends:</b> {{ formatDateTime(eventDetails.end_datetime) }}</p>
          </div>
        </div>

        <!-- Location -->
        <div class="location-section">
          <h3>Location</h3>
          <p>{{ eventDetails.location }}</p>
        </div>

        <!-- Category -->
        <div class="category-section">
          <h3>Category</h3>
          <p>{{ eventDetails.category }}</p>
        </div>

        <!-- Description -->
        <div class="description-section">
          <h3>Description</h3>
          <p>{{ eventDetails.description }}</p>
        </div>

        <!-- Tickets -->
        <div class="tickets-section">
          <h3>Tickets</h3>
          <ul>
            <li v-for="ticket in eventDetails.tickets" :key="ticket.id">
              {{ ticket.ticket_name }} - RM {{ ticket.ticket_price }}
            </li>
          </ul>
        </div>

        <!-- Interests -->
        <div class="interests-section">
          <h3>Interests</h3>
          <p>{{ eventDetails.interests.length }} people are interested</p>
        </div>

        <!-- Send Invitation Button -->
        <div class="button-group">
          <button @click="sendInvitation">Send Invitation</button>
        </div>
      </div>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      eventDetails: null
    };
  },
  methods: {
    formatDateTime(datetime) {
      const options = {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
      };
      const date = new Date(datetime);
      return date.toLocaleString('en-US', options);
    },
    fetchEventDetails(eventId) {
      axios.get(`http://127.0.0.1:8000/api/events/${eventId}`)
        .then(response => {
          this.eventDetails = response.data;
        })
        .catch(error => {
          console.error("Error fetching event details:", error);
        });
    },
    sendInvitation() {
      this.$router.push({
        name: 'SendInvitation',
        query: {
          eventId: this.$route.params.eventId
        }
      });
    }
  },
  created() {
    this.fetchEventDetails(this.$route.params.eventId);
  }
};
</script>

<style scoped>
.view-event-details-page {
  padding: 20px;
  margin-left : 5%;
  margin-right: 5%;
}

.event-details {
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.event-image img {
  width: 100%;
  max-width: 400px;
  border-radius: 10px;
}

.date-time-section, .location-section, .category-section, .description-section, .tickets-section, .interests-section {
  margin-bottom: 20px;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

h3 {
  font-size: 20px;
  margin-bottom: 10px;
}
</style>
