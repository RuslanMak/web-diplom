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
    </div>
</template>

<script>
    export default {
        props: [
            //get data from Blade
            'movie_id'
        ],
        data: function() {
            return {
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
                axios.get(this.url.movieAllData + this.movie_id).then((response) => {
                    this.datas = response.data;
                    // console.dir(this.datas);
                });
            },

            // getDataOfMovie: function (movie_id) {
            //     axios.get(this.url.movieAllData + movie_id).then((response) => {
            //         this.moviesAllData[movie_id] = response.data;
            //         console.dir(this.moviesAllData);
            //     });
            // },


        }
    }
</script>
