<style>

</style>

<template>
    <div class="page">
        <form>
            <div class="grid-container">
                <div class="grid-x grid-padding-x">

                    <div class="large-12 medium-12 small-12 cell">
                        <label>Name
                            <input type="text" placeholder="Cafe name" v-model="name">
                        </label>
                        <span class="validation" v-show="!validations.name.is_valid">{{ validations.name.text }}</span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <label>Address
                            <input type="text" placeholder="Address" v-model="address">
                        </label>
                        <span class="validation" v-show="!validations.address.is_valid">{{ validations.address.text }}</span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <label>City
                            <input type="text" placeholder="City" v-model="city">
                        </label>
                        <span class="validation" v-show="!validations.city.is_valid">{{ validations.city.text }}</span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <label>State
                            <input type="text" placeholder="State" v-model="state">
                        </label>
                        <span class="validation" v-show="!validations.state.is_valid">{{ validations.state.text }}</span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <label>Zip
                            <input type="text" placeholder="Zip" v-model="zip">
                        </label>
                        <span class="validation" v-show="!validations.zip.is_valid">{{ validations.zip.text }}</span>
                    </div>

                    <div class="large-12 medium-12 small-12 cell">
                        <a class="button" v-on:click="submitNewCafe()">Add Cafe</a>
                    </div>

                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        /**
         *
         */
        data(){
            return {
                name: '',
                address: '',
                city: '',
                state: '',
                zip: '',
                validations: {
                    name: {
                        is_valid: true,
                        text: ''
                    },
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
                    },
                }
            }
        },

        /**
         *
         */
         methods: {
            submitNewCafe(){
                this.$store.dispatch('addCafe', {
                    name: this.name,
                    address: this.address,
                    city: this.city,
                    state: this.state,
                    zip: this.zip
                });
            }
        }
    }
</script>
