<template>
    <div>
        <div v-for="hall in hallFilter()" class="movie-seances__hall">
            <h3 class="movie-seances__hall-title">{{ hall[0].hall_name }}</h3>

            <ul class="movie-seances__list">
                <li v-for="time in hall" class="movie-seances__time-block"><a class="movie-seances__time" :href="'client/hall/'+time.id">{{ timeOnly(time.start_time) }}</a></li>
            </ul>

        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'hallsArr'
        ],
        data: function() {
            return {
                // is_refresh: false,
            }
        },

        methods: {
            hallFilter: function () {
                if (this.hallsArr) {
                    let hallId;
                    let halls = {};
                    this.hallsArr.forEach(hall => {
                        if(hallId !== hall.id_hall) {
                            hallId = hall.id_hall;

                            halls[hallId] = [hall];
                        } else {
                            halls[hallId].push(hall);
                        }
                    });
                    // console.dir(halls);
                    return halls;
                }
            },

            timeOnly: function (date) {
                let d = new Date(date.replace(/-/g, "/"));
                let datestring = ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
                return datestring;
            },

        }
    }
</script>
