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
                 <li><router-link to='/organizer-view-event' active-class = "active-page">View Event Page Page</router-link></li>
             </ul>
         </div>
 
         <div class='icons'>
             <ul>
                 <li><router-link to='/create-event' class = "navCreateEvent">Create Event</router-link></li>
                 <li><router-link to='#'><img src='../assets/Icons/ticket_icon.png' alt='Tickets' title = "Tickets"/></router-link></li>
                 <li><router-link to='#'><img src='../assets/Icons/star_icon.png' alt='Interested' title ="Interested"/></router-link></li>
                 <li class="profile-dropdown">
                     <router-link to='#'><img src='../assets/Icons/profile_icon.png' alt='Profile'/></router-link>
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
 export default {
     name: 'NavBar',
 }
 document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.querySelector('.profile-dropdown');
    const dropdownContent = document.querySelector('.dropdown-content');

    // Toggle dropdown display on click
    dropdown.addEventListener('click', function(event) {
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        event.stopPropagation(); // Prevent the click from being detected by the document
    });

    // Hide dropdown if clicking outside of it
    document.addEventListener('click', function() {
        if (dropdownContent.style.display === 'block') {
            dropdownContent.style.display = 'none';
        }
    });
});
 </script>
 
 <style>
 @import '../assets/css/NavBar.css';
 </style>
 