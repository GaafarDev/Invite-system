import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../components/HomePage.vue';
import EventsPage from '../components/EventsPage.vue';
import MapPage from '../components/MapPage.vue';
import InvitationsPage from '../components/InvitationsPage.vue';
import OrganizerEventsPage from '../components/OrganizerEventsPage.vue';
import CreateEventPage from '../components/CreateEventPage.vue';
import OrganizerViewEventPage from '../components/OrganizerViewEventPage.vue';
import SendInvitationPage from '../components/SendInvitationPage.vue';
import EventDetailsPage from '../components/EventDetailsPage.vue';

const routes = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component: HomePage, name: 'Home' },
        { path: '/events', component: EventsPage, name: 'Events' },
        { path: '/map', component: MapPage, name: 'Map' },
        { path: '/invitations', component: InvitationsPage, name: 'Invitations' },
        { path: '/organizer-events', component: OrganizerEventsPage, name: 'OrganizerEvents' },
        { path: '/create-event', component: CreateEventPage, name: 'CreateEvent' },
        { path: '/organizer-view-event/:eventId', component: OrganizerViewEventPage, name: 'ViewEventDetails' },
        { path: '/send-invitation', component: SendInvitationPage, name: 'SendInvitation' },
        { path: '/events/:eventId', component: EventDetailsPage, name: 'UserEventDetails' },
    ]
});

export default routes;
