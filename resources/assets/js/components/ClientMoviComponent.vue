<template>
    <div class="movie__info">
        <div class="movie__poster">
            <img class="movie__poster-image" alt="Звёздные войны постер" :src="datas.image">
        </div>
        <div class="movie__description">
            <h2 class="movie__title">{{ datas.name }}</h2>
            <p class="movie__synopsis">{{ datas.description }}</p>
            <p class="movie__data">
            <span class="movie__data-duration">{{ datas.runtime }} минут</span>
            <span class="movie__data-origin">{{ datas.country }}</span>
            </p>
        </div>

        <client-home-hall-times-component v-if="!is_refresh" :hallsArr="movie_halls"></client-home-hall-times-component>
    </div>
</template>

<script>
    export default {
        props: [
            'movie_halls'
        ],

        data: function() {
            return {
                is_refresh: false,
                url: {
                    movieAllData: '/client-data-of-movie/',
                },
                datas: [],
            }
        },

        mounted() {
            this.update();
        },

        methods: {
            update: function() {
                this.is_refresh = true;
                console.dir(this.movie_halls);
                axios.get(this.url.movieAllData + this.movie_halls[0].id_movie).then((response) => {
                    this.datas = response.data;
                    // console.dir(this.datas);
                    this.is_refresh = false;
                });
            }

        },
    }
</script>
