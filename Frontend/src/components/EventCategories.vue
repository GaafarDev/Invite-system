<template>
    <div class="event-categories">
        <h1>Explore Categories</h1>
        <div class="category-list">
            <router-link
                v-for="category in categories"
                :key="category.name"
                :to="{ name: 'EventListByCategory', params: { categoryName: category.name } }"
                class="category-card">
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
*{
    margin : 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Montserrat', Arial, sans-serif;
}

.event-categories {
    text-align: center;
}

.event-categories h1{
    text-align: left;
    margin : 20px;
    margin-left : 6%;
    margin-right: 5%;
    color: #2D2C3C;
}

.category-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
}

.category-list a{
    text-decoration: none;
    color: #2D2C3C;
}

.category-card {
    width: 150px;
    text-align: center;
    margin-bottom: 20px;
}

.category-image {
    margin-top: 12px;
    width: 120px;
    height: 120px;
    border-radius: 500px;
    object-fit: cover;
}

.category-card h2 {
    margin: 10px 0;
    font-size: 14px;
}

.category-card:hover {
    transform: scale(1.05);
}
</style>
