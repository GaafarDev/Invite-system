<template>
  <div class="send-invitation-page">
    <h2>Send Invitation</h2>
    
    <!-- Event Details Section -->
    <div class="event-details" v-if="eventDetails">
      <h3>{{ eventDetails.title }}</h3>
      <p>{{ eventDetails.description }}</p>
      <p><strong>Date:</strong> {{ formatDateTime(eventDetails.start_datetime) }} - {{ formatDateTime(eventDetails.end_datetime) }}</p>
      <p><strong>Location:</strong> {{ eventDetails.location }}</p>
    </div>
    <div v-else>
      <p>Loading event details...</p>
    </div>
    
    <form @submit.prevent="sendInvitations">
      <div class="user-list">
        <div v-for="(user) in users" :key="user.id" class="user-item">
          <div class="user-info">
            <img :src="user.pic_url || 'https://via.placeholder.com/50'" alt="User Image" class="user-image" />
            <div class="user-details">
              <p class="user-name">{{ user.fullname }}</p>
              <p class="user-phone">{{ user.phone }}</p>
              <p class="user-email">{{ user.email }}</p>
            </div>
          </div>
          <input type="checkbox" v-model="selectedUsers" :value="user.id" class="user-checkbox" />
        </div>
      </div>
      <div class="button-group">
        <button type="submit" class="send-button">Send Invitation</button>
      </div>
    </form>
    
    <!-- Success Message -->
    <div v-if="successMessage" class="success-message">
      {{ successMessage }}
    </div>
  </div>
</template>


<script>
import axios from 'axios';
import apiClient from '@/services/api.js'; // Adjust the path according to your project structure

export default {
  data() {
    return {
      eventDetails: null,
      users: [],
      selectedUsers: [], // To keep track of selected user IDs
      successMessage: "" // To store the success message
    };
  },
  created() {
    const eventId = this.$route.query.eventId;
    this.fetchEventDetails(eventId);
    this.fetchUsers();
  },
  methods: {
    fetchEventDetails(eventId) {
      axios.get(`http://127.0.0.1:8000/api/events/${eventId}`)
        .then(response => {
          this.eventDetails = response.data;
        })
        .catch(error => {
          console.error("Error fetching event details:", error);
        });
    },
    fetchUsers() {
      apiClient.get('/api/users')
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          console.error("Error fetching users:", error);
        });
    },
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
    sendInvitations() {
      const payload = {
        event_id: this.eventDetails.id,
        user_id: this.selectedUsers
      };
      axios.post('http://127.0.0.1:8000/api/invitations', payload)
        .then(response => {
          console.log("Invitations sent successfully:", response.data);
          this.successMessage = "Invitations sent successfully!";
          // Optionally clear selected users
          this.selectedUsers = [];
        })
        .catch(error => {
          console.error("Error sending invitations:", error);
          this.successMessage = "Error sending invitations. Please try again.";
        });
    }
  }
};
</script>



<style>
.send-invitation-page {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

.event-details {
  text-align: center;
  margin-bottom: 20px;
}

h3 {
  margin-bottom: 10px;
}

.user-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.user-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  background: #f9f9f9;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.user-info {
  display: flex;
  align-items: center;
}

.user-image {
  border-radius: 50%;
  width: 50px;
  height: 50px;
  margin-right: 15px;
}

.user-details {
  display: flex;
  flex-direction: column;
}

.user-name {
  font-weight: bold;
}

.user-phone,
.user-email {
  font-size: 0.9em;
  color: #666;
}

.user-checkbox {
  transform: scale(1.5);
}

.button-group {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.send-button {
  padding: 10px 20px;
  font-size: 1em;
  background: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.send-button:hover {
  background: #0056b3;
}

.success-message {
  text-align: center;
  margin-top: 20px;
  padding: 10px;
  background: #dff0d8;
  color: #3c763d;
  border: 1px solid #d6e9c6;
  border-radius: 5px;
}
</style>
