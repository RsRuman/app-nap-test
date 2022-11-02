import './bootstrap';

import { createApp } from 'vue';

import router from "./Router/router.js";
import store from "./Store/store.js";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';


const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);


app.use(router);
app.use(store);
app.use(VueSweetalert2);
app.mount('#app');

