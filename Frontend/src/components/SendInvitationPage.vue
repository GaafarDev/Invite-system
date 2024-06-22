<template>
    <div class="send-invitation-page">
      <h2>Send Invitation</h2>
      
      <!-- Event Details Section -->
      <div class="event-details">
        <h3>{{ eventTitle }}</h3>
        <p>{{ eventDescription }}</p>
        <p><strong>Date:</strong> {{ eventDate }}</p>
        <p><strong>Time:</strong> {{ eventTime }}</p>
      </div>
      
      <form @submit.prevent="sendInvitations">
        <div class="user-list">
          <div v-for="(user) in users" :key="user.id" class="user-item">
            <div class="user-info">
              <img :src="user.pic_url" alt="User Image" class="user-image" />
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
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        eventTitle: '',
        eventDescription: '',
        eventDate: '',
        eventTime: '',
        users: [
          {
            id: 1,
            fullname: "John Doe",
            email: "john.doe@example.com",
            phone: "+123456789",
            pic_url: "https://via.placeholder.com/50"
          },
          {
            id: 2,
            fullname: "Jane Smith",
            email: "jane.smith@example.com",
            phone: "+987654321",
            pic_url: "https://via.placeholder.com/50"
          },
          {
            id: 3,
            fullname: "Alice Johnson",
            email: "alice.johnson@example.com",
            phone: "+1122334455",
            pic_url: "https://via.placeholder.com/50"
          }
          // Add more dummy users as needed
        ],
        selectedUsers: [] // To keep track of selected user IDs
      };
    },
    created() {
      // Get event details from query parameters
      const query = this.$route.query;
      this.eventTitle = query.eventTitle || 'Default Event Title';
      this.eventDescription = query.eventDescription || 'Default Event Description';
      this.eventDate = query.eventDate || 'Default Event Date';
      this.eventTime = query.eventTime || 'Default Event Time';
    },
    methods: {
      sendInvitations() {
        // Placeholder for the invitation sending logic
        console.log("Selected user IDs:", this.selectedUsers);
        // Implementation for sending invitations will go here
      }
    }
  };
  </script>
  
  <style scoped>
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
    object-fit: cover;
    margin-right: 15px;
  }
  
  .user-details {
    display: flex;
    flex-direction: column;
  }
  
  .user-name {
    font-size: 1.1rem;
    font-weight: bold;
  }
  
  .user-phone,
  .user-email {
    font-size: 0.9rem;
    color: #555;
  }
  
  .user-checkbox {
    width: 20px;
    height: 20px;
  }
  
  .button-group {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  
  .send-button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background: #4CAF50;
    color: #fff;
    cursor: pointer;
    font-size: 1rem;
  }
  
  .send-button:hover {
    background: #45a049;
  }
  </style>
  