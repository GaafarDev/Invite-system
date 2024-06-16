import {createRouter, createWebHistory} from 'vue-router';
import HomePage from '../components/HomePage.vue';
import EventsPage from '../components/EventsPage.vue';
import MapPage from '../components/MapPage.vue';
import InvitationsPage from '../components/InvitationsPage.vue';

const routes = createRouter({
    history: createWebHistory(),
    routes : [
        {path: '/', component: HomePage},
        {path: '/events', component: EventsPage}, //the path is the name that show in url
        {path: '/map',  component: MapPage},
        {path: '/invitations',  component: InvitationsPage},
    ]
});

export default routes;