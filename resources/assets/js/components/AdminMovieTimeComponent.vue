<template>
    <section class="conf-step">
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Сетка сеансов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">
                <button class="conf-step__button conf-step__button-accent">Добавить фильм</button>
            </p>
            <div class="conf-step__movies">

                <div v-for="movie in all_data.movies" class="conf-step__movie">
                    <img class="conf-step__movie-poster" alt="poster" v-bind:src="movie.image">
                    <h3 class="conf-step__movie-title">{{ movie.name }}</h3>
                    <p class="conf-step__movie-duration">{{ movie.runtime }} минут</p>
                </div>

            </div>

            <div class="conf-step__seances">

                <div v-for="hall in halls" class="conf-step__seances-hall">
                    <h3 class="conf-step__seances-title">{{ hall.hall_name }}</h3>
                    <div class="conf-step__seances-timeline">

                        <div v-for="movieDate in moviesInHall(hall.id)" class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137);" v-bind:style="{ left: moviesMargLeft[movieDate.id] + 'px' }">
                            <p class="conf-step__seances-movie-title">{{ movieName(movieDate.id_movie) }}</p>
                            <p class="conf-step__seances-movie-start">{{ moviesTime[movieDate.id] }}</p>
                        </div>

                    </div>
                </div>

            </div>

            <fieldset class="conf-step__buttons text-center">
                <button class="conf-step__button conf-step__button-regular">Отмена</button>
                <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            //get data from Blade
            'halls_string'
        ],
        data: function() {
            return {
                all_data: [],
                is_refresh: false,
                halls: [],
                url: {
                    movies_connect: '/admin/get-all-movie'
                },
                moviesTime: [],
                moviesMargLeft: []
            }
        },

        mounted() {
            this.halls = JSON.parse(this.halls_string);
            this.update();
        },
        methods: {
            update: function() {
                this.is_refresh = true;

                axios.get(this.url.movies_connect).then((response) => {
                    this.all_data = response.data;
                    this.is_refresh = false;
                    // console.dir(this.all_data);

                    //обработка времени и занесение в массив moviesTime
                    this.all_data.connections.forEach(el => {
                        let normTime = this.timeOnly(el.start_time);
                        this.moviesTime[el.id] = normTime;
                        this.moviesMargLeft[el.id] = this.timeToPx(el.start_time);
                    });

                    console.dir(this.moviesMargLeft[1])
                }).catch((error) => {
                    console.log(error);
                });

            },

            moviesInHall: function (id_hall) {
                if (this.all_data.connections) {
                    let movieData = this.all_data.connections.filter(x => x["id_hall"] === id_hall);
                    return movieData;
                }
            },

            movieName: function (id_movie) {
                if (this.all_data.movies) {
                    let nameIs = this.all_data.movies.filter(x => x["id"] === id_movie);
                    return nameIs[0].name;
                }
            },

            timeOnly: function (date) {
                let d = new Date(date);
                let datestring = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
                return datestring;
            },

            timeToPx: function (date) {
                let d = new Date(date).setFullYear(1970, 1, 1);
                let procentTine = (d-2667601000) * 100 / 79199000;
                let marginLeft = Math.round(procentTine * 660 / 100);
                return marginLeft;
            }

        }
    }
</script>
