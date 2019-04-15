<template>

    <div>
        <!--<input type="text" v-model="message">-->

        <!--<qr-code :text="message"></qr-code>-->
        <qr-code :text="strinDateTicket"></qr-code>
    </div>
</template>

<script>
    export default {
        props: [
            //get data
            'for_qr'
        ],

        data: function() {
            return {
                ticketInfo: [],
                strinDateTicket: ''
            }
        },

        mounted() {
            this.ticketInfo = JSON.parse(this.for_qr);
            this.update()
            // console.dir(this.for_qr);
        },

        methods: {
            update: function() {
                // console.dir(this.ticketInfo);
                this.strinDateTicket = 'Зал - ' + this.ticketInfo.hallName
                    + '; Фильм - ' + this.ticketInfo.movie
                    + '; Начало - ' + this.ticketInfo.startTime;

                let that = this;

                this.ticketInfo.places.forEach(function(place) {
                    // console.dir(place);
                    that.strinDateTicket += '; ряд - ' + place.num_row + ', место - ' + place.num_place_in_row;
                });

                console.dir(this.strinDateTicket);

            }
        }
    }
</script>