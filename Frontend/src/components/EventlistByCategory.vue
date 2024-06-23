<template>
    <div class="event-list">
        <h1>{{ categoryName }} Events</h1>
        <div class="event-cards">
            <EventCard 
                v-for="event in mappedEvents" 
                :key="event.id" 
                :event-id="event.id"
                @click="goToEventDetails(event.id)"
                :event-type="event.eventType" 
                :event-month="event.eventMonth"
                :event-days="event.eventDays"
                :event-title="event.eventTitle"
                :event-location="event.eventLocation"
                :event-time="event.eventTime"
                :event-price="event.eventPrice"
                :event-interested="event.eventInterested"
            />
        </div>
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
            filteredEvents: []
        };
    },
    computed: {
        categoryName() {
            return this.$route.params.categoryName;
        },
        mappedEvents() {
            return this.filteredEvents.map(event => ({
                id: event.id,
                eventType: event.category,
                eventMonth: new Date(event.start_datetime).toLocaleString('default', { month: 'short' }).toUpperCase(),
                eventDays: `${new Date(event.start_datetime).getDate()} - ${new Date(event.end_datetime).getDate()}`,
                eventTitle: event.title,
                eventLocation: event.location,
                eventTime: `${new Date(event.start_datetime).toLocaleTimeString()} - ${new Date(event.end_datetime).toLocaleTimeString()}`,
                eventPrice: `RM ${event.tickets[0]?.ticket_price || 0}`,
                eventInterested: event.interested || 0,
            }));
        }
    },
    methods: {
        fetchEvents() {
            axios.get('http://127.0.0.1:8000/api/events')
                .then(response => {
                    this.events = response.data;
                    this.filterEventsByCategory();
                })
                .catch(error => {
                    console.error("There was an error fetching the events!", error);
                });
        },
        filterEventsByCategory() {
            this.filteredEvents = this.events.filter(event => event.category === this.categoryName);
        },
        goToEventDetails(eventId) {
            this.$router.push({ name: 'ViewEventDetails', params: { eventId } });
        }
    },
    watch: {
        categoryName() {
            this.filterEventsByCategory();
        },
    },
    mounted() {
        this.fetchEvents();
    },
};
</script>

<style>
.event-list {
    padding: 20px;
    margin-left: 5%;
    margin-right: 5%;
}

.event-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}
</style>
