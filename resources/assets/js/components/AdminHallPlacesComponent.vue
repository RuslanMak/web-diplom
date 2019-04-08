<template>

    <!--<div class="buying-scheme__wrapper">-->
        <!--<div v-for="row in halldata.hall.rows" class="buying-scheme__row">-->
            <!--&lt;!&ndash;v-bind:class="'buying-scheme__chair_' + classObj(halldata.places[totalPlaces].id)"&ndash;&gt;-->
            <!--<span v-for="n in halldata.hall.places_in_row"-->
                  <!--class="buying-scheme__chair"-->
                  <!--v-bind:class="'buying-scheme__chair_' + classObj(row, n)"-->
                  <!--@click="classAction(row, n)">-->
                <!--&lt;!&ndash;{{ halldata.places[n-1] }}&ndash;&gt;-->
                <!--{{totalPlaces}}-->
            <!--</span>-->
        <!--</div>-->
    <!--</div>-->


    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
            <li v-on:click="update()"><input type="radio" class="conf-step__radio" name="chairs-hall" value="Зал 1" checked><span class="conf-step__selector">Зал 1</span></li>
            <li><input type="radio" class="conf-step__radio" name="chairs-hall" value="Зал 2"><span class="conf-step__selector">Зал 2</span></li>
        </ul>
        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
            <label class="conf-step__label">Рядов, шт<input type="number" class="conf-step__input" placeholder="0" v-model="rows" ></label>
            <span class="multiplier">x</span>
            <label class="conf-step__label">Мест, шт<input type="number" class="conf-step__input" placeholder="8" v-model="places_in_row"></label>
        </div>
        <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала: {{rows}}</p>
        <div class="conf-step__legend">
            <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
            <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
            <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
            <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
        </div>

        <div class="conf-step__hall">
            <div class="conf-step__hall-wrapper">

                <!--<div v-for="row in halldata.hall.rows" class="conf-step__row">-->
                    <!--<span v-for="n in halldata.hall.places_in_row"-->
                          <!--class="conf-step__chair"-->
                          <!--v-bind:class="'conf-step__chair_' + classObj(row, n)"-->
                          <!--@click="classAction(row, n)">-->
                        <!--{{totalPlaces}}-->
                    <!--</span>-->
                <!--</div>-->

            </div>
        </div>

        <fieldset class="conf-step__buttons text-center">
            <button class="conf-step__button conf-step__button-regular">Отмена</button>
            <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>
    </div>

</template>

<script>
    export default {
        props: [
            //get data from Blade
            // 'connectionid'
            'halls'
        ],
        data: function() {
            return {
                halldata: [],
                rows: 0,
                places_in_row: 0,
                is_refresh: false,
                totalPlaces: 0
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update: function() {
                this.is_refresh = true
                // axios.get('/start/get-json/' + this.connectionid).then((response) => {
                axios.get('/start/get-json/' + 1).then((response) => {
                    // console.log(response)
                    this.halldata = response.data
                    this.is_refresh = false
                    // console.log(this.halls);
                    // console.log(this.halldata.hall.rows);
                    this.rows = this.halldata.hall.rows;
                    this.places_in_row = this.halldata.hall.places_in_row;
                });

            },
            
            classObj: function(row, n) {
                let place = this.halldata.places.filter(x => x["num_row"] === row).filter(x => x["num_place_in_row"] === n);
                if (place[0]) {
                    if (place[0].status === 'taken' || place[0].status === 'selected') {
                        //проверка или другой пользователь вибрал данное место, если да показивать как забронированое
                        if (place[0].id_user !== this.halldata.auth_user_id) {
                            return 'taken'
                        }
                        return place[0].status;
                    } else {
                        return place[0].type;
                    }
                } else {
                    return 'standart';
                }
            },

            classAction: function(row, n) {
                // let place = this.halldata.places.filter(x => x["num_row"] === row).filter(x => x["num_place_in_row"] === n);
                // if (place[0]) {
                //     axios.get('/start/update-ajax/' + place[0].id);
                // }
                // this.update();
            }

        }
    }
</script>
