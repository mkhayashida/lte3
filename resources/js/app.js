import './bootstrap';
//require('admin-lte');

import {createApp} from 'vue/dist/vue.esm-bundler';
import ReservationForm from './components/reservationForm.vue';
const app = createApp({})

app.component('reservation-form', ReservationForm);
app.mount('#app');