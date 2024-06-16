<template>
    <div>
        <EventCategories/>
        <EventCard/>
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

<style>
    @import '../assets/css/styles.css';
</style>