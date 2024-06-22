<template>
    <div class="home-page">
      <div class="banner">
        <img src="../assets/Images/homeBanner.jpg" alt="homeBanner" class="homeBanner">
        <div class="banner-content">
          <h1>Don't miss out!</h1>
          <h2>Explore the <span class="highlight">vibrant events</span> happening locally and globally.</h2>
          <div class="search-bar">
            <input type="text" placeholder="Search Events, Categories..." />
            <button>Search</button>
          </div>
        </div>
      </div>
      <EventCategories />
      <EventCard />
    </div>
  </template>
  
  <script>
  import EventCard from './EventCard.vue';
  import EventCategories from './EventCategories.vue';
  
  export default {
    components: {
      EventCard,
      EventCategories
    }
  }
  </script>
  
  <style scoped>
  @import '../assets/css/styles.css';
  
  .home-page {
    text-align: center;
  }
  
  .banner {
    position: relative;
    width: 100%;
    height: 20em;
  }
  
  .homeBanner {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .banner-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    text-align: center;
  }
  
  .banner-content h1 {
    font-size: 2.5em;
    margin: 0;
  }
  
  .banner-content h2 {
    font-size: 1.5em;
    margin: 0.5em 0;
  }
  
  .banner-content .highlight {
    color: #ffdd57;
  }
  
  .search-bar {
    display: flex;
    justify-content: center;
    margin-top: 1em;
  }

  .search-bar input {
    padding: 0.8em;
    width: 500px;
    border: none;
    border-radius: 5px 0 0 5px;
  }
  
  .search-bar button {
    padding: 0.5em 1em;
    border: none;
    border-radius: 0 5px 5px 0;
    background-color: #ffdd57;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .search-bar button:hover {
    background-color: #ffcc00;
  }
  </style>
  