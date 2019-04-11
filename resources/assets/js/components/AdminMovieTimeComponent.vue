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

                <div class="conf-step__movie">
                    <!--<img class="conf-step__movie-poster" alt="poster" src="{{ asset('admin-style/i/poster.png') }}">-->
                    <h3 class="conf-step__movie-title">Звёздные войны XXIII: Атака клонированных клонов</h3>
                    <p class="conf-step__movie-duration">130 минут</p>
                </div>

            </div>

            <div class="conf-step__seances">
                <div class="conf-step__seances-hall">
                    <h3 class="conf-step__seances-title">Зал 1</h3>
                    <div class="conf-step__seances-timeline">
                        <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 0;">
                            <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                            <p class="conf-step__seances-movie-start">00:00</p>
                        </div>
                        <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 360px;">
                            <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                            <p class="conf-step__seances-movie-start">12:00</p>
                        </div>
                        <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 420px;">
                            <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                            <p class="conf-step__seances-movie-start">14:00</p>
                        </div>
                    </div>
                </div>
                <div class="conf-step__seances-hall">
                    <h3 class="conf-step__seances-title">Зал 2</h3>
                    <div class="conf-step__seances-timeline">
                        <div class="conf-step__seances-movie" style="width: 65px; background-color: rgb(202, 255, 133); left: 595px;">
                            <p class="conf-step__seances-movie-title">Звёздные войны XXIII: Атака клонированных клонов</p>
                            <p class="conf-step__seances-movie-start">19:50</p>
                        </div>
                        <div class="conf-step__seances-movie" style="width: 60px; background-color: rgb(133, 255, 137); left: 660px;">
                            <p class="conf-step__seances-movie-title">Миссия выполнима</p>
                            <p class="conf-step__seances-movie-start">22:00</p>
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
                movies_all: [],
                is_refresh: false,
                selected_hall: 1,
                halls: [],
                url: {
                    allMovies: '/admin/get-all-movie'
                }
            }
        },

        watch: {
            // selected_hall: function () {
            //     this.update();
            // }
        },

        mounted() {
            this.halls = JSON.parse(this.halls_string);
            this.update()
        },
        methods: {
            update: function() {
                this.is_refresh = true;

                axios.get(this.url.allMovies).then((response) => {
                    this.movies_all = response.data;
                    this.is_refresh = false;

                    // console.dir(this.halldata.hall.id_prices);
                });

            },

            saveBtn: function () {
                axios.post(this.url.saveUrl)
                    .then(this.update())
                    .catch((error) => {
                        console.log(error);
                    });
            }

        }
    }
</script>
