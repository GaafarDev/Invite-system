<template> 
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3>Company Info</h3>
                <ul>
                    <li><router-link to="#">About Us</router-link></li>
                    <li><router-link to="#">Contact Us</router-link></li>
                    <li><router-link to="#">Careers</router-link></li>
                    <li><router-link to="#">FAQs</router-link></li>
                    <li><router-link to="#">Terms of Service</router-link></li>
                    <li><router-link to="#">Privacy Policy</router-link></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Help</h3>
                <ul>
                    <li><router-link to="#">Account Support</router-link></li>
                    <li><router-link to="#">Listing Events</router-link></li>
                    <li><router-link to="#">Event Ticketing</router-link></li>
                    <li><router-link to="#">Ticket Purchase Terms & Conditions</router-link></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Categories</h3>
                <ul>
                    <li><router-link to="#">Concerts & Gigs</router-link></li>
                    <li><router-link to="#">Festivals & Lifestyle</router-link></li>
                    <li><router-link to="#">Business & Networking</router-link></li>
                    <li><router-link to="#">Food & Drinks</router-link></li>
                    <li><router-link to="#">Performing Arts</router-link></li>
                    <li><router-link to="#">Sports & Outdoors</router-link></li>
                    <li><router-link to="#">Exhibitions</router-link></li>
                    <li><router-link to="#">Workshops, Conferences & Classes</router-link></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Follow Us</h3>
                <ul>
                    <li><router-link to="#">Facebook</router-link></li>
                    <li><router-link to="#">Instagram</router-link></li>
                    <li><router-link to="#">Twitter</router-link></li>
                    <li><router-link to="#">Youtube</router-link></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Download The App</h3>
                <ul>
                    <li><router-link to="#"><img src="../assets/Images/google_play2.png" alt="Google Play"/></router-link></li>
                    <li><router-link to="#"><img src="../assets/Images/app_store.png" alt="App Store"/></router-link></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>©2023 Eventify. All rights reserved.</p>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'PageFooter',
}
</script>

<style>
@import '../assets/css/Footer.css';
</style>
