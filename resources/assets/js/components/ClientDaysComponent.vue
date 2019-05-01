<template>

    <div>
        <nav class="page-nav">

            <div v-if="is_refresh" class="my-update-sign">
                <h2 style="font-size: 25px;">Пожалуйста подождите!!!</h2>
            </div>

            <template v-for="(day, index) in nowDay()">
                <a v-if="pageNumber === 0 && index === 0" class="page-nav__day page-nav__day_today" href="#" v-on:click="selectDay(day.date)">
                    <span class="page-nav__day-week">{{ day.dayIs }}</span><span class="page-nav__day-number">{{ day.date }}</span>
                </a>

                <a v-else class="page-nav__day" href="#" v-on:click="selectDay(day.date)">
                    <span class="page-nav__day-week">{{ day.dayIs }}</span><span class="page-nav__day-number">{{ day.date }}</span>
                </a>
            </template>

            <a class="page-nav__day " href="#" v-if="pageNumber !== 0" @click="prevPage" style="font-weight: 500; font-size: 2.1rem; text-align: center;"><</a>
            <a class="page-nav__day page-nav__day_next" href="#" v-if="pageNumber <= pageCount -1" @click="nextPage"></a>
        </nav>

        <client-home-component v-if="!is_refresh" :date_selected="dayForNextComponent"></client-home-component>
    </div>

</template>

<script>
    export default {
        props: [
            //get data from Blade
        ],
        data: function() {
            return {
                is_refresh: false,
                url: {
                    allDate: '/times-of-movies-and-more',
                },
                dates: [],
                dayForNextComponent: '',
                pageNumber: 0,  // по умолчанию 0
                size: 6
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

                axios.get(this.url.allDate)
                    .then(response => {
                        this.dates = response.data;
                        console.dir(this.dates);
                        this.is_refresh = false;

                        this.dayForNextComponent = this.dates[0].start_time.slice(0, 10);
                    })
                    .catch(error => {
                        console.log(error.response);
                        this.is_refresh = false;
                    });
            },

            nowDay: function () {
                let day;
                let days = [];
                this.paginatedData.forEach(date => {
                    let corentDate = date.start_time.slice(0, 10);

                    if(day !== corentDate) {
                        day = corentDate;

                        // получаем день недели
                        let dateNormFormat = new Date(corentDate);
                        let dayOfWeek = dateNormFormat.toLocaleString('ru', {weekday: 'short'});

                        days.push( {
                            'date': corentDate,
                            'dayIs': dayOfWeek
                        });
                    }
                });
                return days;
            },

            selectDay: function (day) {
                this.dayForNextComponent = day;
                // console.log(this.dayForNextComponent);
            },



            nextPage(){
                this.pageNumber++;
            },
            prevPage(){
                this.pageNumber--;
            }


        },

        computed:{
            pageCount(){
                let l = this.dates.length,
                    s = this.size;
                // console.log(l);
                return Math.ceil(l/s);
            },
            paginatedData(){
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                // console.dir(this.dates.slice(start, end));
                return this.dates.slice(start, end);
            }
        },
    }
</script>
