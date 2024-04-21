<template lang="pug">
    div(:class="$style.data")
        label Megye:
        select(v-model="selected" @change="getCitiesOfCounty")
            option(disabled value="") Válassz megyét!
            option(v-for="county in counties" :value="county.id") {{county.name}}
        div(v-if="selected")
            label Új város:
            div(:class="$style.addBox")
                input(v-model="newCity")
                button( @click="addCity")
                    i.icon.plus
    div(:class="$style.data" v-if="selected")
        label Megye: {{ selectedCountyName }}
        div(v-if="cities.length")
            label Városok:
            ul
                li(v-for="city in cities")
                    div(:class="$style.inputBox" v-if="city.inputVisible")
                        input(v-model="city.name")
                        div(:class="$style.inputButtons")
                            button(@click="deleteCity(city.id)")
                                i.icon.trash
                            button(@click="modifyCity(city)")
                                i.icon.pencil
                            button(class="$stlye.hideButton" @click="hideInput(city)")
                                i.icon.x
                    div(:class="$style.cityName" @click="showInput(city)" v-else) {{ city.name }}
</template>

<script>
    import axios from "axios";
    export default {
        data() {
            return {
                selected: "",
                counties: [],
                cities: [],
                newCity: ""
            }
        },
        mounted() {
            axios.get('counties').then(({ data }) => {
                this.counties = data;
            })
        },
        computed: {
            selectedCountyName() {
                return this.counties.find(county => county.id === this.selected).name;
            }
        },
        methods: {
            getCity(id) {
                axios.get('cities/' + id).then(({ data }) => {
                    const index = this.cities.findIndex(city => city.id === id);
                    this.cities[index] = data;
                })
            },
            getCitiesOfCounty() {
                axios.get('counties/' + this.selected + '/cities').then(({ data }) => {
                    this.cities = data;
                })
            },
            addCity() {
                axios.post('cities', { name: this.newCity, countyId: this.selected }).then(({ data }) => {
                    if(!data.errorMessage) {
                        this.cities = data;
                        return;
                    }

                    window.alert(data.errorMessage);
                })
            },
            modifyCity(city) {
                axios.post('cities/' + city.id, city).then(({ data }) => {
                    if(!data.errorMessage) {
                        this.hideInput(city);
                        return
                    }

                    window.alert(data.errorMessage);
                })
            },
            deleteCity(id) {
                axios.delete('cities/' + id).then(({ data }) => {
                    if(data) {
                        const index = this.cities.findIndex(city => city.id === id);
                        this.cities.splice(index, 1);
                        return;
                    }

                    window.alert('Sikertelen törlés');
                })
            },
            showInput(city){
                city.inputVisible = true;
            },
            hideInput(city){
                this.getCity(city.id);
                city.inputVisible = false;
            }

        }
    }
</script>

<style module>
    .data {
        @apply max-w-sm mx-auto w-full;
        li {
            @apply mt-2;
        }
        .cityName {
         @apply w-full p-2 text-center rounded-lg hover:bg-black hover:text-white;
        }
    }

    label {
        @apply block my-2 text-sm font-medium text-gray-900;
    }

    select, input, button{
        @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5;
    }

    .addBox {
        @apply flex justify-center;

        input {
            @apply min-w-max;
        }

        button{
            @apply ml-2 border-none rounded-lg hover:bg-gray-200 w-10;
        }
    }

    .inputBox {
        @apply flex justify-center;

        input {
            @apply min-w-max;
        }
        .inputButtons {
            width: 100px;

            @apply ml-2 flex;

            button {
                @apply border-none rounded-lg hover:bg-gray-200 w-12;
            }
        }
    }
</style>
