/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import store from './store/index.js'
let token = store.getters.getToken;
import moment from 'moment'

axios.interceptors.request.use(function (config) {

    // spinning start to show
    // UPDATE: Add this code to show global loading indicator
    // console.log('started');
    document.getElementById('loading-spinner').style.display = 'block';
    return config
});

axios.interceptors.response.use(function (response) {
    
    // spinning hide
    // UPDATE: Add this code to hide global loading indicator
    // console.log('ended');
    document.getElementById('loading-spinner').style.display = 'none';

    // console.log("response:", response)
    // console.log("response.data:", response.data)

    if(response.data.reload_for_token_mismatch && response.data.reload_for_token_mismatch == 1){
        
        store.dispatch('removeToken')
        store.dispatch('removeUserInfo')
        // router.push({ name: 'Login' });
        const base_url = window.location.origin;
        window.location.href = base_url + '/login';
    }

    return response;
}, function (error) {
    // Do whatever you want with the response error here:
    // console.log("🚀 ~ error:", error)
    // console.log("🚀 ~ error.response:", error.response)
    // console.log("🚀 ~ error.response.data:", error.response.data)

    // if(error.response.data.message){
    //     alert(error.response.data.message);
    // }

    // for Laravel validation
    // if(error.response.status === 422){
    //     var errors = error.response.data.errors;
    //     $.each(errors, function(key, val) {
    //         alert(val[0]);
    //     });
    // }

    if( ! error.response){
        alert('Please check internet connection.\n Server connection problem!');
        location.reload();
    }

    // console.log('ended with errors');
    document.getElementById('loading-spinner').style.display = 'none';

    // But, be SURE to return the rejected promise, so the caller still has 
    // the option of additional specialized handling at the call-site:
    return Promise.reject(error);
  });

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Authorization'] = token;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

// register global methods
window.date_formating = (date=null, format=null) => {
    console.log("Hello from bootstrap.js")
    let new_date = "";
    if(date && format){
        new_date = moment(date).format(format);
    }
    console.log("From bootstrap.js ~ new_date:", new_date)
    return new_date;
}

// window.validation_errors = {
//     ff : 2
// };
