<template>
    <div class="view-event-details-page">
      <div class="event-details">
        <h2>View Event Details</h2>
        <div class="review-details">
          <!-- Event Image -->
          <div class="event-image">
            <img :src="imagePreview" alt="Event Image" />
          </div>
          
          <!-- Event Title -->
          <h1>{{ formData.eventTitle }}</h1>
  
          <!-- Date and Time -->
          <div class="date-time-section">
            <h3>Date and Time</h3>
            <div class="date-time-details">
              <img src="@/assets/Icons/calendar-icon.png" alt="Calendar Icon" class="icon" />
              <span>{{ formData.startDate }} - {{ formData.endDate }}</span>
            </div>
            <div class="date-time-details">
              <img src="@/assets/Icons/clock-icon.png" alt="Clock Icon" class="icon" />
              <span>{{ formData.startTime }} - {{ formData.endTime }}</span>
            </div>
          </div>
  
          <!-- Ticket Information -->
          <div class="ticket-information">
            <h3>Ticket Information</h3>
            <div v-if="formData.eventType === 'Ticketed'" class="ticket-details">
              <img src="@/assets/Icons/ticket-icon.png" alt="Ticket Icon" class="icon" />
              <ul class="ticket-list">
                <li v-for="(ticket, index) in formData.tickets" :key="index" class="ticket-item">
                  {{ ticket.name }} - RM{{ ticket.price }}
                </li>
              </ul>
            </div>
            <div v-if="formData.eventType === 'Free'">
              <img src="@/assets/Icons/ticket-icon.png" alt="Ticket Icon" class="icon" />
              <span>Free Event</span>
            </div>
          </div>
  
          <!-- Location -->
          <div class="location-section">
            <h3>Location</h3>
            <p>{{ formData.eventLocation }}</p>
          </div>
  
          <!-- Event Description -->
          <div class="event-description-section">
            <h3>Event Description</h3>
            <p>{{ formData.eventDescription }}</p>
          </div>
        </div>
  
        <!-- Send Invitation Button -->
        <div class="button-group">
          <button @click="sendInvitation">Send Invitation</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        formData: {
          eventTitle: 'Cake Baking Open Fair',
          eventCategory: '',
          startDate: '2023-12-31',
          startTime: '00:32',
          endDate: '2023-12-31',
          endTime: '12:31',
          eventLocation: 'ADDRESS',
          eventDescription: 'Event to Bake Cake by Household',
          eventType: 'Ticketed',
          tickets: [
            { name: 'General Admission', price: 10 },
            { name: 'Special Admission', price: 15 }
          ]
        },
        uploadedImage: '/mnt/data/image.png' // Path to your uploaded image
      };
    },
    computed: {
      imagePreview() {
        return this.uploadedImage;
      }
    },
    methods: {
    sendInvitation() {
      // Navigate to the Send Invitation page with query parameters
      this.$router.push({
        name: 'SendInvitation',
        query: {
          eventTitle: this.formData.eventTitle,
          eventDescription: this.formData.eventDescription,
          eventDate: `${this.formData.startDate} - ${this.formData.endDate}`,
          eventTime: `${this.formData.startTime} - ${this.formData.endTime}`
        }
      });
    }
  }
  };
  </script>
  
  <style>
  .view-event-details-page {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .event-details h2 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .review-details {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
  }
  
  .review-details h1 {
    font-size: 2rem;
    font-weight: bold;
    margin: 10px 0;
  }
  
  .review-details h3 {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 20px;
  }
  
  .review-details .date-time-section,
  .review-details .ticket-information,
  .review-details .location-section,
  .review-details .event-description-section {
    margin-top: 20px;
  }
  
  .review-details .date-time-details,
  .review-details .ticket-details {
    display: flex;
    align-items: center;
    margin-top: 10px;
  }
  
  .review-details .date-time-details img,
  .review-details .ticket-details img {
    margin-right: 10px;
    width: 24px;
    height: 24px;
  }
  
  .review-details .date-time-details span,
  .review-details .ticket-details span {
    font-size: 1rem;
  }
  
  .review-details .event-image {
    text-align: center;
    margin: 20px 0;
  }
  
  .review-details .event-image img {
    max-width: 100%;
    border-radius: 10px;
  }
  
  .review-details .location-section p,
  .review-details .event-description-section p {
    font-size: 1rem;
    margin-top: 10px;
  }
  
  .button-group {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }
  
  .button-group button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background: #4CAF50;
    color: #fff;
    cursor: pointer;
  }
  
  .button-group button:hover {
    background: #45a049;
  }
  
  .review-details .ticket-information .ticket-details {
    margin-top: 10px;
  }
  
  .review-details .ticket-information .ticket-list {
    list-style-type: none; /* Remove default bullet points */
    padding-left: 0; /* Remove default padding */
    margin-top: 5px;
  }
  
  .review-details .ticket-information .ticket-item {
    display: flex;
    align-items: center;
    padding: 5px 0; /* Add some spacing between items */
    border-bottom: 1px solid #ddd; /* Optional: Add a separator between items */
  }
  
  .review-details .ticket-information .ticket-item:last-child {
    border-bottom: none; /* Remove the border from the last item */
  }
  
  .review-details .ticket-information .ticket-item span {
    font-size: 1rem;
  }
  </style>
  