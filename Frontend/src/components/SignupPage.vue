<template>
  <div class="flex h-screen">
    <div class="w-1/2 bg-custom-bg text-white flex flex-col items-center justify-center p-10">
      <img src="../assets/Icons/InviteLogo.png" alt="Invite Logo" class="mb-5" style="width: 15rem;" />
      <h2 class="text-2xl font-bold font-montserrat">Discover tailored events.</h2>
      <p class="text-lg mt-4 font-montserrat">Sign up for personalized recommendations today!</p>
    </div>
    <div class="w-1/2 bg-white flex flex-col items-center justify-center p-10">
      <h2 class="text-2xl font-bold mb-5 w-full text-left text-custom-heading font-montserrat">Create Account</h2>
      <div class="flex w-full justify-between mb-3">
        <button class="flex-1 bg-white text-custom-bg border border-gray-300 py-2 rounded-md mr-2 flex items-center justify-center">
          <img src="../assets/Icons/GoogleIcon.png" alt="Google Logo" class="w-5 h-5 mr-2" />
          Sign up with Google
        </button>
        <button class="flex-1 bg-white text-custom-bg border border-gray-300 py-2 rounded-md flex items-center justify-center">
          <img src="../assets/Icons/FacebookIcon.png" alt="Facebook Logo" class="w-5 h-5 mr-2" />
          Sign up with Facebook
        </button>
      </div>
      <div class="flex items-center my-4 w-full">
        <hr class="flex-grow border-t border-gray-300" />
        <span class="mx-2 text-gray-500">OR</span>
        <hr class="flex-grow border-t border-gray-300" />
      </div>
      <form @submit.prevent="signup" class="w-full">
        <TextField label="Full Name" id="fullName" placeholder="Enter your full name" v-model="fullName" />
        <TextField label="E-mail Address" id="email" placeholder="Enter your email" v-model="email" />
        <TextField label="Phone Number" id="phoneNumber" placeholder="Enter your phone number" v-model="phoneNumber" />
        <TextField label="Gender" id="gender" placeholder="Enter your gender" v-model="gender" />
        <TextField label="Password" id="password" placeholder="Enter your password" type="password" v-model="password" />
        <TextField label="Confirm Password" id="password_confirmation" placeholder="Confirm your password" type="password" v-model="password_confirmation" />
        <button type="submit" class="w-full bg-custom-button text-white py-2 rounded-md mt-4">Sign Up</button>
      </form>
      <div v-if="errors" class="mt-4 text-red-500">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>
      <p class="mt-4 text-gray-600 w-full text-left">
        Already have an account? <router-link to="/login" class="text-custom-bg font-bold">Log In</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import TextField from './TextField.vue';
import axios from 'axios';

export default {
  name: 'SignupPage',
  components: {
    TextField
  },
  data() {
    return {
      fullName: '',
      email: '',
      phoneNumber: '',
      gender: '',
      password: '',
      password_confirmation: '',
      errors: null
    };
  },
  methods: {
    async signup() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/signup', {
          fullname: this.fullName,
          email: this.email,
          phone: this.phoneNumber,
          gender: this.gender,
          password: this.password,
          password_confirmation: this.password_confirmation
        });
        console.log(response.data.message);
        // Redirect to login page or dashboard
        this.$router.push('/login');
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = Object.values(error.response.data.errors).flat();
        } else {
          console.log('Error:', error.message);
        }
      }
    }
  }
};
</script>

<style scoped>
/* No additional CSS needed as Tailwind handles the styling */
</style>
