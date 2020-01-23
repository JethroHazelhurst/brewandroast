<style>

</style>

<template>
    <div class="page">
        <form>
            <div class="grid-container">
                <div class="grid-x grid-padding-x" v-for="(location, key) in locations">

                    <div class="large-12 medium-12 small-12 cell">
                        <h3>Location</h3>
                    </div>

                    <div class="large-6 medium-6 small-12 cell">
                        <label>
                            Location Name
                            <input type="text" placeholder="Location Name" v-model="locations[key].name">
                        </label>
                    </div>

                    <div class="large-6 medium-6 small-12 cell">
                        <label>
                            Address
                            <input type="text" placeholder="Address" v-model="locations[key].address">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].address.is_valid">
                            {{ validations.locations[key].address.text }}
                        </span>
                    </div>

                    <div class="large-6 medium-6 small-12 cell">
                        <label>
                            City
                            <input type="text" placeholder="City" v-model="locations[key].city">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].city.is_valid">
                            {{ validations.locations[key].city.text }}
                        </span>
                    </div>

                    <div class="large-6 medium-6 small-12 cell">
                        <label>
                            State
                            <input type="text" placeholder="State" v-model="locations[key].state">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].state.is_valid">
                            {{ validations.locations[key].state.text }}
                        </span>
                    </div>

                    <div class="large-6 medium-6 small-12 cell">
                        <label>
                            Zip
                            <input type="text" placeholder="Zip" v-model="locations[key].zip">
                        </label>
                        <span class="validation" v-show="!validations.locations[key].zip.is_valid">
                            {{ validations.locations[key].zip.text }}
                        </span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <label>Brew Methods Available</label>
                        <span class="brew-method" v-for="brewMethod in brewMethods">
                            <input v-bind:id="'brew-method-'+brewMethod.id+'-'+key" type="checkbox" v-bind:value="brewMethod.id" v-model="locations[key].methodsAvailable">
                            <label v-bind:for="'brew-method-'+brewMethod.id+'-'+key">
                                {{ brewMethod.method }}
                            </label>
                        </span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <a class="button" v-on:click="removeLocation( key )">Remove Location</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>

<script>

    /**
     *
     */
    export default {

        /**
         *
         */
        data(){
            return {
                name: '',
                locations: [],
                website: '',
                description: '',
                roaster: false,
                validations: {
                    name: {
                        is_valid: true,
                        text: ''
                    },
                    website: {
                        is_valid: true,
                        text: ''
                    },
                    locations: [],
                    oneLocation: {
                        is_valid: true,
                        text: ''
                    }
                }
            }
        },

        /**
         *
         */
        computed: {
            /**
             *
             */
            brewMethods(){
                return this.$store.getters.getBrewMethods;
            },

            /**
             *
             */
            addCafeStatus(){
                return this.$store.getters.getCafeAddStatus;
            }
        },

        /**
         *
         */
        watch: {
            'addCafeStatus': function(){
                if (this.addCafeStatus == 2) {
                    this.clearForm();
                    $("#cafe-added-successfully").show().delay(5000).fadeOut();
                }

                if (this.addCafeStatus == 3) {
                    $("#cafe-added-unsuccessfully").show().delay(5000).fadeOut();
                }
            }
        },

        /**
         *
         */
        methods: {

            clearForm(){
                this.name = '';
                this.locations = [];
                this.website = '';
                this.description = '';
                this.roaster = false;
                this.validations = {
                    name: {
                        is_valid: true,
                        text: ''
                    },
                    locations: [],
                    oneLocation: {
                        is_valid: true,
                        text: ''
                    },
                    website: {
                        is_valid: true,
                        text: ''
                    }
                };

                this.addLocation();
            },

            /**
             *
             */
            removeLocation( key ){
                this.locations.splice( key, 1 );
                this.validations.locations.splice( key, 1 );
            },

            /**
             *
             */
            addLocation(){
                this.locations.push({
                    name: '',
                    address: '',
                    city: '',
                    state: '',
                    zip: '',
                    methodssAvailable: []
                });

                this.validations.locations.push({
                    address: {
                        is_valid: true,
                        text: ''
                    },
                    city: {
                        is_valid: true,
                        text: ''
                    },
                    state: {
                        is_valid: true,
                        text: ''
                    },
                    zip: {
                        is_valid: true,
                        text: ''
                    }
                });

            },

            /**
             *
             */
            validateNewCafe(){

                let validNewCafeForm = true;

                /*
                 * Ensure a name has been entered
                 */
                if (this.name.trim() == '') {
                    validNewCafeForm = false;
                    this.validations.name.is_valid = false;
                    this.validations.name.text = 'Please enter a name for the company.';
                } else {
                    this.validations.name.is_valid =  true;
                    this.validations.name.text = '';
                }

                /*
                 * If a website has been entered, ensure the URL is valid
                 */
                if (this.website.trim != '' && !this.website.match(/^((https?):\/\/)?([w|W]{3}\.)+[a-zA-Z0-9\-\.]{3,}\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?$/)) {
                    validNewCafeForm = false;
                    this.validations.website.is_valid = false;
                    this.validations.website.text = 'Please enter a valid URL for the website!';
                } else {
                    this.validations.website.is_valid = true;
                    this.validations.website.text = '';
                }

                /*
                 * Ensure all locations entered are valid
                 */
                for (var index in this.locations) {
                    if (this.locations.hasOwnProperty(index)) {
                        /*
                         * Ensure an address has been entered
                         */
                        if (this.locations[index].address.trim() == '') {
                            validNewCafeForm = false;
                            this.validations.locations[index].address.is_valid = false;
                            this.validations.locations[index].address.text = 'Please enter an address for the new cafe!';
                        } else {
                            this.validations.locations[index].address.is_valid = true;
                            this.validations.locations[index].address.text = '';
                        }
                    }

                    /*
                     * Ensure a city has been entered
                     */
                    if (this.locations[index].city.trim() == '') {
                        validNewCafeForm = false;
                        this.validations.locations[index].city.is_valid = false;
                        this.validations.locations[index].city.text = 'Please enter a city for the new cafe!';
                    } else {
                        this.validations.locations[index].city.is_valid = true;
                        this.validations.locations[index].city.text = '';
                    }

                    /*
                     * Ensure a state has been entered
                     */
                    if (this.locations[index].state.trim() == '') {
                        validNewCafeForm = false;
                        this.validations.locations[index].state.is_valid = false;
                        this.validations.locations[index].state.text = 'Please enter a state for the new cafe!';
                    } else {
                        this.validations.locations[index].state.is_valid = true;
                        this.validations.locations[index].state.text = '';
                    }

                    /*
                     * Ensure a zip has been entered
                     */
                    if (this.locations[index].zip.trim() == '' || !this.locations[index].zip.match(/(^\d{5}$)/)){
                        validNewCafeForm = false;
                        this.validations.locations[index].zip.is_valid = false;
                        this.validations.locations[index].zip.text = 'Please enter a valid zip code for the new cafe!';
                    } else {
                        this.validations.locations[index].zip.is_valid = true;
                        this.validations.locations[index].zip.text = '';
                    }
                }

                return validNewCafeForm;
            },

            /**
             *
             */
            submitNewCafe(){
                if (this.validateNewCafe()) {
                    this.$store.dispatch('addCafe', {
                        name: this.name,
                        locations: this.locations,
                        website: this.website,
                        description: this.description,
                        roaster: this.roaster
                    });
                }
            },

        },

        /**
         *
         */
        created(){
            this.addLocation();
        }
    }
</script>
