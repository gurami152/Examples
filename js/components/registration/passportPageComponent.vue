<template>
    <div id="passportData"
         aria-labelledby="passportData-tab"
         class="main-register-block">
        <div class="passport-block">
            <div class="user-gender">
                <div class="gender">
                    <label for="gender">Стать</label>
                    <select id="gender" v-model="genderId" class="custom-select" name="genderValid">>
                        <option disabled hidden value="undefined">Оберіть...</option>
                        <option v-for="gender in genders"
                                v-bind:value="gender.id">{{ gender.name }}
                        </option>
                    </select>
                </div>
                <div class="user-date-birth">
                    <div class="form-group">
                        <label for="date-birth">Дата народження</label>
                        <input id="date-birth" v-model="birthDate" class="form-control item"
                               name="dateBirthValid" type="date">
                    </div>
                    <div v-if="this.$v.birthDate.$dirty">
                        <div v-if="!this.$v.birthDate.isValid" class="error">Дата з майбутнього</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="document-place-old">Місце народження (дослівно, як записано у
                    паспорті)</label>
                <input id="document-place-old" v-model="birthPlace" class="form-control"
                       name="documentPlaceValid"
                       placeholder="Місце народження (дослівно, як записано у паспорті)" type="text">
            </div>
            <div v-if="this.$v.birthPlace.$dirty">
                <div v-if="!this.$v.birthPlace.required" class="error">Поле обов`язкове</div>
            </div>
            <div class="passport-version">
                <label for="passport-ver">Тип паспорту</label>
                <select id="passport-ver" v-model="passportTypeId" class="custom-select"
                        name="passportVerValid">
                    <option disabled hidden value="undefined">Оберіть...</option>
                    <option v-for="type in passporttypes" v-bind:value="type.id">
                        {{
                            type.name
                        }}
                    </option>
                </select>
                <div v-if="this.$v.passportTypeId.$dirty">
                    <div v-if="!this.$v.passportTypeId.required" class="error">Поле обов`язкове</div>
                </div>
            </div>
            <div v-if="passportTypeId === 1" id="passport1"
                 class="old-version-passport passport-version-div">
                <div class="passport-data">
                    <div class="passport-field">
                        <div class="form-group doc-series-passport">
                            <label for="doc-series">Серія</label>
                            <input id="doc-series" v-model="passportSeries" class="form-control"
                                   name="docSeriesValid" placeholder="СЮ" type="text">
                            <div v-if="this.$v.passportSeries.$dirty">
                                <div v-if="!this.$v.passportSeries.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportSeries.minLength" class="error">Серия
                                    паспорту складається з 2 літер
                                </div>
                                <div v-if="!this.$v.passportSeries.maxLength" class="error">Введено
                                    забагато символів
                                </div>
                                <div v-if="!this.$v.passportSeries.alpha" class="error">Тут мають бути
                                    лише українські літери
                                </div>
                            </div>
                        </div>
                        <div class="form-group doc-number-passport">
                            <label for="doc-number-old">Номер</label>
                            <input id="doc-number-old" v-model="passportNumber" class="form-control"
                                   name="docNumberValid" placeholder="000000" type="text">
                            <div v-if="this.$v.passportNumber.$dirty">
                                <div v-if="!this.$v.passportNumber.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportNumber.minLength" class="error">Номер
                                    паспорту складається з 6 цифр
                                </div>
                                <div v-if="!this.$v.passportNumber.maxLength" class="error">Введено
                                    забагато символів
                                </div>
                                <div v-if="!this.$v.passportNumber.numeric" class="error">Тут мають бути
                                    лише цифри
                                </div>
                            </div>
                        </div>

                        <div class="form-group doc-issued-passport">
                            <label for="doc-issued-old">Ким виданий</label>
                            <input id="doc-issued-old" v-model="passportIssuedBy" class="form-control"
                                   name="docIssuedValidOldPass" placeholder="Ким виданий" type="text">
                            <div v-if="this.$v.passportIssuedBy.$dirty">
                                <div v-if="!this.$v.passportIssuedBy.required" class="error">Поле
                                    обов`язкове
                                </div>
                            </div>
                        </div>
                        <div class="form-group doc-date-issued-passport">
                            <label for="doc-date-issued-old">Дата видачі</label>
                            <input id="doc-date-issued-old" v-model="passportDateIssued"
                                   class="form-control item"
                                   name="docDateIssued" type="date">
                            <div v-if="this.$v.passportDateIssued.$dirty">
                                <div v-if="!this.$v.passportDateIssued.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportDateIssued.isValid" class="error">Дата з
                                    майбутнього
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="passports-photo">
                            <div class="passport-images">
                                <img id="photos-11" :src="oldPassportImg1.file"
                                     alt="user-photos"
                                     class="img-thumbnail passport-photos">
                                <input id="selectedPassport-1" class="display-img" name="oldPassPhoto1"
                                       type="file" accept="image/jpeg,image/png"
                                       v-on:change="compressPhoto(oldPassportPhoto1, oldPassportImg1)"/>
                                <label
                                    for="selectedPassport-1">Сторінка 1</label>
                                <div class="btn btn-outline-primary"
                                     v-on:click="downloadPhoto('selectedPassport-1')">
                                    Прикріпити фото
                                </div>
                                <div v-if="this.$v.oldPassportPhoto1.$dirty">
                                    <div v-if="!this.$v.oldPassportPhoto1.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                            <div class="passport-images">
                                <img id="photos-2" :src="oldPassportImg2.file"
                                     alt="user-photos"
                                     class="img-thumbnail passport-photos">
                                <input id="selectedPassport-2" class="display-img" name="oldPassPhoto2"
                                       type="file" accept="image/jpeg,image/png"
                                       v-on:change="compressPhoto(oldPassportPhoto2,oldPassportImg2)"/>
                                <label
                                    for="selectedPassport-2">Сторінка 2</label>
                                <div class="btn btn-outline-primary"
                                     v-on:click="downloadPhoto('selectedPassport-2')">
                                    Прикріпити фото
                                </div>
                                <div v-if="this.$v.oldPassportPhoto2.$dirty">
                                    <div v-if="!this.$v.oldPassportPhoto2.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                            <div class="passport-images">
                                <img id="photos-3" :src="oldPassportImg3.file"
                                     alt="user-photos"
                                     class="img-thumbnail passport-photos">
                                <input id="selectedPassport-3" class="display-img" name="oldPassPhoto3"
                                       type="file" accept="image/jpeg,image/png"
                                       v-on:change="compressPhoto(oldPassportPhoto3,oldPassportImg3)"/>
                                <label
                                    for="selectedPassport-3">Сторінка 11</label>
                                <div class="btn btn-outline-primary"
                                     v-on:click="downloadPhoto('selectedPassport-3')">
                                    Прикріпити фото
                                </div>
                                <div v-if="this.$v.oldPassportPhoto3.$dirty">
                                    <div v-if="!this.$v.oldPassportPhoto3.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="passportTypeId === 2" id="passport2"
                 class="new-version-passport passport-version-div">
                <div class="passport-data">
                    <div class="passport-field">
                        <div class="form-group doc-number-passport">
                            <label for="doc-number-new">Номер</label>
                            <input id="doc-number-new" v-model="passportNumberNew" class="form-control"
                                   name="docNumberValid" placeholder="000000000" type="text">
                            <div v-if="this.$v.passportNumberNew.$dirty">
                                <div v-if="!this.$v.passportNumberNew.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportNumberNew.minLength" class="error">Номер
                                    паспорту складається з 9 цифр
                                </div>
                                <div v-if="!this.$v.passportNumberNew.maxLength" class="error">Введено
                                    забагато символів
                                </div>
                                <div v-if="!this.$v.passportNumberNew.numeric" class="error">Тут мають
                                    бути лише цифри
                                </div>
                            </div>
                        </div>
                        <div class="form-group doc-number-passport">
                            <label for="doc-number-unzdr">Номер УНЗДР</label>
                            <input id="doc-number-unzdr" v-model="passportUnzdr" class="form-control"
                                   name="docNumberUnzdr" placeholder="00000000-00000" type="text">
                            <div v-if="this.$v.passportUnzdr.$dirty">
                                <div v-if="!this.$v.passportUnzdr.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportUnzdr.unzdrCheck" class="error">Введіть
                                    значення в форматі: 8 цифр - 5 цифр
                                </div>
                            </div>
                        </div>
                        <div class="form-group doc-issued-passport">
                            <label for="doc-issued-new">Ким виданий</label>
                            <input id="doc-issued-new" v-model="passportIssuedByNew"
                                   class="form-control"
                                   name="docIssuedValidNewPass"
                                   placeholder="0000" type="text">
                            <div v-if="this.$v.passportIssuedByNew.$dirty">
                                <div v-if="!this.$v.passportIssuedByNew.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportIssuedByNew.minLength" class="error">Номер
                                    паспорту складається з 4 цифр
                                </div>
                                <div v-if="!this.$v.passportIssuedByNew.maxLength" class="error">Введено
                                    забагато символів
                                </div>
                                <div v-if="!this.$v.passportIssuedByNew.numeric" class="error">Тут мають
                                    бути лише цифри
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="passport-periods">
                        <div class="form-group doc-date-issued-passport">
                            <label for="doc-date-issued-new">Дата видачі</label>
                            <input id="doc-date-issued-new" v-model="passportDateIssued"
                                   class="form-control item"
                                   name="docDateIssued" type="date">
                            <div v-if="this.$v.passportDateIssued.$dirty">
                                <div v-if="!this.$v.passportDateIssued.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportDateIssued.isValid" class="error">Дата з
                                    майбутнього
                                </div>
                            </div>
                        </div>
                        <div class="form-group doc-date-period-passport">
                            <label for="doc-date-period-new">Строк дії док-та</label>
                            <input id="doc-date-period-new" v-model="passportDatePeriod"
                                   class="form-control item"
                                   name="docDatePeriodValid" type="date">
                            <div v-if="this.$v.passportDatePeriod.$dirty">
                                <div v-if="!this.$v.passportDatePeriod.required" class="error">Поле
                                    обов`язкове
                                </div>
                                <div v-if="!this.$v.passportDatePeriod.isValid" class="error">Термін дії
                                    паспорту вийшов. Зробіть новий та спробуйте зареєструватись з ним
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="passport-new-photo">
                            <div class="passport-images">
                                <img id="new-photos-1" :src="newPassportImg1.file"
                                     alt="user-photos"
                                     class="img-thumbnail new-passport-photos">
                                <input id="selected-new-passport-1" class="display-img"
                                       name="newPassportImg1"
                                       type="file" accept="image/jpeg,image/png"
                                       v-on:change="compressPhoto(newPassportPhoto1,newPassportImg1)"/>
                                <label class="new-pass-text" for="selected-new-passport-1">
                                    Сторінка 1 (або всі одним файлом)
                                </label>
                                <div class="btn btn-outline-primary"
                                     v-on:click="downloadPhoto('selected-new-passport-1')">
                                    Прикріпити фото
                                </div>
                                <div v-if="this.$v.newPassportPhoto1.$dirty">
                                    <div v-if="!this.$v.newPassportPhoto1.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                            <div class="passport-images">
                                <img id="new-photos-2" :src="newPassportImg2.file"
                                     alt="user-photos"
                                     class="img-thumbnail new-passport-photos">
                                <input id="selected-new-passport-2" class="display-img"
                                       name="newPassportImg2"
                                       type="file" accept="image/jpeg,image/png"
                                       v-on:change="compressPhoto(newPassportPhoto2,newPassportImg2)"/>
                                <label class="new-pass-text" for="selected-new-passport-2">
                                    Сторінка 2
                                </label>
                                <div class="btn btn-outline-primary"
                                     v-on:click="downloadPhoto('selected-new-passport-2')">
                                    Прикріпити фото
                                </div>
                                <div v-if="this.$v.newPassportPhoto2.$dirty">
                                    <div v-if="!this.$v.newPassportPhoto2.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                            <div class="passport-images">
                                <img id="new-photos-3" :src="newPassportImg3.file"
                                     alt="user-photos"
                                     class="img-thumbnail new-passport-photos">
                                <input id="selected-new-passport-3" class="display-img"
                                       name="newPassportImg3"
                                       type="file" accept="image/jpeg,image/png"
                                       v-on:change="compressPhoto(newPassportPhoto3,newPassportImg3)"/>
                                <label class="new-pass-text" for="selected-new-passport-3">
                                    Витяг
                                </label>
                                <div class="btn btn-outline-primary"
                                     v-on:click="downloadPhoto('selected-new-passport-3')">
                                    Прикріпити фото
                                </div>
                                <div v-if="this.$v.newPassportPhoto3.$dirty">
                                    <div v-if="!this.$v.newPassportPhoto3.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navigate-btn">
            <a class="btn btn-primary btnPrevious" v-on:click="pagePrevious">
                <span class="lg_view">Назад</span>
                <span class="sm_view"><i class="fas fa-arrow-left"></i></span>
            </a>
            <a class="btn btn-primary btnNext"
               v-on:click="pageNext">
                <span class="lg_view">Далі</span>
                <span class="sm_view"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</template>

<script>
import {alpha, maxLength, minLength, numeric, required} from "vuelidate/lib/validators";
import {upload} from "../../imageCompressor";

export default {
    name: "passportPageComponent",
    props: [
        'roomsPage',
    ],
    mounted() {
        this.loadPassportTypes();
        this.loadGenders();
    },
    validations: {
        genderId: {
            required,
        },
        birthDate: {
            required,
            isValid: function () {
                let date = new Date();
                return this.birthDate < date.toISOString();
            }
        },
        birthPlace: {
            required,
        },
        passportTypeId: {
            required,
        },
        passportSeries: {
            required,
            maxLength: maxLength(2),
            minLength: minLength(2),
            alpha: function () {
                return (/[А-Яа-я,Ї,Є]{2}/.test(this.passportSeries));
            }
        },
        passportNumber: {
            required,
            maxLength: maxLength(6),
            minLength: minLength(6),
            numeric,
        },
        passportIssuedBy: {
            required,
        },
        passportDateIssued: {
            required,
            isValid: function () {
                let date = new Date();
                return this.passportDateIssued <= date.toISOString();
            }
        },
        oldPassportPhoto1: {
            required: function () {
                return this.oldPassportPhoto1.file.length !== 0;
            },
        },
        oldPassportPhoto2: {
            required: function () {
                return this.oldPassportPhoto1.file.length !== 0;
            },
        },
        oldPassportPhoto3: {
            required: function () {
                return this.oldPassportPhoto1.file.length !== 0;
            },
        },
        passportNumberNew: {
            required,
            maxLength: maxLength(9),
            minLength: minLength(9),
            numeric,
        },
        passportUnzdr: {
            required,
            unzdrCheck: function () {
                return (/[0-9]{8}-[0-9]{5}/.test(this.passportUnzdr));
            }
        },
        passportIssuedByNew: {
            required,
            maxLength: maxLength(4),
            minLength: minLength(4),
            numeric,
        },
        passportDatePeriod: {
            required,
            isValid: function () {
                let date = new Date();
                return this.passportDatePeriod >= date.toISOString();
            }
        },
        newPassportPhoto1: {
            required: function () {
                return this.newPassportPhoto1.file.length !== 0;
            },
        },
        newPassportPhoto2: {
            required: function () {
                return this.newPassportPhoto2.file.length !== 0;
            },
        },
        newPassportPhoto3: {
            required: function () {
                return this.newPassportPhoto3.file.length !== 0;
            },
        },
        validationGroupGeneral: ['genderId', 'birthDate', 'birthPlace', 'passportTypeId', 'passportDateIssued'],
        validationGroupOldPassport: ['passportSeries', 'passportNumber', 'passportIssuedBy', 'oldPassportPhoto1', 'oldPassportPhoto2', 'oldPassportPhoto3'],
        validationGroupNewPassport: ['passportNumberNew', 'passportUnzdr', 'passportIssuedByNew', 'passportDatePeriod', 'newPassportPhoto1', 'newPassportPhoto2'],
    },
    data: function () {
        return {
            oldPassportImg1: {file: "/images/pass.png"},
            oldPassportImg2: {file: "/images/pass.png"},
            oldPassportImg3: {file: "/images/pass.png"},
            newPassportImg1: {file: "/images/pass.png"},
            newPassportImg2: {file: "/images/pass.png"},
            newPassportImg3: {file: "/images/pass.png"},
            oldPassportPhoto1: {file: ""},
            oldPassportPhoto2: {file: ""},
            oldPassportPhoto3: {file: ""},
            newPassportPhoto1: {file: ""},
            newPassportPhoto2: {file: ""},
            newPassportPhoto3: {file: ""},
            passportTypeId: this.passportTypeId,
            genderId: this.genderId,
            birthDate: this.birthDate,
            birthPlace: this.birthPlace,
            passportSeries: this.passportSeries,
            passportNumber: this.passportNumber,
            passportNumberNew: this.passportNumberNew,
            passportIssuedBy: this.passportIssuedBy,
            passportIssuedByNew: this.passportIssuedByNew,
            passportDateIssued: this.passportDateIssued,
            passportDatePeriod: this.passportDatePeriod,
            passportUnzdr: this.passportUnzdr,
            passporttypes: this.passporttypes,
            genders: this.genders,
        }
    },
    methods: {
        compressPhoto(Photo, Img) {
            upload(Photo, Img);
        },
        downloadPhoto(id) {
            document.getElementById(id).click();
        },
        loadPassportTypes() {
            let self = this;
            axios.get(
                '/api/typeOfPassport'
            )
                .then(function (response) {
                    self.passporttypes = response.data
                })
        },
        loadGenders() {
            let self = this;
            axios.get(
                '/api/typeOfGenderOfPerson'
            )
                .then(function (response) {
                    self.genders = response.data
                })
        },
        pagePrevious() {
            this.$emit('update-parent', 'personalPage');
        },
        pageNext() {
            let valid = false;
            if (this.passportTypeId === 1) {
                this.$v.validationGroupOldPassport.$touch();
                this.$v.validationGroupGeneral.$touch();
                if (!this.$v.validationGroupOldPassport.$invalid && !this.$v.validationGroupGeneral.$invalid) {
                    this.$store.commit('setValue', {'item': 'typeOfPassport', 'value': this.passportTypeId});
                    this.$store.commit('setValue', {'item': 'birthDate', 'value': this.birthDate});
                    this.$store.commit('setValue', {'item': 'genderAjax', 'value': this.genderId});
                    this.$store.commit('setValue', {'item': 'birthPlace', 'value': this.birthPlace});
                    this.$store.commit('setValue', {'item': 'passportSeries', 'value': this.passportSeries});
                    this.$store.commit('setValue', {'item': 'passportNumber', 'value': this.passportNumber});
                    this.$store.commit('setValue', {'item': 'passportIssuedBy', 'value': this.passportIssuedBy});
                    this.$store.commit('setValue', {'item': 'passportDateIssued', 'value': this.passportDateIssued});
                    this.$store.commit('setValue', {'item': 'oldPassportPhoto1', 'value': this.oldPassportPhoto1.file});
                    this.$store.commit('setValue', {'item': 'oldPassportPhoto2', 'value': this.oldPassportPhoto2.file});
                    this.$store.commit('setValue', {'item': 'oldPassportPhoto3', 'value': this.oldPassportPhoto3.file});
                    valid = true;
                }
            } else if (this.passportTypeId === 2) {
                this.$v.validationGroupNewPassport.$touch();
                this.$v.validationGroupGeneral.$touch();
                if (!this.$v.validationGroupNewPassport.$invalid && !this.$v.validationGroupGeneral.$invalid) {
                    this.$store.commit('setValue', {'item': 'typeOfPassport', 'value': this.passportTypeId});
                    this.$store.commit('setValue', {'item': 'birthDate', 'value': this.birthDate});
                    this.$store.commit('setValue', {'item': 'genderAjax', 'value': this.genderId});
                    this.$store.commit('setValue', {'item': 'birthPlace', 'value': this.birthPlace});
                    this.$store.commit('setValue', {'item': 'passportNumber', 'value': this.passportNumberNew});
                    this.$store.commit('setValue', {'item': 'passportDateIssued', 'value': this.passportDateIssued});
                    this.$store.commit('setValue', {'item': 'passportIssuedBy', 'value': this.passportIssuedByNew});
                    this.$store.commit('setValue', {'item': 'passportUnzdr', 'value': this.passportUnzdr});
                    this.$store.commit('setValue', {'item': 'passportDatePeriod', 'value': this.passportDatePeriod});
                    this.$store.commit('setValue', {'item': 'newPassportPhoto1', 'value': this.newPassportPhoto1.file});
                    this.$store.commit('setValue', {'item': 'newPassportPhoto2', 'value': this.newPassportPhoto2.file});
                    this.$store.commit('setValue', {'item': 'newPassportPhoto3', 'value': this.newPassportPhoto3.file});
                    valid = true;
                }
            }
            if (valid) {
                if (!this.roomsPage) {
                    this.$emit('update-parent', 'addressPage');
                } else {
                    this.$emit('update-parent', 'roomPage');
                }
            }
        },
    }
}
</script>

<style scoped>

</style>
