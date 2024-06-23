<template>
    <div class="upcoming-events">
        <h2>Upcoming Events</h2>
        <div class="event-cards">
            <EventCard
                v-for="(event) in displayedUpcomingEvents"
                :key="event.id"
                @click="goToEventDetails(event)"
                :eventType="event.category"
                :eventMonth="getMonth(event.start_datetime)"
                :eventDays="getDays(event.start_datetime, event.end_datetime)"
                :eventTitle="event.title"
                :eventLocation="event.location"
                :eventTime="getTime(event.start_datetime, event.end_datetime)"
                :eventPrice="getPrice(event.tickets)"
                :eventInterested="event.interests.length"
            />
        </div>
        <button v-if="showMoreUpcomingButton" @click="loadMoreUpcoming" class="see-more-btn">See More</button>
    </div>
</template>
<script>
    import axios from 'axios';
    import EventCard from './EventCard.vue';

    export default {
        components: {
            EventCard
        },

        data() {
            return {
                events: [],
                displayedUpcomingEvents: [],
                upcomingLimit: 6,
            };
        },
        computed: {
            showMoreUpcomingButton() {
                return this.displayedUpcomingEvents.length < this.upcomingEvents.length;
            },
            upcomingEvents() {
                const now = new Date();
                return this.events.filter(event => new Date(event.start_datetime) > now);
            },
        },
        methods:{
            loadMoreUpcoming() {
                this.upcomingLimit += 6;
                this.updateDisplayedUpcomingEvents();
            },
            updateDisplayedUpcomingEvents() {
                this.displayedUpcomingEvents = this.upcomingEvents.slice(0, this.upcomingLimit);
            },
            getMonth(datetime) {
                const date = new Date(datetime);
                return date.toLocaleString('default', { month: 'short' }).toUpperCase();
            },
            getDays(start, end) {
                const startDate = new Date(start);
                const endDate = new Date(end);
                if (startDate.getDate() === endDate.getDate()) {
                    return startDate.getDate();
                }
                return `${startDate.getDate()} - ${endDate.getDate()}`;
            },
            getTime(start, end) {
                const startTime = new Date(start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const endTime = new Date(end).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                return `${startTime} - ${endTime}`;
            },
            getPrice(tickets) {
                if (tickets.length === 0) {
                    return 'Free';
                }
                return `RM ${Math.min(...tickets.map(ticket => ticket.ticket_price))}`;
            },
            fetchEvents() {
                axios.get('http://127.0.0.1:8000/api/events')
                    .then(response => {
                        this.events = response.data;
                        this.updateDisplayedUpcomingEvents();
                    })
                    .catch(error => {
                        console.error("There was an error fetching the events!", error);
                    });
            },
            goToEventDetails(event) {
                this.$router.push({
                    name: 'ViewEventDetails',
                    params: {
                        eventId: event.id
                    }
                });
            }
        },
    }
</script>
<style scoped>
    @import '../assets/css/UpcomingPassEventCard.css';
</style>