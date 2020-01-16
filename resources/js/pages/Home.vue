<style>

</style>

<template>
    <div id="cafes" class="page">
        <cafe-map></cafe-map>
        <cafe-list></cafe-list>

        <router-view></router-view>
    </div>
</template>

<script>
    import CafeMap from '../components/cafes/CafeMap.vue';
    import CafeList from '../components/cafes/CafeList.vue';
    export default {
        /**
         *
         */
        created(){
            this.$store.dispatch('loadCafes');
        },

        components: {
            CafeMap,
            CafeList
        },

        /**
         *
         */
        computed: {

            /**
             *
             */
            cafesLoadStatus(){
                return this.$store.getters.getCafesLoadStatus;
            },

            /**
             *
             */
            cafes(){
                return this.$store.getters.getCafes;
            }
        }
    }
</script>
