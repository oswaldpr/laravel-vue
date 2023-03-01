<template>
    <div class="container">
        <div class="row justify-content-center">
            <h1>Home</h1>
            <p>
                coucou
            </p>
        </div>
    </div>
</template>

<script>
    import { axiosOperation } from "../appAxiosOperation";

    export default {
        name: "Home",
        components: {
        },
        props: {
            model: {
                type: Object,
                default: function () {
                    return {
                        startDate: '',
                        endDate: '',
                        city: '',
                        state: '',
                        startTemperature: '',
                        endTemperature: '',
                    }
                },
            },
        },
        computed: {
            dateMin: function () {
                return new Date();
            },
            dateMax: function () {
                return new Date(new Date().setFullYear(new Date().getFullYear() + 1))
            },
            disabledDates: function () {
                // Doc: https://www.npmjs.com/package/vuejs-datepicker-fixed-disabled-dates
                const dateRange = {};
                dateRange.to = this.dateMin; // TO: Disable all dates up to min date
                dateRange.from = this.dateMax; // FROM: Disable all dates after max date
                return dateRange;
            },
            //Model
            startDate: {
                get: function () {
                    return this.model.startDate;
                },
                set: function (value) {
                    this.model.startDate = value;
                },
            },
            endDate: {
                get: function () {
                    return this.model.endDate;
                },
                set: function (value) {
                    this.model.endDate = value;
                },
            },
            city: {
                get: function () {
                    return this.model.city;
                },
                set: function (value) {
                    this.model.city = value;
                },
            },
            state: {
                get: function () {
                    return this.model.state;
                },
                set: function (value) {
                    this.model.state = value;
                },
            },
            startTemperature: {
                get: function () {
                    return this.model.startTemperature;
                },
                set: function (value) {
                    this.model.startTemperature = value;
                },
            },
            endTemperature: {
                get: function () {
                    return this.model.endTemperature;
                },
                set: function (value) {
                    this.model.endTemperature = value;
                },
            },
        },
        methods:{
            getModel() {
                const model = this.model;
                const defaultStartDate = model.startDate ? model.startDate : this.dateMin;
                const defaultEndDate = model.endDate ? model.endDate : this.dateMax;
                return  {
                    startDate : defaultStartDate,
                    endDate : defaultEndDate,
                    city : model.city,
                    state : model.state,
                    startTemperature : model.startTemperature,
                    endTemperature : model.endTemperature,
                }
            },
            searchWeather: async function(){
                const formData = this.getModel()
                const appOutput = await axiosOperation('weather', formData);
                // this.showResultList = true;
                // this.resultList = appOutput;
            },
            clearInputs: async function(){
                this.model.startDate = '';
                this.model.endDate = '';
                this.model.city = '';
                this.model.state = '';
                this.model.startTemperature = '';
                this.model.endTemperature = '';
            },
        },
        data: function (){

            return {
            }
        }
    }
</script>
