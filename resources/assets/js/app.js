require('./bootstrap');

window.Vue = require('vue');

/**
 * Here, I've thrown in the Transaction List compoennt, which is the entry point
 * to the authenticated application.
 */
Vue.component('transaction-list', require('./components/TransactionList.vue'));

/**
 * Now, I'm going to place the pre-compiled Laravel Passport components. This
 * allows you to scaffold out API token registration in a flash.
 */
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

/**
 * And, finally, let's bind the Vue instance to the page.
 */
const app = new Vue({
    el: '#app'
});
