<template>
  <div>
    <h1>My Account</h1>
    <div class="account-settings">
      <aside>
        <ul>
          <li @click="currentSection = 'accountInfo'">Account Info</li>
          <li @click="currentSection = 'changeEmail'">Change Email</li>
          <li @click="currentSection = 'password'">Password</li>
        </ul>
      </aside>
      <main>
        <div v-if="currentSection === 'accountInfo'">
          <h1>Account Information</h1>
          <div class="profile-photo">
            <img :src="profilePhoto || profilePicture" alt="Profile Photo">
            <input type="file" @change="onPhotoSelected">
          </div>
          <form @submit.prevent="saveProfile">
            <div class="form-section">
              <h2>Profile Information</h2>
              <label>
                First Name:
                <input v-model="profile.firstName" type="text">
              </label>
              <label>
                Last Name:
                <input v-model="profile.lastName" type="text">
              </label>
              <label>
                Website:
                <input v-model="profile.website" type="url">
              </label>
              <label>
                Company:
                <input v-model="profile.company" type="text">
              </label>
            </div>
            <div class="form-section">
              <h2>Contact Details</h2>
              <p>These details are private and only used to contact you for ticketing or prizes.</p>
              <label>
                Phone Number:
                <input v-model="profile.phoneNumber" type="tel">
              </label>
              <label>
                Address:
                <input v-model="profile.address" type="text">
              </label>
              <label>
                City/Town:
                <input v-model="profile.city" type="text">
              </label>
              <label>
                Country:
                <input v-model="profile.country" type="text">
              </label>
              <label>
                Pincode:
                <input v-model="profile.pincode" type="text">
              </label>
            </div>
            <button type="submit">Save My Profile</button>
          </form>
        </div>
        <div v-if="currentSection === 'changeEmail'">
          <h1>Change Email</h1>
          <form @submit.prevent="changeEmail">
            <div class="form-section">
              <label>
                New Email:
                <input v-model="newEmail" type="email">
              </label>
              <label>
                Confirm New Email:
                <input v-model="confirmNewEmail" type="email">
              </label>
            </div>
            <button type="submit">Change Email</button>
          </form>
        </div>
        <div v-if="currentSection === 'password'">
          <h1>Change Password</h1>
          <form @submit.prevent="changePassword">
            <div class="form-section">
              <label>
                Current Password:
                <input v-model="currentPassword" type="password">
              </label>
              <label>
                New Password:
                <input v-model="newPassword" type="password">
              </label>
              <label>
                Confirm New Password:
                <input v-model="confirmNewPassword" type="password">
              </label>
            </div>
            <button type="submit">Change Password</button>
          </form>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import apiClient from '../services/api.js';
import profilePicture from '../assets/Images/profile_picture.png';

export default {
  data() {
    return {
      currentSection: 'accountInfo',
      profilePhoto: '',
      profilePicture,
      profile: {
        firstName: '',
        lastName: '',
        website: '',
        company: '',
        phoneNumber: '',
        address: '',
        city: '',
        country: '',
        pincode: ''
      },
      newEmail: '',
      confirmNewEmail: '',
      currentPassword: '',
      newPassword: '',
      confirmNewPassword: '',
      profileLoaded: false // Flag to indicate if profile data has been loaded
    };
  },
  async mounted() {
    try {
      const response = await apiClient.get('/api/users/1');
      const userData = response.data;

      this.profile = {
        firstName: userData.fullname.split(' ')[0],
        lastName: userData.fullname.split(' ')[1] || '',
        website: userData.website || '',
        company: userData.company || '',
        phoneNumber: userData.phone || '',
        address: userData.address || '',
        city: userData.city || '',
        country: userData.country || '',
        pincode: userData.postcode || ''
      };

      this.profileLoaded = true; // Mark profile data as loaded
    } catch (error) {
      console.error('Error fetching user data:', error);
    }
  },
  methods: {
    onPhotoSelected(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          this.profilePhoto = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    async saveProfile() {
      try {
        const response = await apiClient.post('/api/profile', this.profile);
        console.log('Profile saved:', response.data);
      } catch (error) {
        console.error('Error saving profile:', error);
      }
    },
    async changeEmail() {
      if (this.newEmail !== this.confirmNewEmail) {
        alert("Emails do not match!");
        return;
      }
      try {
        const response = await apiClient.post('/api/change-email', { email: this.newEmail });
        console.log('Email changed:', response.data);
      } catch (error) {
        console.error('Error changing email:', error);
      }
    },
    async changePassword() {
      if (this.newPassword !== this.confirmNewPassword) {
        alert("Passwords do not match!");
        return;
      }
      try {
        const response = await apiClient.post('/api/change-password', {
          currentPassword: this.currentPassword,
          newPassword: this.newPassword
        });
        console.log('Password changed:', response.data);
      } catch (error) {
        console.error('Error changing password:', error);
      }
    }
  }
};
</script>

<style scoped>
@import '../assets/css/Profile.css';
</style>
