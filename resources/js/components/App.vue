<template lang="pug">
    form
        label Megye:
        select(v-model="selected" @change="getCitiesOfCounty")
            option(disabled value="") Válassz megyét!
            option(v-for="county in counties" :value="county.id") {{county.name}}
        label Új város:
        input(v-model="newCity")
        button(@click="addCity") Felvesz
    div(:class="$style.data" v-if="selected")
        label Megye: {{ selectedCountyName }}
        label Városok:
        ul
            li(v-for="city in cities") {{ city.name }}


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
            getCitiesOfCounty() {
                axios.get('county/' + this.selected + '/cities').then(({ data }) => {
                    this.cities = data;
                })
            },
            addCity() {
                axios.post('city').then(({ data }) => {
                    this.cities.push(data);
                })
            }
        }
    }
</script>

<style module>
    form, .data {
        @apply max-w-sm mx-auto;
    }
    label {
        @apply block my-2 text-sm font-medium text-gray-900 dark:text-white;
    }
    select, input {
        @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500;
    }
</style>
