<template>
    <section class="conf-step">

        <div v-if="is_refresh" class="my-update-sign">
            <h2 style="font-size: 25px;">Пожалуйста подождите!!!</h2>
        </div>

        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Конфигурация цен</h2>
        </header>
        <div class="conf-step__wrapper">
            <form action="/admin/post-save-prices" method="post">
            <!--<form @submit.prevent="saveBtn()">-->

                <!--<input type="hidden" name="_token" :value="csrf">-->

                <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
                <ul class="conf-step__selectors-box">
                    <li v-for="hall in halls">
                        <input type="radio" class="conf-step__radio" name="id_hall" :value="hall.id" v-model="selected_hall">
                        <span class="conf-step__selector">{{ hall.hall_name }}</span>
                    </li>
                </ul>

                <div v-if="selected_hall != 0">
                    <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
                    <div class="conf-step__legend">
                        <input type="hidden" name="id_standart_place" :value="dataForm.id_standart_place">
                        <label class="conf-step__label">Цена, рублей<input type="number" step="0.01" min="0"  class="conf-step__input" name="standart_place" placeholder="0" v-model="dataForm.standart_place"></label>
                        за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
                    </div>
                    <div class="conf-step__legend">
                        <input type="hidden" name="id_vip_place" :value="dataForm.id_vip_place">
                        <label class="conf-step__label">Цена, рублей<input type="number" step="0.01" min="0"  class="conf-step__input" name="vip_place" placeholder="0" v-model="dataForm.vip_place"></label>
                        за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
                    </div>

                    <fieldset class="conf-step__buttons text-center">
                        <button v-on:click.prevent="update" class="conf-step__button conf-step__button-regular">Отмена</button>
                        <input v-on:click.prevent="saveBtn()" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
                        <!--<input v-on:click="saveBtn()" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">-->
                        <!--<input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">-->
                    </fieldset>
                </div>

            </form>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            //get data from Blade
            // 'halls_string',
            'halls'
        ],
        data: function() {
            return {
                halldata: [],
                is_refresh: false,
                selected_hall: 0,
                // halls: [],
                url: {
                    getApiPlaces: '/admin/get-api-places/',
                    saveUrl: '/admin/post-save-prices'
                },
                // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                dataForm: {
                    'id_hall': 0,
                    'id_standart_place': 0,
                    'standart_place': 0,
                    'id_vip_place': 0,
                    'vip_place': 20,
                }
            }
        },

        watch: {
            selected_hall: function () {
                this.dataForm.id_hall = this.selected_hall;
                this.update();
            }
        },

        mounted() {
            // this.halls = JSON.parse(this.halls_string);
            this.update();
        },
        methods: {
            update: function() {

                if (this.dataForm.id_hall !== 0) {
                    this.is_refresh = true;

                    axios.get(this.url.getApiPlaces + this.dataForm.id_hall)
                        .then(response => {
                            this.halldata = response.data;
                            this.is_refresh = false;

                            //добавление цены and ID
                            if (this.halldata.prices.vip) {
                                this.dataForm.vip_place = this.halldata.prices.vip.price;
                                this.dataForm.id_vip_place = this.halldata.prices.vip.id;
                            } else {
                                this.dataForm.vip_place = 0;
                                this.dataForm.id_vip_place = 0;
                            }

                            if (this.halldata.prices.standart) {
                                this.dataForm.standart_place = this.halldata.prices.standart.price;
                                this.dataForm.id_standart_place = this.halldata.prices.standart.id;
                            } else {
                                this.dataForm.standart_place = 0;
                                this.dataForm.id_standart_place = 0;
                            }
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.is_refresh = false;
                        });
                }

            },

            saveBtn: function () {
                console.dir(this.dataForm);
                axios.post(this.url.saveUrl, this.dataForm)
                    .then(response => {
                        console.log(response);
                        this.update();
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            }

        }
    }
</script>
