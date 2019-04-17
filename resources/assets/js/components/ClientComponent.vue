<template>
    <div>
        <nav class="page-nav">
            <a class="page-nav__day page-nav__day_today" href="#">
                <span class="page-nav__day-week">Пн</span><span class="page-nav__day-number">31</span>
            </a>
            <a class="page-nav__day" href="#">
                <span class="page-nav__day-week">Вт</span><span class="page-nav__day-number">1</span>
            </a>
            <a class="page-nav__day page-nav__day_chosen" href="#">
                <span class="page-nav__day-week">Ср</span><span class="page-nav__day-number">2</span>
            </a>
            <a class="page-nav__day" href="#">
                <span class="page-nav__day-week">Чт</span><span class="page-nav__day-number">3</span>
            </a>
            <a class="page-nav__day" href="#">
                <span class="page-nav__day-week">Пт</span><span class="page-nav__day-number">4</span>
            </a>
            <a class="page-nav__day page-nav__day_weekend" href="#">
                <span class="page-nav__day-week">Сб</span><span class="page-nav__day-number">5</span>
            </a>
            <a class="page-nav__day page-nav__day_next" href="#">
            </a>
        </nav>

        <!--<main>-->
            <!--&lt;!&ndash;{{&#45;&#45;данные фильма&#45;&#45;}}&ndash;&gt;-->
            <!--&lt;!&ndash;@foreach ($movies as $movie)&ndash;&gt;-->
            <!--<section class="movie">-->
                <!--<div class="movie__info">-->
                    <!--<div class="movie__poster">-->
                        <!--<img class="movie__poster-image" alt="Звёздные войны постер" src="{{ asset($movie->image) }}">-->
                    <!--</div>-->
                    <!--<div class="movie__description">-->
                        <!--<h2 class="movie__title">{{ $movie->name }}</h2>-->
                        <!--<p class="movie__synopsis">{{ $movie->description }}</p>-->
                        <!--<p class="movie__data">-->
                            <!--<span class="movie__data-duration">{{ $movie->runtime }} минут</span>-->
                            <!--<span class="movie__data-origin">{{ $movie->country }}</span>-->
                        <!--</p>-->
                    <!--</div>-->
                <!--</div>-->

                <!--&lt;!&ndash;{{&#45;&#45;данние зала и время начала фильма&#45;&#45;}}&ndash;&gt;-->
                <!--<div class="movie-seances__hall">-->
                    <!--@foreach ($halls as $hall)-->

                    <!--<h3 class="movie-seances__hall-title">{{$hall->hall_name}}</h3>-->
                    <!--<ul class="movie-seances__list">-->
                        <!--@foreach ($timesOfMovie as $time)-->
                        <!--@if($time->id_movie === $movie->id && $time->id_hall === $hall->id)-->
                        <!--<li class="movie-seances__time-block"><a class="movie-seances__time" href="client/hall/{{$time->id}}">{{$time->start_time}}</a></li>-->
                        <!--@endif-->
                        <!--@endforeach-->
                    <!--</ul>-->
                    <!--@endforeach-->
                <!--</div>-->

            <!--</section>-->
            <!--@endforeach-->

        <!--</main>-->
    </div>
</template>

<script>
    export default {
        props: [
            //get data from Blade
            // 'halls_string'
        ],
        data: function() {
            return {
                is_refresh: false,
                deleteHallId: 0,
                hallsdata: [],
                url: {
                    allHallsData: '/admin/get-all-halls',
                    deleteHall: '/admin/hall/',
                    createHall: '/admin/hall/'
                },
                showModalDeleteHall: false,
                showModalCreadeHall: false,
                createHallData: {}
            }
        },

        mounted() {
            // this.halls = JSON.parse(this.halls_string);
            this.update();
        },

        methods: {
            update: function() {
                // console.log('update');
                this.is_refresh = true;

                axios.get(this.url.allHallsData).then((response) => {
                    this.hallsdata = response.data;
                    this.is_refresh = false;
                    // console.dir(this.hallsdata);
                });
            },

            showHallDeleteForm: function (id) {
                this.deleteHallId = id;
                this.showModalDeleteHall = true;
            },

            deleteHallDo: function (id) {
                axios.delete(this.url.deleteHall + id)
                    .then(response => {
                        console.log(response);
                        this.update();
                        this.showModalDeleteHall = false;
                    })
                    .catch(error => {
                        this.showModalDeleteHall = false;
                        console.log(error.response)
                    });
            },

            createHallDo: function () {
                console.dir(this.createHallData);

                axios.post(this.url.createHall, this.createHallData)
                    .then(response => {
                        console.log(response);
                        this.update();
                        this.showModalCreadeHall = false;
                        this.createHallData.hall_name = '';
                    })
                    .catch(error => {
                        this.showModalCreadeHall = false;
                        console.log(error.response);
                        this.createHallData.hall_name = '';
                    });
            }

        }
    }
</script>
