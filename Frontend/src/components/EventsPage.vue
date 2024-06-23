<template>
    <div class="organizer-events-page">
        <h1>Upcoming Events</h1>
        <div class="filters">
            <button class="filter-btn">All</button>
            <button class="filter-btn">Today</button>
            <button class="filter-btn">Tomorrow</button>
            <button class="filter-btn">This Weekend</button>
            <button class="filter-btn">Free</button>
        </div>

        <div class="upcoming-events">
            <div class="event-cards">
                <EventCard
                    v-for="(event) in displayedUpcomingEvents"
                    :key="event.id"
                    :eventType="event.eventType"
                    :eventMonth="event.eventMonth"
                    :eventDays="event.eventDays"
                    :eventTitle="event.eventTitle"
                    :eventLocation="event.eventLocation"
                    :eventTime="event.eventTime"
                    :eventPrice="event.eventPrice"
                    :eventInterested="event.eventInterested"
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
                    :eventType="event.eventType"
                    :eventMonth="event.eventMonth"
                    :eventDays="event.eventDays"
                    :eventTitle="event.eventTitle"
                    :eventLocation="event.eventLocation"
                    :eventTime="event.eventTime"
                    :eventPrice="event.eventPrice"
                    :eventInterested="event.eventInterested"
                />
            </div>
            <button v-if="showMorePastButton" @click="loadMorePast" class="see-more-btn">See More</button>
        </div>
    </div>
</template>

<script>
import EventCard from './EventCard.vue';

export default {
    components: {
        EventCard,
    },
    data() {
        return {
            upcomingEvents: [
                { id: 1, eventType: "Travel & Adventure", eventMonth: "NOV", eventDays: "25 - 26", eventTitle: "Lakeside Camping at Pawna", eventLocation: "Jalan Sultan Yahya Petra, UTMKL", eventTime: "8:30 AM - 7:30 PM", eventPrice: "RM 100", eventInterested: 14 },
                { id: 2, eventType: "Music", eventMonth: "DEC", eventDays: "02", eventTitle: "Sound Of Christmas 2023", eventLocation: "KLCC, Kuala Lumpur", eventTime: "6:00 PM - 9:00 PM", eventPrice: "RM 150", eventInterested: 22 },
                { id: 3, eventType: "Education", eventMonth: "DEC", eventDays: "03", eventTitle: "Global Engineering Education Expo 2023", eventLocation: "UTM, Skudai", eventTime: "10:00 AM - 5:00 PM", eventPrice: "Free", eventInterested: 30 },
                { id: 4, eventType: "Business", eventMonth: "DEC", eventDays: "05", eventTitle: "Cricket Business Meetup", eventLocation: "Menara KL", eventTime: "2:00 PM - 5:00 PM", eventPrice: "RM 50", eventInterested: 8 },
                { id: 5, eventType: "Adventure", eventMonth: "FEB", eventDays: "14", eventTitle: "Valentine's Day Sail on a Yacht", eventLocation: "Marina Bay, Singapore", eventTime: "4:00 PM - 7:00 PM", eventPrice: "RM 200", eventInterested: 20 },
                { id: 6, eventType: "Entertainment", eventMonth: "MAR", eventDays: "20", eventTitle: "Beach Music Festival", eventLocation: "Langkawi", eventTime: "12:00 PM - 11:00 PM", eventPrice: "RM 300", eventInterested: 50 },
                { id: 7, eventType: "Education", eventMonth: "APR", eventDays: "15", eventTitle: "Tech Innovation Conference", eventLocation: "Putrajaya", eventTime: "9:00 AM - 6:00 PM", eventPrice: "RM 100", eventInterested: 45 },
                { id: 8, eventType: "Health", eventMonth: "MAY", eventDays: "01", eventTitle: "Yoga and Wellness Retreat", eventLocation: "Penang", eventTime: "7:00 AM - 3:00 PM", eventPrice: "RM 80", eventInterested: 18 }
            ],
            pastEvents: [
                { id: 9, eventType: "Music", eventMonth: "NOV", eventDays: "18", eventTitle: "Vocal Idol - Aditya Gandhi in Concert", eventLocation: "Sunway Pyramid, KL", eventTime: "7:00 PM - 10:00 PM", eventPrice: "RM 120", eventInterested: 25 },
                { id: 10, eventType: "Education", eventMonth: "OCT", eventDays: "25 - 27", eventTitle: "Camp United Nations for Girls", eventLocation: "Los Angeles, USA", eventTime: "9:00 AM - 4:00 PM", eventPrice: "USD 200", eventInterested: 35 },
                { id: 11, eventType: "Entertainment", eventMonth: "NOV", eventDays: "30", eventTitle: "Bollywood Gen Z Party", eventLocation: "Club XYZ, Mumbai", eventTime: "10:00 PM - 2:00 AM", eventPrice: "INR 1000", eventInterested: 40 },
                { id: 12, eventType: "Business", eventMonth: "OCT", eventDays: "10 - 11", eventTitle: "Global Business Summit", eventLocation: "New York, USA", eventTime: "8:00 AM - 6:00 PM", eventPrice: "USD 500", eventInterested: 60 },
                { id: 13, eventType: "Adventure", eventMonth: "SEP", eventDays: "15 - 16", eventTitle: "Mountain Hiking Adventure", eventLocation: "Mount Kinabalu, Sabah", eventTime: "5:00 AM - 7:00 PM", eventPrice: "RM 150", eventInterested: 28 },
                { id: 14, eventType: "Health", eventMonth: "AUG", eventDays: "05", eventTitle: "A Day of Wellbeing and Mindfulness", eventLocation: "Wellness Center, KL", eventTime: "8:00 AM - 5:00 PM", eventPrice: "RM 60", eventInterested: 15 },
                { id: 15, eventType: "Tech", eventMonth: "JUL", eventDays: "20 - 21", eventTitle: "Tech World Conference", eventLocation: "Silicon Valley, USA", eventTime: "9:00 AM - 6:00 PM", eventPrice: "USD 300", eventInterested: 80 },
                { id: 16, eventType: "Entertainment", eventMonth: "JUN", eventDays: "30", eventTitle: "Hyde Festival", eventLocation: "Hyde Park, London", eventTime: "2:00 PM - 11:00 PM", eventPrice: "GBP 100", eventInterested: 70 }
            ],
            displayedUpcomingEvents: [],
            displayedPastEvents: [],
            upcomingLimit: 6, // 2 rows of 3 events each
            pastLimit: 6, // 2 rows of 3 events each
        };
    },
    computed: {
        showMoreUpcomingButton() {
            return this.displayedUpcomingEvents.length < this.upcomingEvents.length;
        },
        showMorePastButton() {
            return this.displayedPastEvents.length < this.pastEvents.length;
        },
    },
    methods: {
        loadMoreUpcoming() {
            this.upcomingLimit += 6; // Load 2 more rows
            this.updateDisplayedUpcomingEvents();
        },
        loadMorePast() {
            this.pastLimit += 6; // Load 2 more rows
            this.updateDisplayedPastEvents();
        },
        updateDisplayedUpcomingEvents() {
            this.displayedUpcomingEvents = this.upcomingEvents.slice(0, this.upcomingLimit);
        },
        updateDisplayedPastEvents() {
            this.displayedPastEvents = this.pastEvents.slice(0, this.pastLimit);
        },
    },
    mounted() {
        this.updateDisplayedUpcomingEvents();
        this.updateDisplayedPastEvents();
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
    color: gray;
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
