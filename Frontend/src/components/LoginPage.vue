<template>
  <div class="flex h-screen">
    <div class="w-1/2 bg-custom-bg text-white flex flex-col items-center justify-center p-10">
      <img src="../assets/Icons/InviteLogo.png" alt="Invite Logo" class="mb-5" style="width: 15rem;" />
      <h2 class="text-2xl font-bold font-montserrat">Discover tailored events.</h2>
      <p class="text-lg mt-4 font-montserrat">Sign in to get personalized recommendations!</p>
    </div>
    <div class="w-1/2 bg-white flex flex-col items-center justify-center p-10">
      <h2 class="text-2xl font-bold mb-5 w-full text-left text-custom-heading font-montserrat">Log In</h2>
      <form @submit.prevent="login" class="w-full">
        <TextField label="E-mail Address" id="username" placeholder="Enter your email" v-model="username" />
        <TextField label="Password" id="password" placeholder="Enter your password" type="password" v-model="password" />
        <button type="submit" class="w-full bg-custom-button text-white py-2 rounded-md mt-4">Log In</button>
      </form>
      <div v-if="errorMessage" class="mt-4 text-red-500">
        {{ errorMessage }}
      </div>
      <p class="mt-4 text-gray-600 w-full text-left">
        Don't have an account? <router-link to="/signup" class="text-custom-bg font-bold">Sign Up</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import TextField from './TextField.vue';
import axios from 'axios';

export default {
  name: 'LoginPage',
  components: {
    TextField
  },
  data() {
    return {
      username: '',
      password: '',
      errorMessage: null
    };
  },
  methods: {
  async login() {
    try {
      // First, get the CSRF cookie
      await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');

      // Then, proceed with the login request
      const response = await axios.post('http://127.0.0.1:8000/api/login', {
        username: this.username,
        password: this.password
      }, { withCredentials: true }); // Ensure withCredentials is set

      console.log(response.data);  // Log the entire response to see the token

      if (response.status === 200) {
  localStorage.setItem('token', response.data.token);
  localStorage.setItem('id', response.data.id.toString());
        // Redirect to dashboard
        this.$router.push('/');
}  // Ensure token is stored correctly

    } catch (error) {
      console.error('Login error:', error);
      this.errorMessage = 'Invalid credentials';
    }
  }
  // async login() {
  //   try {
  //     // First, get the CSRF cookie
  //     await axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie');

  //     // Then, proceed with the login request
  //     const response = await axios.post('http://127.0.0.1:8000/api/login', {
  //       username: this.username,
  //       password: this.password
  //     }, { withCredentials: true }); // Ensure withCredentials is set

  //     console.log(response.data);  // Log the entire response to see the id

  //     if (response.status === 200) {
  //       localStorage.setItem('id', response.data.id.toString()); // Store the id in localStorage
  //       // Redirect to dashboard
  //       this.$router.push('/');
  //     } // Ensure id is stored correctly

  //   } catch (error) {
  //     console.error('Login error:', error);
  //     this.errorMessage = 'Invalid credentials';
  //   }
  // }
}





};
</script>

<style scoped>
/* No additional CSS needed as Tailwind handles the styling */
</style>
