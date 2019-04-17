<template>
    <main>
        <!--{{--данные фильма--}}-->
        <!--@foreach ($movies as $movie)-->
        <section v-for="movie in moviesFilter()" class="movie">

            <client-home-movi-component v-if="!is_refresh" :movie_id="movie.id_movie"></client-home-movi-component>

            <!--{{--данние зала и время начала фильма--}}-->
            <div class="movie-seances__hall">
                <!--@foreach ($halls as $hall)-->

                <!--<h3 class="movie-seances__hall-title">{{$hall->hall_name}}</h3>-->
                <ul class="movie-seances__list">
                    <!--@foreach ($timesOfMovie as $time)-->
                    <!--@if($time->id_movie === $movie->id && $time->id_hall === $hall->id)-->
                    <!--<li class="movie-seances__time-block"><a class="movie-seances__time" href="client/hall/{{$time->id}}">{{$time->start_time}}</a></li>-->
                    <!--@endif-->
                    <!--@endforeach-->
                </ul>
                <!--@endforeach-->
            </div>

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
                datas: []
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
                    let movies = [];
                    this.datas.forEach(movie => {
                        if(movieId !== movie.id_movie) {
                            movieId = movie.id_movie;

                            movies.push(movie);
                            this.idsMovie = movieId;
                        }
                    });
                    return movies;
                }
            },

            // hallFilter: function (movieData) {
            //     if (this.datas) {
            //         let hallId;
            //         let halls = [];
            //         movieData.forEach(hall => {
            //             if(hallId !== hall.id_hall) {
            //                 hallId = hall.id_hall;
            //
            //                 halls.push(hall);
            //             }
            //         });
            //         // console.dir(halls);
            //         return halls;
            //     }
            // },
            //
            // forShowMovieData: function () {
            //     if (moviesAllData[movie.id_movie]) {
            //
            //     }
            //     return false;
            // }


        }
    }
</script>
