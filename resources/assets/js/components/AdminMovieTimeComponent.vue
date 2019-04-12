<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-body input,
    .modal-body textarea {
        width: 100%;
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
<template>
    <section class="conf-step">
        <!--==================  Modal - Добавить фильм =========================-->
        <div v-if="showModal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-header">
                            <slot name="header">
                                <h3 slot="header">Добавление фильма</h3>
                            </slot>
                        </div>

                        <div class="modal-body">
                            <slot name="body">
                                <p class="conf-step__paragraph">Заполните данные:</p>
                                <form class="" action="/admin/save-new-movie" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" :value="csrf">

                                    <input class="conf-step__input" type="text" name="name" value="" placeholder="Movie title" required>
                                    <textarea class="conf-step__input" name="description" id="exampleFormControlTextarea1" rows="4"></textarea>
                                    <input class="conf-step__input" type="number" name="runtime" value="" placeholder="Runtime" required>
                                    <input class="conf-step__input" type="text" name="country" value="" placeholder="Country" required>
                                    <input class="conf-step__input" type="file" name="image" value="" placeholder="image">

                                    <button class="conf-step__button conf-step__button-accent" type="submit">Добавить фильм</button>
                                    <button class="conf-step__button conf-step__button-regular" @click="showModal=false">Отмена</button>
                                </form>
                            </slot>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal -->

        <!--==================  Modal - Выбор время для фильм =========================-->
        <div v-if="showModalTime">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-header">
                            <slot name="header">
                                <h3 slot="header">Установка даты фильма</h3>
                            </slot>
                        </div>

                        <div class="modal-body">
                            <slot name="body">
                                <p class="conf-step__paragraph">Заполните данные:</p>

                                <form class="" action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" :value="csrf">

                                    <input class="conf-step__input" type="text" name="hall_name" value="" placeholder="Hall name" required>
                                    <input class="conf-step__input" type="number" name="id_hall" value="" placeholder="hall id" required>
                                    <input class="conf-step__input" type="text" name="movie_name" value="" placeholder="Movie name" required>
                                    <input class="conf-step__input" type="number" name="id_movie" value="" placeholder="id_movie" required>
                                    <input class="conf-step__input" type="datetime-local" name="start_time" value="" placeholder="Runtime" required>

                                    <button class="conf-step__button conf-step__button-accent" type="submit">Установить дату</button>
                                    <button class="conf-step__button conf-step__button-regular" @click="showModalTime=false">Отмена</button>
                                </form>
                            </slot>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal -->
        <!--===========================================-->
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Сетка сеансов</h2>
        </header>
        <div class="conf-step__wrapper">
            <p class="conf-step__paragraph">
                <!-- Modal btn -->
                <button class="conf-step__button conf-step__button-accent" @click="showModal = true">Добавить фильм</button>
                <button class="conf-step__button conf-step__button-accent" @click="showModalTime = true">showModalTime</button>
                <button v-on:click="addMovieBtn" class="conf-step__button conf-step__button-accent">Добавить фильм</button>
            </p>
            <div class="conf-step__movies">

                <div v-for="movie in all_data.movies" class="conf-step__movie"
                     draggable="true" @dragstart="dragStart(movie, $event)"
                     @dragend="dragEnd"
                >
                    <img class="conf-step__movie-poster" alt="poster" v-bind:src="movie.image">
                    <h3 class="conf-step__movie-title">{{ movie.name }}</h3>
                    <p class="conf-step__movie-duration">{{ movie.runtime }} минут</p>
                </div>

            </div>

            <div class="conf-step__seances">

                <div v-for="hall in halls" class="conf-step__seances-hall" @dragover.prevent @drop="dragFinish(-1, hall)">
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
                    movies_connect: '/admin/get-all-movie',
                    addFilm: '/admin/create_movie'
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                moviesTime: [],
                moviesMargLeft: [],

                //add strart
                dragging: -1,
                //add end
                showModal: false,
                showModalTime: false
            }
        },

        mounted() {
            this.halls = JSON.parse(this.halls_string);
            this.update();
        },
        methods: {
            update: function() {
                localStorage.clear();
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
            },

            addMovieBtn: function () {
                return location.href = this.url.addFilm;
            },




            //add strart
            dragStart(which, ev) {
                console.log('dragStart');
                ev.dataTransfer.setData('Text', this.id);
                ev.dataTransfer.dropEffect = 'move'
                this.dragging = which;
            },
            dragFinish(to, hall) {
                console.log('dragFinish');
                console.dir(hall);
                //передаем выбранный элемент (фильм)
                this.moveItem(this.dragging, to);
                // ev.target.style.marginTop = '2px'
            },
            moveItem(movieData, to) {
                if (to === -1) {
                    console.dir('moveItem');
                    console.dir(movieData);
                }
            },
            dragEnd(ev) {
                console.log('dragEnd');
                this.dragging = -1
            }

            //add end

        }
    }
</script>
