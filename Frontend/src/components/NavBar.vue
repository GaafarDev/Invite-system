<template>
    <div class='navbar'> 
         <div class='AppLogo'>
             <img src='../assets/Icons/InviteLogo.png' alt='logo'/>
         </div>
 
         <div class='menu'>
             <ul>
                 <li><router-link to='/' active-class = "active-page">Home</router-link></li>
                 <li><router-link to='/events' active-class = "active-page">Events</router-link></li>
                 <li><router-link to='/invitations' active-class = "active-page">Invitations</router-link></li>
                 <li><router-link to='/map' active-class = "active-page">Map</router-link></li>
                 <li><router-link to='/organizer-events' active-class = "active-page">Organized Events</router-link></li>
                 <li><router-link to='/create-event' active-class = "active-page">Create New Event</router-link></li>
                 <li><router-link to='/organizer-view-event' active-class = "active-page">View Event Page Page</router-link></li>
             </ul>
         </div>
 
         <div class='icons'>
             <ul>
                 <li><router-link to='#' class = "navCreateEvent">Create Event</router-link></li>
                 <li><router-link to='#'><img src='../assets/Icons/ticket_icon.png' alt='Tickets' title = "Tickets"/></router-link></li>
                 <li><router-link to='#'><img src='../assets/Icons/star_icon.png' alt='Interested' title ="Interested"/></router-link></li>
                 <li class="profile-dropdown">
                    <router-link to='/profile'><img src='../assets/Icons/profile_icon.png' alt='Profile'/></router-link>
                    <div class="dropdown-content">
                         <router-link to='#'>Are you an Organizer?</router-link>
                         <router-link to='#'>Logout</router-link>
                     </div>
                 </li>
             </ul>
         </div>
    </div>
  </template>
  
  <script>
  import apiClient from '../services/api';  // Ensure this path is correct
  
  export default {
    name: 'NavBar',
    created() {
    this.checkUser();
  },
    methods: {
      async logout() {
        try {
          const token = localStorage.getItem('token');
          if (!token) {
            throw new Error('No token found in local storage');
          }
          await apiClient.post('/api/logout', {}, {
            headers: {
              Authorization: `Bearer ${token}`
            }
          });
          localStorage.removeItem('token');  // Clear the token after logout
          localStorage.removeItem('id');  // Clear the token after logout
          this.$router.push('/login');  // Redirect to login page
        } catch (error) {
          console.error('Logout error:', error);
          // Handle error if the logout fails
        }
        

      },
      checkUser() {
      const userId = localStorage.getItem('id');
      const token = localStorage.getItem('token');
      if (!userId || !token) {
        this.$router.push('/login'); // Redirect to login if no userId found
      }
    }
    }
  }
  </script>
  
  <style>
  @import '../assets/css/NavBar.css';
  /* Add any necessary styles here */
  </style>
  