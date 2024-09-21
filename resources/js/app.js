import './bootstrap';

import { createApp } from 'vue'
import router from './router.js'
import App from './layouts/app.vue'
import store from './store/index.js'
// Global helper functions
// import common from './helpers/common.js'

//Sweet alert
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import moment from 'moment'

import FooterComponent from './components/includes/footer.vue';
import NavbarComponent from './components/includes/navbar.vue';
import RightSidebarComponent from './components/includes/right_navbar.vue';
import SidebarComponent from './components/includes/sidebar.vue';
// Global css
import '../css/main.css';

import VueApexCharts from "vue3-apexcharts";

const options = {
      position: 'top-end',
      timer: 5000,
};

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas)
/* end fontawesome core */

const app = createApp(App)
      .component('fa', FontAwesomeIcon)
      .use(router)
      .use(store)
      // .use(common)
      .use(VueSweetalert2, options)
      .use(VueApexCharts) // The app.use(VueApexCharts) will make <apexchart> component available everywhere.
      .use(moment);

// global propertise with methods
app.config.globalProperties.props = {
      anyFlag: true,
      modeMethod: (id=0) => {
            return id + 6;
      },
}

app.mount("#app")


