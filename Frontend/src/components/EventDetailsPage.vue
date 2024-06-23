<template>
  <div class="view-event-details-page">
    <div class="event-details" v-if="eventDetails">
      <div class="review-details">
        <!-- Event Image -->
        <div class="event-image">
          <img :src="eventDetails.image_link" alt="Event Image" />
        </div>

        <div class="details">
        <h1>{{ eventDetails.title }}</h1>
        
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

        <!-- Interests and Buy Ticket Button -->
        <div class="interests-and-buy">
          <div class="interests-section">
            <h3>Interests</h3>
            <p>{{ eventDetails.interests.length }} people are interested</p>
          </div>
          <button class="buy-ticket-button" @click="openBuyTicketPopout">
            <img src = "../assets/Icons/ticketCard.png" alt = "ticket"/>
            Buy Ticket
          </button>
        </div>
      </div>
    </div>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>

    <BuyTicket
      v-if="showBuyTicketPopout"
      :tickets="eventDetails.tickets"
      @close="closeBuyTicketPopout"
      @purchase="buyTicket"
    />
  </div>
</template>

<script>
import axios from 'axios';
import BuyTicket from './BuyTicket.vue';

export default {
  components: {
    BuyTicket
  },
  data() {
    return {
      eventDetails: null,
      showBuyTicketPopout: false
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
          this.eventDetails.tickets.forEach(ticket => ticket.quantity = 0);
        })
        .catch(error => {
          console.error("Error fetching event details:", error);
        });
    },
    openBuyTicketPopout() {
      this.showBuyTicketPopout = true;
    },
    closeBuyTicketPopout() {
      this.showBuyTicketPopout = false;
    },
    buyTicket(payload) {
      axios.post(`http://127.0.0.1:8000/api/ticketsales`, payload)
        .then(() => {
          alert("Ticket purchased successfully!");
          this.closeBuyTicketPopout();
        })
        .catch(error => {
          console.error("Error purchasing ticket:", error);
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
  padding: 100px;
  padding-right:300px;
  padding-left:300px;
  margin-left: 5%;
  margin-right: 5%;
}

.event-details {
  background-color: #f9f9f9;
  padding: 10px;
  margin-left: 20PX;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.event-image img {
  width: 90%; /* Adjust the width as needed, could be 100% of the container */
  height: 450px; /* Height for 16:9 aspect ratio, based on the width */
  object-fit: cover; /* Crop and cover the area */
  border-radius: 15px;
  max-width: 100%; /* Adjust or remove max-width as needed */
  max-height: 500px;
}

.details{
  padding: 10px;
  margin-left: 40px;
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

.interests-and-buy {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.buy-ticket-button {
  padding: 10px 20px;
  background-color: #FFE047;
  color: black;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.buy-ticket-button img{
  height: auto;
  width: 20px;
  padding-right:5px;
  padding-top:3px;
}
</style>
