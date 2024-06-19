import './bootstrap';
//require('admin-lte');

import {createApp} from 'vue/dist/vue.esm-bundler';
import ReservationForm from './components/reservationForm.vue';
import SnowWhite from './components/snowWhite.vue';
const app = createApp({})

app.component('reservation-form', ReservationForm);
app.component('snow-white', SnowWhite);
app.mount('#app');