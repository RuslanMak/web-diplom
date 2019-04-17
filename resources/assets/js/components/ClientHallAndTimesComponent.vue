<template>
    <!--{{--данние зала и время начала фильма--}}-->
    <div>
        <div v-for="hall in hallsArr" class="movie-seances__hall">
            <!--@foreach ($halls as $hall)-->

            <!--<h3 class="movie-seances__hall-title">{{$hall->hall_name}}</h3>-->
            <h3 class="movie-seances__hall-title">{{ hall }}</h3>
            <ul class="movie-seances__list">
                <!--@foreach ($timesOfMovie as $time)-->
                <!--@if($time->id_movie === $movie->id && $time->id_hall === $hall->id)-->
                <!--<li class="movie-seances__time-block"><a class="movie-seances__time" href="client/hall/{{$time->id}}">{{$time->start_time}}</a></li>-->
                <!--@endif-->
                <!--@endforeach-->
            </ul>
            <!--@endforeach-->
        </div>
    </div>


</template>

<script>
    export default {
        props: [
            'hallsArr'
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
            console.dir(this.hallsArr);
            if(this.hallsArr) {
                this.update();
            }
        },

        // watch: {
        //     date_selected: function () {
        //         this.update();
        //     }
        // },

        methods: {
            update: function() {
                this.is_refresh = true;

                // axios.get(this.url.allDate + this.date_selected).then((response) => {
                //     this.datas = response.data;
                //     // console.dir(this.datas);
                //     this.is_refresh = false;
                // });
            },

            // hallFilter: function () {
            //     if (this.hallsArr) {
            //         let hallId;
            //         let halls = [];
            //         this.hallsArr.forEach(hall => {
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

            // moviesFilter: function () {
            //     if (this.datas) {
            //         let movieId;
            //         // let movies = [];
            //         let movies = {};
            //         this.datas.forEach(movie => {
            //             if(movieId !== movie.id_movie) {
            //                 movieId = movie.id_movie;
            //
            //                 movies[movieId] = [movie];
            //             } else {
            //                 movies[movieId].push(movie);
            //             }
            //         });
            //         // console.dir(movies);
            //         return movies;
            //     }
            // },

        }
    }
</script>
