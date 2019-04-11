<!--<style scoped>-->
    <!--.my-update-sign {-->
        <!--width: 50%;-->
        <!--position: fixed;-->
        <!--top: 50%;-->
        <!--left: 0;-->
        <!--background: rgba(256, 256, 0, 0.75);-->
        <!--text-align: center;-->
        <!--margin: 0 25%;-->
        <!--z-index: 99;-->
        <!--padding: 30px;-->
    <!--}-->
<!--</style>-->

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
            <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду: {{ selected_hall }}</p>
            <div class="conf-step__legend">
                <label class="conf-step__label">Рядов, шт<input type="text" class="conf-step__input" placeholder="0" v-model="rows" ></label>
                <span class="multiplier">x</span>
                <label class="conf-step__label">Мест, шт<input type="text" class="conf-step__input" placeholder="8" v-model="places_in_row"></label>
            </div>
            <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
            <div class="conf-step__legend">
                <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
                <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
                <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
                <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
            </div>

            <div class="conf-step__hall">
                <div class="conf-step__hall-wrapper">

                    <div v-for="row in rows" class="conf-step__row" v-bind:key="row">
                    <span v-for="place in places_in_row"
                          class="conf-step__chair"
                          v-bind:class="'conf-step__chair_' + classObj(row, place)"
                          @click="classAction(row, place)">
                        {{totalPlaces}}
                    </span>
                    </div>

                </div>
            </div>

            <fieldset class="conf-step__buttons text-center">
                <button v-on:click="cancel" class="conf-step__button conf-step__button-regular">Отмена</button>
                <input v-on:click="saveAll" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
            </fieldset>
        </div>
    </section>
</template>

<script>
    export default {
        props: [
            //get data from Blade
            // 'connectionid'
            'halls_string'
        ],
        data: function() {
            return {
                halldata: [],
                rows: 0,
                places_in_row: 0,
                is_refresh: false,
                totalPlaces: 0,
                selected_hall: 1,
                halls: [],
                url: {
                    updateRowNum: '/admin/post-api-row/',
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

            rows: function (newRows, oldRows) {
                this.debouncedUpdate(this.url.updateRowNum, this.rows);
            },

            places_in_row: function () {
                this.debouncedUpdate(this.url.updatePlaceInRowNum, this.places_in_row);
            }
        },

        beforeUpdate() {
            // this.rows;
            // console.log('ddddd');
        },

        created: function () {
            // _.debounce — это функция lodash, позволяющая ограничить то,
            // насколько часто может выполняться определённая операция.
            // В данном случае мы ограничиваем частоту обращений к api,
            // дожидаясь завершения печати вопроса перед отправкой ajax-запроса.
            // Узнать больше о функции _.debounce (и её родственнице _.throttle),
            // можно в документации: https://lodash.com/docs#debounce
            this.debouncedUpdate = _.debounce(this.updateRowsOrPlace, 400)
        },

        mounted() {
            this.halls = JSON.parse(this.halls_string);
            this.update()
        },
        methods: {
            update: function() {
                this.is_refresh = true;

                axios.get('/admin/get-api-places/' + this.selected_hall).then((response) => {
                    this.halldata = response.data;
                    this.is_refresh = false;
                    // console.dir(this.selected_hall);
                    if (this.halldata.hall.admin_doing_rows > 0) {
                        this.rows = this.halldata.hall.admin_doing_rows;
                    } else {
                        this.rows = this.halldata.hall.rows;
                    }

                    if (this.halldata.hall.admin_doing_places > 0) {
                        this.places_in_row = this.halldata.hall.admin_doing_places;
                    } else {
                        this.places_in_row = this.halldata.hall.places_in_row;
                    }

                });

            },

            //добавление класса месту
            classObj: function(row, n) {
                let place = this.halldata.places.filter(x => x["num_row"] === row).filter(x => x["num_place_in_row"] === n);

                if (place[0]) {
                    if (place[0].admin_doing_type.length > 1) {
                        return place[0].admin_doing_type;
                    } else {
                        return place[0].type;
                    }
                }
            },

            //при клике менять класс места
            classAction: function(row, num) {
                switch (this.doing_type_place) {
                    case 'disabled':
                        this.doing_type_place = 'standart';
                        break;
                    case 'standart':
                        this.doing_type_place = 'vip';
                        break;
                    case 'vip':
                        this.doing_type_place = 'disabled';
                        break;
                    default:
                        alert( 'Перебор' );
                }

                axios.get(this.url.doingTypePlace + row + '/' + num + '/' + this.doing_type_place + '/' + this.selected_hall)
                    .then(this.update());
            },

            updateRowsOrPlace: function (url, row_or_place) {
                // axios.post('/admin/post-api-row/' + 1, this.mypost);
                axios.get(url + this.selected_hall + '/' + row_or_place)
                    .then(this.update());
            },

            cancel: function () {
                const PASS = 'herePassword';
                axios.get(this.url.cancelUrl + PASS + '/' + this.selected_hall)
                    .then(this.update());
            },

            saveAll: function () {
                axios.get(this.url.saveUrl + this.selected_hall)
                    .then(this.update());
            }

        }
    }
</script>
