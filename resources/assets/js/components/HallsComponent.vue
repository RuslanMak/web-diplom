<template>

    <div>
        <div class="buying-scheme__wrapper">
            <div v-for="row in rows" class="buying-scheme__row">
                <!--v-bind:class="'buying-scheme__chair_' + classObj(halldata.places[totalPlaces].id)"-->
                <span v-for="n in halldata.hall.places_in_row"
                      class="buying-scheme__chair"
                      v-bind:class="'buying-scheme__chair_' + classObj(row, n)"
                      @click="classAction(row, n)">
                <!--{{ halldata.places[n-1] }}-->
                {{totalPlaces}}
            </span>
            </div>
        </div>

        <div class="buying-scheme__legend">
            <div class="col">
                <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">{{ price_standart }}</span>руб)</p>
                <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">{{ price_vip }}</span>руб)</p>
            </div>
            <div class="col">
                <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
                <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: [
            //get data form Blade
            'connectionid'
        ],
        data: function() {
            return {
                halldata: [],
                is_refresh: false,
                totalPlaces: 0,
                rows: 0,
                price_vip: 0,
                price_standart: 0,
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update: function() {
                this.is_refresh = true;
                axios.get('/start/get-json/' + this.connectionid).then((response) => {
                    // console.log(response)
                    this.halldata = response.data;
                    this.rows = this.halldata.hall.rows;
                    console.dir(this.halldata);
                    // console.dir(this.halldata.places.find(el=> el.type === 'standart').price);

                    this.price_vip = this.halldata.places.find(el=> el.type === 'vip').price;
                    this.price_standart = this.halldata.places.find(el=> el.type === 'standart').price;
                    this.is_refresh = false;
                    // console.log(this.halldata.user_id);
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
                let place = this.halldata.places.filter(x => x["num_row"] === row).filter(x => x["num_place_in_row"] === n);
                console.dir(place);
                if (place[0]) {

                    axios.get('/start/update-ajax/' + place[0].id);
                }
                this.update();
            }

        }
    }
</script>
