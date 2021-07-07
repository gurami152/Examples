<template>
    <div id="address"
         aria-labelledby="address-tab"
         class="main-register-block">
        <div class="address-data">
            <span class="messageAboutAddress"><b>Вказуйте адресу постійного проживання,  а не адресу гуртожитку!</b></span>
            <div class="region-district">
                <div class="region-div">
                    <label for="region">Область</label>
                    <input id="region" v-model="region" class="form-control" name="regionValid"
                           type="text"/>
                    <div v-if="this.$v.region.$dirty">
                        <div v-if="!this.$v.region.required" class="error">Поле обов`язкове</div>
                    </div>
                </div>
                <div class="district-div">
                    <label for="district">Район</label>
                    <input id="district" v-model="district" class="form-control"
                           type="text"/>
                </div>
            </div>
            <div class="city-info">
                <div class="types-of-cities">
                    <div class="custom-control no-padding custom-radio w-100 city-type">
                        <label class="city-mobile w-100">Тип населеного пункту
                            <select class="custom-select" v-model="cities">
                                <option v-for="typeOfCity in typesOfCities" v-bind:value="typeOfCity.id">
                                    {{ typeOfCity.name }}
                                </option>
                            </select>
                        </label>
                        <div class="radio-buttons" v-for="typeOfCity in typesOfCities">
                            <input v-bind:id="'city'+typeOfCity.id" v-model="cities"
                                   type="radio" v-bind:value="typeOfCity.id">
                            <label>{{ typeOfCity.name }}</label>
                        </div>
                    </div>
                    <div v-if="this.$v.cities.$dirty">
                        <div v-if="!this.$v.cities.required" class="error">Тип міста обрати
                            обов'язково
                        </div>
                    </div>
                </div>
                <label>Назва населеного пункту</label>
                <input id="city-name" v-model="cityName" class="form-control" name="cityNameValid"
                       type="text"/>
                <div v-if="this.$v.cityName.$dirty">
                    <div v-if="!this.$v.cityName.required" class="error">Тип міста обрати обов'язково
                    </div>
                </div>
            </div>
            <div class="street-info">
                <div class="types-of-streets">
                    <div class="custom-control custom-radio w-100 no-padding street-type">
                        <label class="streets-mobile w-100">Тип населеного пункту
                            <select class="custom-select" v-model="streets">
                                <option v-for="typeOfStreet in typesOfStreets" v-bind:value="typeOfStreet.id">
                                    {{ typeOfStreet.name }}
                                </option>
                            </select>
                        </label>
                        <div class="streets-radio-buttons" v-for="typeOfStreet in typesOfStreets">
                            <input v-bind:id="'city'+typeOfStreet.id" v-model="streets"
                                   type="radio" v-bind:value="typeOfStreet.id">
                            <label>{{ typeOfStreet.name }}</label>
                        </div>
                    </div>
                    <div v-if="this.$v.streets.$dirty">
                        <div v-if="!this.$v.streets.required" class="error">Тип вулиці обрати
                            обов'язково
                        </div>
                    </div>
                </div>
                <label>Назва місця проживання</label>
                <input id="street-name" v-model="streetName" class="form-control"
                       name="streetNameValid" type="text"/>
                <div v-if="this.$v.streetName.$dirty">
                    <div v-if="!this.$v.streetName.required" class="error">Поле обов'язкове</div>
                </div>
            </div>
            <div class="house-apartment">
                <div class="house-div">
                    <label for="house">Будинок</label>
                    <input id="house" v-model="house" class="form-control" name="houseValid"
                           type="text"/>
                    <div v-if="this.$v.house.$dirty">
                        <div v-if="!this.$v.house.required" class="error">Поле обов'язкове</div>
                    </div>
                </div>
                <div class="apartment-div">
                    <label for="apartment">Квартира</label>
                    <input id="apartment" v-model="apartment" class="form-control" type="text"/>
                </div>
            </div>
        </div>
        <div class="navigate-btn">
            <a class="btn btn-primary btnPrevious" v-on:click="stepPrev">
                <span class="lg_view">Назад</span>
                <span class="sm_view"><i class="fas fa-arrow-left"></i></span>
            </a>
            <a class="btn btn-primary btnNext"
               v-on:click="stepNext">
                <span class="lg_view">Далі</span>
                <span class="sm_view"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</template>

<script>
import {required} from "vuelidate/lib/validators";

export default {
    name: "addressPage",
    props:[
        'room_page',
        'family_page'
    ],
    mounted() {
        this.loadTypesOfStreets();
        this.loadTypesOfCities();
    },
    validations: {
        region: {
            required,
        },
        cities: {
            required,
        },
        cityName: {
            required,
        },
        streets: {
            required,
        },
        streetName: {
            required,
        },
        house: {
            required,
        },
        validationGroupAddress: ['region', 'cities', 'cityName', 'streets', 'streetName', 'house'],
    },
    data: function () {
        return {
            cities: this.cities,
            streets: this.streets,
            region: this.region,
            district: this.region,
            cityName: this.region,
            streetName: this.region,
            house: this.region,
            apartment: this.region,
            typesOfStreets: this.typesOfStreets,
            typesOfCities: this.typesOfCities,
        }
    },
    methods: {
        loadTypesOfStreets() {
            let self = this;
            axios.get(
                '/api/typeOfStreet',{
                    params: {
                        lang: 1
                    }
                }
            )
                .then(function (response) {
                    self.typesOfStreets = response.data
                })
        },
        loadTypesOfCities() {
            let self = this;
            axios.get(
                '/api/typeOfCity',{
                    params: {
                        lang: 1
                    }
                }
            )
                .then(function (response) {
                    self.typesOfCities = response.data
                })
        },
        stepNext(){
            this.$v.validationGroupAddress.$touch();
            if (!this.$v.validationGroupAddress.$invalid) {
                this.$store.commit('setValue',{'item':'region', 'value':this.region});
                this.$store.commit('setValue',{'item':'district', 'value':this.district});
                this.$store.commit('setValue',{'item':'cities', 'value':this.cities});
                this.$store.commit('setValue',{'item':'cityName', 'value':this.cityName});
                this.$store.commit('setValue',{'item':'streets', 'value':this.streets});
                this.$store.commit('setValue',{'item':'streetName', 'value':this.streetName});
                this.$store.commit('setValue',{'item':'house', 'value':this.house});
                this.$store.commit('setValue',{'item':'apartment', 'value':this.apartment});
                if(this.family_page){
                    this.$emit('update-parent', 'familyPage');
                }
                else {
                    this.$emit('update-parent', 'certificatePage');
                }
            }
        },
        stepPrev(){
            if(this.room_page){
                this.$emit('update-parent','roomPage');
            }
            else{
                this.$emit('update-parent','passportPage');
            }
        }
    }
}
</script>

<style lang="scss">
    .messageAboutAddress{
        width: 100%;
        display: flex;
        justify-content: center;
        text-align: center;
    }
</style>
