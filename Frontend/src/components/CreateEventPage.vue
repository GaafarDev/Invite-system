<template>
  <div class="create-event-page">
    <div class="progress-bar">
      <div :class="{'active': currentStep >= 1}">Edit</div>
      <div :class="{'active': currentStep >= 2}">Banner</div>
      <div :class="{'active': currentStep >= 3}">Ticketing</div>
      <div :class="{'active': currentStep >= 4}">Review</div>
    </div>

    <div v-show="currentStep === 1" class="step step-1">
      <h2>Create a New Event - Edit</h2>
      <div class="form-group">
        <label for="eventTitle">Event Title</label>
        <input type="text" v-model="formData.eventTitle" id="eventTitle" required />
      </div>
      <div class="form-group">
        <label for="eventCategory">Event Category</label>
        <select v-model="formData.eventCategory" id="eventCategory" required>
          <option value="">Please select one</option>        <option value="Entertainment">Entertainment</option>
          <option value="Educational & Business">Educational & Business</option>
          <option value="Culturan & Arts">Culturan & Arts</option>
          <option value="Sports & Fitness">Sports & Fitness</option>
          <option value="Technology & Innovation">Technology & Innovation</option>
          <option value="Travel & Adventure">Travel & Adventure</option>
        </select>
      </div>
      <div class="form-group">
        <label>Date & Time</label>
        <div class="date-time">
          <div>
            <label for="startDate">Start Date</label>
            <input type="date" v-model="formData.startDate" id="startDate" required />
          </div>
          <div>
            <label for="startTime">Start Time</label>
            <input type="time" v-model="formData.startTime" id="startTime" required />
          </div>
          <div>
            <label for="endDate">End Date</label>
            <input type="date" v-model="formData.endDate" id="endDate" required />
          </div>
          <div>
            <label for="endTime">End Time</label>
            <input type="time" v-model="formData.endTime" id="endTime" required />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="eventLocation">Location</label>
        <input type="text" v-model="formData.eventLocation" id="eventLocation" required />
      </div>
      <div class="form-group">
        <label for="eventDescription">Additional Information</label>
        <textarea v-model="formData.eventDescription" id="eventDescription" required></textarea>
      </div>
      <div class="button-group">
        <button @click="nextStep">Save & Continue</button>
      </div>
    </div>

    <div v-show="currentStep === 2" class="step step-2">
      <h2>Create a New Event - Banner</h2>
      <div class="form-group">
        <label for="eventImage">Upload Image</label>
        <input type="file" @change="handleFileUpload" required />
      </div>
      <div class="button-group">
        <button @click="previousStep">Go back to Edit Event</button>
        <button @click="nextStep">Save & Continue</button>
      </div>
    </div>

    <div v-show="currentStep === 3" class="step step-3">
    <h2>Create a New Event - Ticketing</h2>
    

    <div class="form-group">
      <label>What type of event are you running?</label>
      <div class="radio-group">
        <input type="radio" id="ticketedEvent" value="Ticketed" v-model="formData.eventType" required />
        <label for="ticketedEvent">Ticketed Event</label>
        <input type="radio" id="freeEvent" value="Free" v-model="formData.eventType" required />
        <label for="freeEvent">Free Event</label>
      </div>
    </div>
    

    <div v-if="formData.eventType === 'Ticketed'" class="form-group">
      <label for="ticketName">What tickets are you selling?</label>

      <div v-for="(ticket, index) in formData.tickets" :key="index" class="ticket-entry">
        <input type="text" v-model="ticket.name" placeholder="Ticket Name" required />
        <input type="number" v-model="ticket.price" placeholder="Ticket Price" required />
        <button type="button" @click="removeTicket(index)" class="remove-button">Remove</button>
      </div>

      <button type="button" @click="addTicket" class="add-button">Add Another Ticket</button>
    </div>
    

    <div class="button-group">
      <button @click="previousStep">Go back to Banner</button>
      <button @click="nextStep">Save & Continue</button>
    </div>
  </div>

  <div v-show="currentStep === 4" class="step step-4">
    <h2>Create a New Event - Review</h2>
    <div class="review-details">
      <div class="event-image">
        <img :src="imagePreview" alt="Event Image" />
      </div>
      
   
      <h1>{{ formData.eventTitle }}</h1>


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


<div class="ticket-information">
  <h3>Ticket Information</h3>
  <div v-if="formData.eventType === 'Ticketed'" class="ticket-details">
    <img src="@/assets/Icons/ticket-icon.png" alt="Ticket Icon" class="icon" />
    <p>
    <ul class="ticket-list">
      <li v-for="(ticket, index) in formData.tickets" :key="index" class="ticket-item">
        {{ ticket.name }} - RM{{ ticket.price }}
      </li>
    </ul></p>
  </div>
  <div v-if="formData.eventType === 'Free'">
    <img src="@/assets/Icons/ticket-icon.png" alt="Ticket Icon" class="icon" />
    <span>Free Event</span>
  </div>
</div>


      <div class="location-section">
        <h3>Location</h3>
        <p>{{ formData.eventLocation }}</p>
      </div>


      <div class="event-description-section">
        <h3>Event Description</h3>
        <p>{{ formData.eventDescription }}</p>
      </div>
    </div>

    <div class="button-group">
      <button @click="previousStep">Go back to Ticketing</button>
      <button @click="submitEvent">Publish Event</button>
    </div>
  </div>
  </div>
</template>

<script>
import apiClient from '../services/api';

export default {
  data() {
    return {
      currentStep: 1,
      formData: {
        eventTitle: '',
        eventCategory: '',
        startDate: '',
        startTime: '',
        endDate: '',
        endTime: '',
        eventLocation: '',
        eventDescription: '',
        eventType: '',
        tickets: [] 
      },
      uploadedImage: null
    };
  },
  computed: {
    imagePreview() {
      return this.uploadedImage ? URL.createObjectURL(this.uploadedImage) : '';
    }
  },
  methods: {
    nextStep() {
      if (this.currentStep === 1 && !this.validateStep1()) return;
      if (this.currentStep === 2 && !this.validateStep2()) return;
      if (this.currentStep === 3 && !this.validateStep3()) return;
      if (this.currentStep < 4) {
        this.currentStep++;
      }
    },
    previousStep() {
      if (this.currentStep > 1) {
        this.currentStep--;
      }
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.uploadedImage = file;
    },
    submitEvent() {
      const eventData = {
        title: this.formData.eventTitle,
        description: this.formData.eventDescription,
        category: this.formData.eventCategory,
        start_datetime: `${this.formData.startDate} ${this.formData.startTime}`,
        end_datetime: `${this.formData.endDate} ${this.formData.endTime}`,
        location: this.formData.eventLocation,
        image_link: this.imagePreview,
        user_id: 1,
        tickets: [], 
      };

      if (this.formData.eventType === 'Ticketed') {
        eventData.tickets = this.formData.tickets.map(ticket => ({
          ticket_name: ticket.name,
          ticket_price: ticket.price,
        }));
      } else if (this.formData.eventType === 'Free') {
        eventData.tickets = [{
          ticket_name: 'Free admission',
          ticket_price: 0,
        }];
      }

      apiClient.post('/api/events/', eventData)
        .then(response => {
          console.log('Event submitted successfully', response.data);
          window.alert('Event created!');
          window.location.reload();
        })
        .catch(error => {
          console.error('There was an error submitting the event:', error.response ? error.response.data : error.message);
          if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            if (errors) {
              console.log('Validation errors:', errors);
            }
          } else {
            console.error('Unhandled error:', error.message);
          }
        });
    },
    validateStep1() {
      return true;
    },
    validateStep2() {
      return true; 
    },
    validateStep3() {
      if (!this.formData.eventType) {
        alert('Please select an event type.');
        return false;
      }
      return true;
    },
    addTicket() {
      this.formData.tickets.push({ name: '', price: '' });
    },
    removeTicket(index) {
      this.formData.tickets.splice(index, 1);
    }
  }
};
</script>


<style>
 @import '../assets/css/CreateEvent.css';
</style>
