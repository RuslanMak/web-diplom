<template>

    <div class="buying-scheme__wrapper">
        <div v-for="row in halldata.hall.rows" class="buying-scheme__row">
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
                totalPlaces: 0
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update: function() {
                this.is_refresh = true
                axios.get('/start/get-json/' + this.connectionid).then((response) => {
                    // console.log(response)
                    this.halldata = response.data
                    this.is_refresh = false
                });

            },
            
            classObj: function(row, n) {
                let index = this.halldata.places.filter(x => x["num_row"] == row).filter(x => x["num_place_in_row"] == n);
                if (index[0]) {
                    if (index[0].status == 'selected' || index[0].status == 'taken') {
                        return index[0].status;
                    } else {
                        return index[0].type;
                    }
                } else {
                    return 'standart';
                }
            },

            classAction: function(row, n) {
                let index = this.halldata.places.filter(x => x["num_row"] == row).filter(x => x["num_place_in_row"] == n);
                if (index[0]) {
                    console.log(index[0].id)
                    return index[0].id;
                }
            }

        }
    }
</script>
