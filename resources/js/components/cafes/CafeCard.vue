<style lang="scss">
    @import '~/abstracts/_variables.scss';
    div.cafe-card {

        border-radius: 5px;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16), 0 0 0 1px rgba(0,0,0,0.08);
        padding: 15px 5px 5px 5px;
        margin-top: 20px;
        cursor: pointer;
        -webkit-transform: scaleX(1) scaleY(1);
        transform: scaleX(1) scaleY(1);
        transition: .2s;

        span.title {
            display: block;
            text-align: center;
            color: black;
            font-size: 18px;
            font-weight: bold;
            font-family: 'Lato', sans-serif;
        }

        span.address {

            display: block;
            text-align: center;
            margin-top: 5px;
            color: $grey;
            font-family: 'Lato', sans-serif;

            span.street {
                font-size: 14px;
                display: block;
            }

            span.city {
                font-size: 14px;
            }

            span.state {
                font-size: 14px;
            }

            span.zip {
                font-size: 14px;
                display: block;
            }
        }
        span.liked-meta {

                color: $grey;
                font-size: 10px;
                margin-left: 5px;
                margin-right: 3px;

            img {
                width: 10px;
            }
        }

        &:hover {
            -webkit-transform: scaleX(1.041) scaleY(1.041);
            transform: scaleX(1.041) scaleY(1.041);
            transition: .2s;
        }
    }
</style>

<template>
    <div class="large-3 medium-4 small-6 cell cafe-card-container" v-show="show">
        <router-link :to="{name: 'cafe', params: {id: cafe.id}}">
            <div class="cafe-card">
                <!-- <span class="title">{{ cafe.company.name }}</span> -->
                <span class="address">
                    <span class="street">{{ cafe.address }}</span>
                    <span class="city">{{ cafe.city }}</span> <span class="state">{{ cafe.state }}</span>
                    <span class="zip">{{ cafe.zip }}</span>
                </span>
                <div class="meta-data">
                    <!-- <span class="liked-meta"><img v-bind:src="cafe.user_like_count > 0 ? '/img/liked.svg' : '/img/unliked.svg'"/> {{ cafe.likes_count }}</span> -->
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>
    export default {
        /*
         * The component accepts one cafe as a property
         */
        props: ['cafe'],

        /*
         * Define the data used by the component.
         */
        data(){
            return {
                show: true
            }
        },
    }
</script>
