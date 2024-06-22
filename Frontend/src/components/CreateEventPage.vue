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
    
    <!-- Event Type Selection -->
    <div class="form-group">
      <label>What type of event are you running?</label>
      <div class="radio-group">
        <input type="radio" id="ticketedEvent" value="Ticketed" v-model="formData.eventType" required />
        <label for="ticketedEvent">Ticketed Event</label>
        <input type="radio" id="freeEvent" value="Free" v-model="formData.eventType" required />
        <label for="freeEvent">Free Event</label>
      </div>
    </div>
    
    <!-- Ticket Details for Ticketed Events -->
    <div v-if="formData.eventType === 'Ticketed'" class="form-group">
      <label for="ticketName">What tickets are you selling?</label>

      <div v-for="(ticket, index) in formData.tickets" :key="index" class="ticket-entry">
        <input type="text" v-model="ticket.name" placeholder="Ticket Name" required />
        <input type="number" v-model="ticket.price" placeholder="Ticket Price" required />
        <button type="button" @click="removeTicket(index)" class="remove-button">Remove</button>
      </div>

      <button type="button" @click="addTicket" class="add-button">Add Another Ticket</button>
    </div>
    
    <!-- Navigation Buttons -->
    <div class="button-group">
      <button @click="previousStep">Go back to Banner</button>
      <button @click="nextStep">Save & Continue</button>
    </div>
  </div>

  <div v-show="currentStep === 4" class="step step-4">
    <h2>Create a New Event - Review</h2>
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

    <!-- Navigation Buttons -->
    <div class="button-group">
      <button @click="previousStep">Go back to Ticketing</button>
      <button @click="submitEvent">Publish Event</button>
    </div>
  </div>
  </div>
</template>

<script>
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
        tickets: [] // Array to hold multiple tickets
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
      // Handle event submission logic here, e.g., send data to an API
      console.log('Event submitted', this.formData);
    },
    validateStep1() {
      if (!this.formData.eventTitle || !this.formData.eventCategory || !this.formData.startDate || 
          !this.formData.startTime || !this.formData.endDate || !this.formData.endTime || 
          !this.formData.eventLocation || !this.formData.eventDescription) {
        alert('Please fill out all required fields.');
        return false;
      }
      return true;
    },
    validateStep2() {
      if (!this.uploadedImage) {
        alert('Please upload an image.');
        return false;
      }
      return true;
    },
    validateStep3() {
      if (!this.formData.eventType) {
        alert('Please select an event type.');
        return false;
      }
      if (this.formData.eventType === 'Ticketed' && this.formData.tickets.length === 0) {
        alert('Please add at least one ticket.');
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
.create-event-page {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.progress-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  position: relative;
}

.progress-bar div {
  flex: 1;
  text-align: center;
  padding: 10px;
  border-bottom: 2px solid #ccc;
}

.progress-bar .active {
  border-bottom: 2px solid #4CAF50;
}

.progress-bar div:not(:last-child)::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 2px;
  background: #ccc;
  top: 50%;
  left: 50%;
  transform: translateX(-50%);
  z-index: -1;
}

.progress-bar div.active:not(:last-child)::after {
  background: #4CAF50;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.radio-group {
  display: flex;
  justify-content: space-between;
}

.radio-group input {
  margin-right: 10px;
}

.radio-group label {
  margin-right: 20px;
}

.button-group {
  display: flex;
  justify-content: space-between;
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

.review-details {
  background: #f9f9f9;
  padding: 20px;
  border-radius: 10px;
}

.review-details h3 {
  margin-top: 0;
}

.review-details .event-image {
  text-align: center;
  margin: 20px 0;
}

.review-details .event-image img {
  max-width: 100%;
  border-radius: 10px;
}

.review-details .ticket-info {
  margin-top: 20px;
}

.step-4 {
  padding: 20px;
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
  justify-content: space-between;
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

.step-3 .ticket-entry {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.step-3 .ticket-entry input {
  margin-right: 10px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.step-3 .remove-button {
  padding: 10px 15px;
  background: #e74c3c;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.step-3 .remove-button:hover {
  background: #c0392b;
}

.step-3 .add-button {
  padding: 10px 15px;
  background: #3498db;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
}

.step-3 .add-button:hover {
  background: #2980b9;
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
