import './bootstrap';

import { createApp } from 'vue'
import router from './router.js'
import App from './layouts/app.vue'
import store from './store/index.js'

//Sweet alert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import FooterComponent from './components/includes/footer.vue';
import NavbarComponent from './components/includes/navbar.vue';
import RightSidebarComponent from './components/includes/right_navbar.vue';
import SidebarComponent from './components/includes/sidebar.vue';



createApp(App)
      .use(router)
      .use(store)
      .use(VueSweetalert2)
      .mount("#app")


