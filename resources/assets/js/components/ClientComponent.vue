<template>
    <main>
        <!--{{--данные фильма--}}-->
        <!--@foreach ($movies as $movie)-->
        <section v-for="movie in moviesFilter()" class="movie">

            <client-home-movi-component v-if="!is_refresh" :movie_halls="movie"></client-home-movi-component>

        </section>
        <!--@endforeach-->

    </main>
</template>

<script>
    export default {
        props: [
            //get data from Blade
            'date_selected'
        ],
        data: function() {
            return {
                is_refresh: false,
                url: {
                    allDate: '/client-data-of-selected-date/',
                },
                datas: [],
            }
        },

        mounted() {
            if(this.date_selected) {
                this.update();
            }
        },

        watch: {
            date_selected: function () {
                this.update();
            }
        },

        methods: {
            update: function() {
                this.is_refresh = true;

                axios.get(this.url.allDate + this.date_selected).then((response) => {
                    this.datas = response.data;
                    // console.dir(this.datas);
                    this.is_refresh = false;
                });
            },

            moviesFilter: function () {
                if (this.datas) {
                    let movieId;
                    // let movies = [];
                    let movies = {};
                    this.datas.forEach(movie => {
                        if(movieId !== movie.id_movie) {
                            movieId = movie.id_movie;

                            movies[movieId] = [movie];
                        } else {
                            movies[movieId].push(movie);
                        }
                    });
                    // console.dir(movies);
                    return movies;
                }
            },
        }
    }
</script>
