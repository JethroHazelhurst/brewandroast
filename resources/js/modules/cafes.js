/*
|-------------------------------------------------------------------------------
| VUEX modules/cafes.js
|-------------------------------------------------------------------------------
| The Vuex data store for the cafes
*/

import CafeAPI from '../api/cafe.js';

export const cafes = {

    /**
     * Defines the state.
     */
    state: {
        cafes: [],
        cafesLoadStatus: 0,

        cafe: {},
        cafeLoadStatus: 0,

        cafeAddStatus: 0
    },

    /**
     * Retrieves the data.
     */
    actions: {

        /**
         * Adds a cafe.
         */
        addCafe({commit, state, dispatch }, data){
            commit('setCafeAddedStatus', 1);

            CafeAPI.postAddNewCafe(data.name, data.locations, data.website, data.description, data.roaster)
                .then(function(response){
                    commit('setCafeAddedStatus', 2);
                    dispatch('loadCafes');
                })
                    .catch(function(){
                    commit('setCafeAddedStatus', 3);
                });
        },

        /**
         * Loads the cafes from the api.
         */
        loadCafes({commit}){
            commit('setCafesLoadStatus', 1);
            CafeAPI.getCafes()
                .then(function(response){
                    commit('setCafes', response.data);
                    commit('setCafesLoadStatus', 2);
                })
                .catch(function(){
                    commit('setCafes', []);
                    commit('setCafesLoadStatus', 3);
                });
        },

        /**
         * Loads an individual cafe from the api.
         */
        loadCafe({commit}, data){
            commit('setCafeLoadStatus', 1);
            CafeAPI.getCafe()
                .then(function(response){
                    commit('setCafe ', response.data);
                    commit('setCafeLoadStatus', 2);
                })
                .catch(function(){
                    commit('setCafe', {});
                    commit('setCafeLoadStatus', 3);
                });
        }
    },

    /**
     * Sets the state.
     */
    mutations: {
        /**
         * Sets the cafes load status.
         */
        setCafesLoadStatus(state, status){
            state.cafesLoadStatus = status;
        },

        /**
         * Sets the cafes.
         */
        setCafes(state, cafes){
            state.cafes = cafes;

        },

        /**
         * Sets the cafe load status.
         */
        setCafeLoadStatus(state, status){
            state.cafeLoadStatus = status;

        },

        /**
         * Sets the cafe.
         */
        setCafe(state, cafe){
            state.cafe = cafe;

        },

        /**
         * Set the cafe add status.
         */
        setCafeAddedStatus( state, status ){
            state.cafeAddStatus = status;
        }
    },

    /**
     * Retrieves the data from the state.
     */
    getters: {
        /**
         * Returns the cafes load status.
         */
        getCafesLoadStatus(state){
            return state.cafesLoadStatus;
        },

        /**
         * Returns the cafes.
         */
        getCafes(state){
            return state.cafes;
        },

        /**
         * Returns the cafe load status.
         */
        getCafeLoadStatus(state){
            return state.cafeLoadStatus;
        },

        /**
         * Returns the cafe.
         */
        getCafe(state){
            return state.cafe;
        },

        /*
         * Gets the cafe add status.
         */
        getCafeAddStatus( state ){
            return state.cafeAddStatus;
        }
    }
}
