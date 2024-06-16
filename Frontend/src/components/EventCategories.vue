<template> 
    <div class="event-categories">
        <h1>Explore Categories</h1>
        <div class="category-list">
            <router-link v-for="category in categories" :key="category.name" :to = "'#'" class="category-card">
                <div>
                    <img :src="category.imageSrc" :alt="category.name" class="category-image"/>
                    <h2>{{ category.name }}</h2>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EventCategories',
    data() {
        return {
            categories: [
                { name: 'Entertainment', imageSrc: require('../assets/Images/Entertainment.png') },
                { name: 'Educational & Business', imageSrc: require('../assets/Images/EducationalBusiness.png') },
                { name: 'Cultural & Arts', imageSrc: require('../assets/Images/CulturalArts.png') },
                { name: 'Sports & Fitness', imageSrc: require('../assets/Images/SportsFitness.png') },
                { name: 'Technology & Innovation', imageSrc: require('../assets/Images/TechnologyInnovation.png') },
                { name: 'Travel & Adventure', imageSrc: require('../assets/Images/TravelAdventure.png') },
            ],
        };
    },
}
</script>

<style>
    @import '../assets/css/EventCategories.css';
</style>
