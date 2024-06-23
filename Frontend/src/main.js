import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router.js';  // Correct path to router.js

const app = createApp(App);

app.use(router);
app.mount('#app');

