<template>
    <!--<div class="container">-->
        <!--<div class="row">-->
            <!--<button @click="update" class="btn btn-default text mb-1" v-if="!is_refresh">Обновить - {{id}}...</button>-->
            <!--<span class="badge badge-primary mb-1" v-if="is_refresh">Обновление....</span>-->
            <!--<div class="col-md-12">-->

                <!--<table class="table">-->
                    <!--<thead>-->
                    <!--<tr>-->
                        <!--<th>Найменование</th>-->
                        <!--<th>URL</th>-->
                    <!--</tr>-->
                    <!--</thead>-->
                    <!--<tbody>-->
                    <!--<tr v-for="url in urldata">-->
                        <!--<td>{{url.title}}</td>-->
                        <!--<td>{{url.url}}</td>-->
                    <!--</tr>-->
                    <!--</tbody>-->
                <!--</table>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->

    <div class="buying-scheme__wrapper">
        <div v-for="row in halldata.hall.rows" class="buying-scheme__row">
            <span v-for="n in halldata.hall.places_in_row"
                  class="buying-scheme__chair"
                  v-bind:class="'buying-scheme__chair_' + classObj(row, n)"
                  @click="update">
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
                id: 0
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update: function () {
                this.is_refresh = true
                axios.get('/start/get-json/' + this.connectionid).then((response) => {
                    // console.log(response)
                    this.halldata = response.data
                    this.is_refresh = false
                    this.id++
                    console.log(this.id)
                });

            },
            
            classObj: function (row, n) {

                let index = this.halldata.places.filter(x => x["num_row"] == row).filter(x => x["num_place_in_row"] == n);

                if (index[0]) {
                    return index[0].type;
                } else {
                    return 'standart';
                }
            }

        }
    }
</script>
