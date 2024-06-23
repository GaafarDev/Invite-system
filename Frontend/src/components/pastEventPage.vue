<template>
    <div class="past-events">
        <h2>Hosted Event History</h2>
        <div class="event-cards">
            <EventCard
                v-for="(event) in displayedPastEvents"
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
        <button v-if="showMorePastButton" @click="loadMorePast" class="see-more-btn">See More</button>
    </div>
</template>

<script>
import axios from 'axios';
import EventCard from './EventCard.vue';


export default {
    components: {
        EventCard,
    },
    data() {
        return {
            events: [],
            displayedPastEvents: [],
            pastLimit: 6,
        };
    },
    computed: {
        showMorePastButton() {
            return this.displayedPastEvents.length < this.pastEvents.length;
        },
        pastEvents() {
            const now = new Date();
            return this.events.filter(event => new Date(event.end_datetime) < now);
        }
    },
    methods: {
        loadMorePast() {
            this.pastLimit += 6;
            this.updateDisplayedPastEvents();
        },
        updateDisplayedPastEvents() {
            this.displayedPastEvents = this.pastEvents.slice(0, this.pastLimit);
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
                    this.updateDisplayedPastEvents();
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
    mounted() {
        this.fetchEvents();
    }
};
</script>

<style scoped>
    @import '../assets/css/UpcomingPassEventCard.css';
</style>