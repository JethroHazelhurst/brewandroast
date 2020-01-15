<style lang="scss">
    #cafe-map {
        width: 100%;
        height: 400px;
    }
</style>

<template>
    <div id="cafe-map">

    </div>
</template>

<script>
    export default {

        /**
         *
         */
        data(){
            return {
                markers: [

                ]
            }
        },

        /**
         *
         */
        computed: {
            /**
             * Gets the cafes
             */
            cafes(){
                return this.$store.getters.getCafes;
            }
        },

        /**
         *
         */
        methods: {
            /*
  Clears the markers from the map.
*/
clearMarkers(){
  /*
    Iterate over all of the markers and set the map
    to null so they disappear.
  */
  for( var i = 0; i < this.markers.length; i++ ){
    this.markers[i].setMap( null );
  }
},
            buildMarkers(){
                /*
                   Initialize the markers to an empty array.
                 */
                 this.markers = [];

                 /*
                   Iterate over all of the cafes
                 */
                 for( var i = 0; i < this.cafes.length; i++ ){

                   /*
                     Create the marker for each of the cafes and set the
                     latitude and longitude to the latitude and longitude
                     of the cafe. Also set the map to be the local map.
                   */
                   var marker = new google.maps.Marker({
                     position: { lat: parseFloat( this.cafes[i].latitude ), lng: parseFloat( this.cafes[i].longitude ) },
                     map: this.map
                   });

                   /*
                     Push the new marker on to the array.
                   */
                   this.markers.push( marker );
                 }
            }
        },

        /**
         *
         */
        watch: {
    cafes(){
        this.clearMarkers();
            this.buildMarkers();
    }
},

        /**
         *
         */
        props: {
            'latitude': {
                type: Number,
                default: function(){
                    return 54.893550
                }
            },
            'longitude': {
                type: Number,
                default: function(){
                    return -2.873730
                }
            },
            'zoom': {
                type: Number,
                default: function(){
                    return 12
                }
            }
        },

        /**
         *
         */
        mounted(){
            /*
             * We don't want the map to be reactive, so we initialize it locally,
             * but don't store it in our data array.
             */
            this.map = new google.maps.Map(document.getElementById('cafe-map'), {
                center: {
                    lat: this.latitude,
                    lng: this.longitude
                },
                zoom: this.zoom
            });

            /*
  Clear and re-build the markers
*/
this.clearMarkers();
this.buildMarkers();
        }
    }
</script>
