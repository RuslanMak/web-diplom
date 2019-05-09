<template>
    <div>
        <div class="conf-step__hall">
            <div class="conf-step__hall-wrapper">

                <div v-for="row in rows" class="conf-step__row" v-bind:key="row">
                    <span v-for="place in places_in_row"
                          class="conf-step__chair"
                          v-bind:class="'conf-step__chair_' + classObj(row, place)"
                          @click="classAction(row, place, classObj(row, place))"
                          v-model="clicks">
                    </span>
                </div>
                <!--<input type="text" v-model="clicks">-->

            </div>
        </div>

        <fieldset class="conf-step__buttons text-center">
            <button v-on:click="cancel" class="conf-step__button conf-step__button-regular">Отмена</button>
            <input v-on:click="saveAll" type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>
    </div>
</template>

<script>
    export default {
        props: {
            'places_arr': Array,
            'rows': Number,
            'places_in_row': Number,
            'selected_hall': Number,
        },
        data: function() {
            return {
                url: {
                    updateTypePlace: '/admin/get-update-type-place-doing/',
                },
                doing_type_place: 'disabled',
                doing_type_arr: {},
                clicks: 0
            }
        },

        watch: {
            selected_hall: function () {
                this.update();
            },
        },

        methods: {
            update: function() {
                this.doing_type_arr = {};
            },

            //добавление класса месту
            classObj: function(row, n) {
                let place = this.places_arr.filter(x => x["num_row"] === row).filter(x => x["num_place_in_row"] === n);

                if (this.doing_type_arr.hasOwnProperty(row + '_' + n)) {
                    return this.doing_type_arr[row + '_' + n].type;
                } else if (place[0]) {
                    return place[0].type;
                } else {
                    return 'doing_class';
                }
            },

            //при клике менять класс места
            classAction: function(row, num, the_class) {
                let newClass;
                switch (the_class) {
                    case 'disabled':
                        newClass = 'standart';
                        break;
                    case 'standart':
                        newClass = 'vip';
                        break;
                    case 'vip':
                        newClass = 'disabled';
                        break;
                    case 'doing_class':
                        newClass = 'standart';
                        break;
                    default:
                        alert( 'Перебор' );
                }

                this.doing_type_arr[row + '_' + num] =
                        {
                            'row': row,
                            'num': num,
                            'type': newClass
                        };
                this.clicks++;

            },

            cancel: function () {
                this.update();
                this.$emit('update')
            },

            saveAll: function () {
                // console.log(this.url.updateTypePlace  + this.rows + '/' + this.places_in_row + '/' + this.selected_hall);
                // console.log(this.doing_type_arr);

                axios.post(this.url.updateTypePlace  + this.rows + '/' + this.places_in_row + '/' + this.selected_hall, this.doing_type_arr)
                    .then(response => {
                        console.dir(response);
                        this.update();
                        this.$emit('update')
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
            },

            //запуск родительской ф-ции
            onChange: function () {
                this.$emit('update', this.arr)
            },

        }
    }
</script>


<style scoped>
    .conf-step__chair_doing_class {
        background-color: red;
    }
</style>
