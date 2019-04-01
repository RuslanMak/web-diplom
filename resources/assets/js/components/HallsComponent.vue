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
        <div v-for="n in halldata.rows" class="buying-scheme__row">
            <span v-for="n in halldata.places_in_row" class="buying-scheme__chair buying-scheme__chair_vip"></span>
        </div>
    </div>

</template>

<script>
    export default {
        props: [
            'hallid'
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
                // console.log(this.hallid)

                this.is_refresh = true
                axios.get('/start/get-json/' + this.hallid).then((response) => {
                    // console.log(response)
                    this.halldata = response.data
                    this.is_refresh = false
                    this.id++
                    console.log(this.halldata)
                });

            }
        }
    }
</script>
