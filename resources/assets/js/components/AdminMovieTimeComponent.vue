<!--<style scoped>-->
    <!--.modal-mask {-->
        <!--position: fixed;-->
        <!--z-index: 9998;-->
        <!--top: 0;-->
        <!--left: 0;-->
        <!--width: 100%;-->
        <!--height: 100%;-->
        <!--background-color: rgba(0, 0, 0, .5);-->
        <!--display: table;-->
        <!--transition: opacity .3s ease;-->
    <!--}-->

    <!--.modal-wrapper {-->
        <!--display: table-cell;-->
        <!--vertical-align: middle;-->
    <!--}-->

    <!--.modal-container {-->
        <!--width: 600px;-->
        <!--margin: 0px auto;-->
        <!--padding: 20px 30px;-->
        <!--background-color: #fff;-->
        <!--border-radius: 2px;-->
        <!--box-shadow: 0 2px 8px rgba(0, 0, 0, .33);-->
        <!--transition: all .3s ease;-->
        <!--font-family: Helvetica, Arial, sans-serif;-->
    <!--}-->

    <!--.modal-header h3 {-->
        <!--margin-top: 0;-->
        <!--color: #42b983;-->
    <!--}-->

    <!--.modal-body {-->
        <!--margin: 20px 0;-->
    <!--}-->

    <!--.modal-body input,-->
    <!--.modal-body textarea {-->
        <!--width: 100%;-->
    <!--}-->

    <!--.modal-enter {-->
        <!--opacity: 0;-->
    <!--}-->

    <!--.modal-leave-active {-->
        <!--opacity: 0;-->
    <!--}-->

    <!--.modal-enter .modal-container,-->
    <!--.modal-leave-active .modal-container {-->
        <!-- -webkit-transform: scale(1.1);-->
        <!--transform: scale(1.1);-->
    <!--}-->
<!--</style>-->
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
                                <form id="uploadForm" enctype="multipart/form-data" method="post">

                                    <input class="conf-step__input" type="text" name="name" v-model="myNewMovie.name" placeholder="Movie title" required>
                                    <textarea class="conf-step__input" name="description" v-model="myNewMovie.description" rows="4"></textarea>
                                    <input class="conf-step__input" type="number" name="runtime" v-model="myNewMovie.runtime" placeholder="Runtime" required>
                                    <input class="conf-step__input" type="text" name="country" v-model="myNewMovie.country" placeholder="Country" required>
                                    <input class="conf-step__input" id="file" type="file" name="image" placeholder="image">

                                    <button class="conf-step__button conf-step__button-accent" @click.prevent="uploadFiles">Добавить фильм</button>
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
                                <p class="conf-step__paragraph">Выберите дату показа фильма:</p>

                                <form :action="url.saveTimeMovie" method="post">
                                    <!--<input type="hidden" name="_token" :value="csrf">-->

                                    <input class="conf-step__input" type="text" name="hall_name" :value="modalTimeData.hall_name" placeholder="Hall name" disabled>
                                    <input class="conf-step__input" type="hidden" name="id_hall" :value="modalTimeData.id" placeholder="hall id" required>
                                    <input class="conf-step__input" type="text" name="movie_name" :value="modalTimeData.name" placeholder="Movie name" disabled>
                                    <input class="conf-step__input" type="hidden" name="id_movie" v-model="modalTimeData.id" placeholder="id_movie" required>
                                    <input class="conf-step__input" type="datetime-local" name="start_time" v-model="modalTimeData.start_time" placeholder="Runtime" required>

                                    <button class="conf-step__button conf-step__button-accent" type="submit" @click.prevent="saveTimeM">Установить дату</button>
                                    <button class="conf-step__button conf-step__button-regular" @click="showModalTime=false">Отмена</button>
                                </form>
                            </slot>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal -->
        <!--==================  Modal - Добавить фильм =========================-->
        <div v-if="showModalDel">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-body">
                            <slot name="body">
                                <p class="conf-step__paragraph">Удалить с показа???</p>
                                <form method="post">
                                <!--<form :action="url.deleteMovieHall" method="post">-->
                                    <!--<input type="hidden" name="_token" :value="csrf">-->
                                    <input class="conf-step__input" type="hidden" name="id_connection" :value="deleteMovieHallId" required>

                                    <button class="conf-step__button conf-step__button-accent" @click.prevent="deleteMovieInHall">Удалить</button>
                                    <!--<button class="conf-step__button conf-step__button-accent" type="submit">Удалить</button>-->
                                    <button class="conf-step__button conf-step__button-regular" @click="showModalDel=false">Отмена</button>
                                </form>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal -->

        <!--==================  Modal - Выбор время для фильм =========================-->
        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Сетка сеансов</h2>
        </header>
        <div @dragover="moveFromHall()" class="conf-step__wrapper">
            <p class="conf-step__paragraph">
                <!-- Modal btn -->
                <button class="conf-step__button conf-step__button-accent" @click="showModal = true">Добавить фильм</button>
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

                        <div v-for="movieDate in moviesInHall(hall.id)"
                             class="conf-step__seances-movie"
                             style="width: 60px; background-color: rgb(133, 255, 137);"
                             v-bind:style="{ left: moviesMargLeft[movieDate.id] + 'px' }"
                             draggable="true" @dragstart="dragStart(movieDate, $event)"
                             @dragend="dragEnd"
                        >
                            <p class="conf-step__seances-movie-title">{{ movieName(movieDate.id_movie) }}</p>
                            <p class="conf-step__seances-movie-start">{{ moviesTime[movieDate.id] }}</p>
                        </div>

                    </div>
                </div>

            </div>

            <!--<fieldset class="conf-step__buttons text-center">-->
                <!--<button class="conf-step__button conf-step__button-regular">Отмена</button>-->
                <!--<input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">-->
            <!--</fieldset>-->
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
                    saveNewFilm: '/admin/save-new-movie',
                    saveTimeMovie: '/admin/save-new-time-for-movie',
                    deleteMovieHall: '/admin/delete-movie-for-hall/'
                },
                // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                moviesTime: [],
                moviesMargLeft: [],
                dragging: -1,
                showModal: false,
                showModalTime: false,
                showModalDel: false,
                modalTimeData: {},
                myNewMovie: {
                    'name': '',
                    'description': '',
                    'runtime': '',
                    'country': ''
                },
                deleteMovieHallId: 0
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

            uploadFiles () {
                var s = this;
                const data = new FormData(document.getElementById('uploadForm'));
                var imagefile = document.querySelector('#file');
                // console.log(imagefile.files[0]);
                data.append('image', imagefile.files[0]);
                data.append('name', s.myNewMovie.name);
                data.append('description', s.myNewMovie.description);
                data.append('runtime', s.myNewMovie.runtime);
                data.append('country', s.myNewMovie.country);
                axios.post(this.url.saveNewFilm, data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(response => {
                        console.log(response);
                        this.update();
                        this.showModal=false;
                    })
                    .catch(error => {
                        console.log(error.response)
                    });
            },

            saveTimeM: function () {
                axios.post(this.url.saveTimeMovie, this.modalTimeData)
                    .then(response => {
                        console.log(response);
                        this.update();
                        this.showModalTime = false;
                    })
                    .catch(error => {
                        console.log(error.response)
                    });
            },

            deleteMovieInHall: function () {
                console.log(this.deleteMovieHallId);
                axios.delete(this.url.deleteMovieHall + this.deleteMovieHallId)
                    .then(response => {
                        console.log(response);
                        this.update();
                        this.showModalDel = false;
                    })
                    .catch(error => {
                        this.showModalDel = false;
                        console.log(error.response)
                    });
            },

            //drag and drop
            dragStart(which, ev) {
                console.log('dragStart');
                ev.dataTransfer.setData('Text', this.id);
                ev.dataTransfer.dropEffect = 'move';
                this.dragging = which;
                // console.dir(which);
            },
            dragFinish(to, hall) {
                console.log('dragFinish');
                console.dir(this.dragging);
                // console.dir(hall);
                //переименовую id чтоб не было проблем слияния
                let hallDate = {'id_hall': hall.id, 'hall_name': hall.hall_name};
                //если выбрали фильм из списка - передаем выбранный элемент (фильм)
                if (this.dragging.runtime) {
                    this.moveItemToHall(this.dragging, hallDate, to);
                }
            },

            moveFromHall() {
                // проверяем или данный фильм имеет время старта, проверяем или мы выдвинули его из зала
                if (this.dragging.start_time && event.target.className === 'conf-step__wrapper') {
                    // console.log(this.dragging);
                    console.log(this.dragging.id);
                    this.deleteMovieHallId = this.dragging.id;
                    this.dragEnd();
                    this.showModalDel = true;
                }
            },
            moveItemToHall(movieData, hallData, to) {
                if (to === -1) {
                    console.dir('moveItem');
                    console.dir(movieData);

                    //копируем данные обекты в новый обект
                    this.modalTimeData = Object.assign({}, hallData, movieData);
                    // this.modalTimeData = Object.assign({}, movieData);
                    this.showModalTime = true;
                    console.dir(this.modalTimeData);
                }
            },
            dragEnd(ev) {
                console.log('dragEnd');
                // console.log(this.lol);
                this.dragging = -1
            }
            // END drag and drop

        }
    }
</script>
