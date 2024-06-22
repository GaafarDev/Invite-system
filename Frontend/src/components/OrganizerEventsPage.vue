<template>
    <div class="organizer-events-page">
        <h1>All Hosted Events</h1>
        <div class="filters">
            <button class="filter-btn">All</button>
            <button class="filter-btn">Today</button>
            <button class="filter-btn">Tomorrow</button>
            <button class="filter-btn">This Weekend</button>
            <button class="filter-btn">Free</button>
        </div>

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
            displayedUpcomingEvents: [],
            displayedPastEvents: [],
            upcomingLimit: 6,
            pastLimit: 6,
        };
    },
    computed: {
        showMoreUpcomingButton() {
            return this.displayedUpcomingEvents.length < this.upcomingEvents.length;
        },
        showMorePastButton() {
            return this.displayedPastEvents.length < this.pastEvents.length;
        },
        upcomingEvents() {
            const now = new Date();
            return this.events.filter(event => new Date(event.start_datetime) > now);
        },
        pastEvents() {
            const now = new Date();
            return this.events.filter(event => new Date(event.end_datetime) < now);
        }
    },
    methods: {
        loadMoreUpcoming() {
            this.upcomingLimit += 6;
            this.updateDisplayedUpcomingEvents();
        },
        loadMorePast() {
            this.pastLimit += 6;
            this.updateDisplayedPastEvents();
        },
        updateDisplayedUpcomingEvents() {
            this.displayedUpcomingEvents = this.upcomingEvents.slice(0, this.upcomingLimit);
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
                    this.updateDisplayedUpcomingEvents();
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
.organizer-events-page {
    padding: 20px;
    margin-left : 5%;
    margin-right: 5%;
}

.filters {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.filter-btn {
    padding: 10px 20px;
    background-color: #f0f0f0;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.filter-btn:hover {
    background-color: #d0d0d0;
}

.upcoming-events, .past-events {
    margin-bottom: 40px;

}

.event-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 62px;
}


.see-more-btn {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s;
    border-radius: 5px;
}

.see-more-btn:hover {
    background-color: #0056b3;
}
</style>