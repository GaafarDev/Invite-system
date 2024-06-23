import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router';  // Correct path to router.js

const app = createApp(App);

app.use(router);
app.mount('#app');
