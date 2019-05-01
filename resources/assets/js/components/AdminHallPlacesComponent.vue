<template>
    <section class="conf-step">
        <div v-if="is_refresh" class="my-update-sign">
            <h2 style="font-size: 25px;">Пожалуйста подождите!!!</h2>
        </div>

        <header class="conf-step__header conf-step__header_opened">
            <h2 class="conf-step__title">Конфигурация залов</h2>
        </header>

        <div class="conf-step__wrapper">

            <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>

            <ul class="conf-step__selectors-box">
                <li v-for="hall in halls">
                    <input type="radio" class="conf-step__radio" name="chairs-hall" :value="hall.id" v-model="selected_hall">
                    <span class="conf-step__selector">{{ hall.hall_name }}</span>
                </li>
            </ul>
            <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Рядов, шт<input type="number" class="conf-step__input" placeholder="0" v-model="rows" ></label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">Мест, шт<input type="number" class="conf-step__input" placeholder="8" v-model="places_in_row"></label>
            </div>
            <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
            <div class="conf-step__legend">
                <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
            </div>

            <admin-hall-places-show-component
                v-if="selected_hall !== 0"
                :places_arr="halldata.places"
                :rows="Number(rows)"
                :places_in_row="Number(places_in_row)"
                :selected_hall="Number(selected_hall)"
                @update="update"
            >
            </admin-hall-places-show-component>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            'halls'
        ],
        data: function() {
            return {
                halldata: [],
                rows: 0,
                places_in_row: 0,
                is_refresh: false,
                totalPlaces: 0,
                selected_hall: 0,
                // halls: [],
                url: {
                    updateRowNum: '/admin/post-api-row/',
                    getApiPlaces: '/admin/get-api-places/',
                    updatePlaceInRowNum: '/admin/get-update-place-in-row/',
                    doingTypePlace: '/admin/get-update-type-place-doing/',
                    cancelUrl: '/admin/get-cancel-change/',
                    saveUrl: '/admin/get-save-change/'
                },
                doing_type_place: 'disabled'
            }
        },

        watch: {
            selected_hall: function () {
                this.update();
            },
        },

        mounted() {
            // this.halls = this.halls_string;
            this.update()
        },
        methods: {
            update: function() {
                // console.dir(this.halls_string);

                if (this.selected_hall !== 0) {
                    this.is_refresh = true;

                    axios.get(this.url.getApiPlaces + this.selected_hall)
                        .then(response => {
                            this.halldata = response.data;
                            this.is_refresh = false;
                            // console.dir(this.halldata);
                            this.rows = this.halldata.hall.rows;
                            this.places_in_row = this.halldata.hall.places_in_row;
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.is_refresh = false;
                        });
                }

            },

        }
    }
</script>
