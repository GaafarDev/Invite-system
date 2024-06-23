import { createRouter, createWebHistory } from 'vue-router';
import HomePage from '../components/HomePage.vue';
import EventsPage from '../components/EventsPage.vue';
import MapPage from '../components/MapPage.vue';
import InvitationsPage from '../components/InvitationsPage.vue';
import OrganizerEventsPage from '../components/OrganizerEventsPage.vue';
import CreateEventPage from '../components/CreateEventPage.vue';
import OrganizerViewEventPage from '../components/OrganizerViewEventPage.vue';
import SendInvitationPage from '../components/SendInvitationPage.vue';
import LoginPage from '../components/LoginPage.vue';
import SignupPage from '../components/SignupPage.vue';

const routes = [
    { path: '/', component: HomePage },
    { path: '/login', component: LoginPage, meta: { hideNavBarFooter: true } },
    { path: '/signup', component: SignupPage, meta: { hideNavBarFooter: true } },
    { path: '/events', component: EventsPage },
    { path: '/map', component: MapPage },
    { path: '/invitations', component: InvitationsPage },
    { path: '/organizer-events', component: OrganizerEventsPage },
    { path: '/create-event', component: CreateEventPage },
    { path: '/organizer-view-event', component: OrganizerViewEventPage },
    { path: '/send-invitation', component: SendInvitationPage, name: 'SendInvitation' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
