import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../components/HomePage.vue';
import EventsPage from '../components/EventsPage.vue';
import MapPage from '../components/MapPage.vue';
import InvitationsPage from '../components/InvitationsPage.vue';
import OrganizerEventsPage from '../components/OrganizerEventsPage.vue';
import CreateEventPage from '../components/CreateEventPage.vue';
import OrganizerViewEventPage from '../components/OrganizerViewEventPage.vue';
import SendInvitationPage from '../components/SendInvitationPage.vue';
import EventListByCategory from '../components/EventlistByCategory.vue';

const routes = [
    { path: '/', component: HomePage },
    { path: '/events', component: EventsPage }, // the path is the name that shows in the URL
    { path: '/map', component: MapPage },
    { path: '/invitations', component: InvitationsPage },
    { path: '/organizer-events', component: OrganizerEventsPage },
    { path: '/create-event', component: CreateEventPage },
    { path: '/organizer-view-event/:eventId', component: OrganizerViewEventPage },
    { path: '/send-invitation', component: SendInvitationPage, name: 'SendInvitation' },
    { path: '/events/category/:categoryName', component: EventListByCategory, name: 'EventListByCategory' }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
