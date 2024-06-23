<template>
    <div>
        <p>This is the Events Page</p>
        <ul>
            <li v-for="event in events" :key="event.id">
                <h3>{{ event.title }}</h3>
                <p>{{ event.description }}</p>
                <!-- Display other event details as needed -->
            </li>
        </ul>
    </div>
</template>

<script>
import apiClient from '../services/api';

export default {
    data() {
        return {
            events: []
        };
    },
    mounted() {
        this.fetchEvents();
    },
    methods: {
        async fetchEvents() {
            try {
                const response = await apiClient.get('/api/events');
                this.events = response.data;
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        }
    }
};
</script>

<style>
/* Add your styles here */
</style>