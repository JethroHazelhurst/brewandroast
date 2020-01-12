/**
 * Import vue and vuex.
 */
import Vue from 'vue';
import Vuex from 'vuex';

/**
 * Initialise vuex with vue.
 */
Vue.use( Vuex );

/**
 * Import all of the modules used in the application to build the data store.
 */
import { users } from './modules/users.js';
import { cafes } from './modules/cafes.js';

/**
 * Import all of the modules used in the application to build the data store.
 */
export default new Vuex.Store({
    modules: {
        users,
        cafes
    }
});
