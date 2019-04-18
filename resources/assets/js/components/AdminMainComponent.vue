<template>

    <div>
        <section class="conf-step">

            <!--==================  Modal  =========================-->
            <!-- delete hall form -->
            <div v-if="showModalDeleteHall">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">
                            <div class="modal-body">
                                <slot name="body">
                                    <p class="conf-step__paragraph">Удалить зал???</p>
                                    <form method="post">
                                        <input class="conf-step__input" type="hidden" name="id_connection" :value="deleteHallId" required>
                                        <!--<p>{{deleteHallId}}</p>-->
                                        <button class="conf-step__button conf-step__button-accent" @click.prevent="deleteHallDo(deleteHallId)">Удалить</button>
                                        <!--<button class="conf-step__button conf-step__button-accent" type="submit">Удалить</button>-->
                                        <button class="conf-step__button conf-step__button-regular" @click="showModalDeleteHall=false">Отмена</button>
                                    </form>
                                </slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- create hall form -->
            <div v-if="showModalCreadeHall">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">
                            <div class="modal-body">
                                <slot name="body">
                                    <header class="conf-step__header">
                                        <h2 class="conf-step__title">Создание зала</h2>
                                    </header>
                                    <div class="conf-step__wrapper">
                                        <p class="conf-step__paragraph">Название зала:</p>
                                        <form method="post">
                                            <input  class="conf-step__input" type="text" name="hall_name" v-model="createHallData.hall_name" placeholder="Hall title" required>

                                            <button class="conf-step__button conf-step__button-accent" @click.prevent="createHallDo">Создать зал</button>
                                            <button class="conf-step__button conf-step__button-regular" @click="showModalCreadeHall=false">Отмена</button>
                                        </form>
                                    </div>
                                </slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--==================  END Modal  =========================-->

            <header class="conf-step__header conf-step__header_opened">
                <h2 class="conf-step__title">Управление залами</h2>
            </header>
            <div class="conf-step__wrapper">
                <p class="conf-step__paragraph">Доступные залы:</p>
                <ul class="conf-step__list">

                    <li v-for="hall in hallsdata">
                        {{ hall.hall_name }}
                        <button @click="showHallDeleteForm(hall.id)" class="conf-step__button conf-step__button-trash"></button>
                    </li>

                </ul>
                <!--<a href="/admin/create"><button class="conf-step__button conf-step__button-accent">Создать зал</button></a>-->
                <button @click="showModalCreadeHall = true" class="conf-step__button conf-step__button-accent">Создать зал</button>
            </div>
        </section>

        <admin-hall-places-component v-if="!is_refresh" :halls="hallsdata"></admin-hall-places-component>
        <admin-prices-component v-if="!is_refresh" :halls="hallsdata"></admin-prices-component>
        <admin-movie-time-component v-if="!is_refresh" :halls="hallsdata"></admin-movie-time-component>
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
