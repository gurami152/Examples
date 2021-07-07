<template>
    <div id="certificate" class="main-register-block">
        <div class="reference-data">
            <h4 class="no-margin">Пільги</h4>
            <small id="privilege"
                   class="form-text text-muted">Якщо пільг нема, залишайте поле пустим</small>
            <div class="privilege-div border-bottom">
                <div class="privilege-select-div">
                    <label for="type-of-privilege">Тип пільги</label>
                    <select id="type-of-privilege" v-model="typeOfPrivilegeId" class="custom-select">
                        <option disabled hidden v-bind:value="undefined">Оберіть...</option>
                        <option v-bind:value="undefined"></option>
                        <option v-for="privileges in typesofprivileges" v-bind:value="privileges.id">
                            {{ privileges.name }}
                        </option>
                    </select>
                    <label for="other-privilege">Інші пільги</label>
                    <textarea id="other-privilege" v-model="otherPrivilege" class="form-control"
                              rows="6"></textarea>
                </div>
                <div class="privilege-images">
                    <img id="privilege-image" :src="privilegeImg.file"
                         alt="user-photos"
                         class="img-thumbnail passport-photos">
                    <input id="privilege-members-image" class="display-img" name="newPassportImg1"
                           type="file" accept="image/jpeg,image/png"
                           v-on:change="compressPhoto(privilegePhoto,privilegeImg)"/>
                    <label
                        for="privilege-members-image">Фотопідтвердження пільги (сторінка 1)</label>
                    <div class="btn btn-outline-primary"
                         v-on:click="downloadPhoto('privilege-members-image')">
                        Прикріпити фото
                    </div>
                </div>
            </div>
            <div class="references-div">
                <h4>Медичні довідки</h4>
                <div class="medical-references">
                    <div class="fluorografy">
                        <div class="fluorografy-images">
                            <img id="fluorografy-image" :src="fluorographyImg.file"
                                 alt="user-photos"
                                 class="img-thumbnail passport-photos">
                            <input id="fluorografy-members-image" class="display-img"
                                   name="newPassportImg1"
                                   type="file" accept="image/jpeg,image/png"
                                   v-on:change="compressPhoto(fluorographyPhoto,fluorographyImg)"/>
                            <label
                                for="fluorografy-members-image">Довідки про флюорографічне
                                обстеження (Сторінка 1)</label>
                            <div class="btn btn-outline-primary"
                                 v-on:click="downloadPhoto('fluorografy-members-image')">
                                Прикріпити фото
                            </div>
                        </div>
                        <div class="fluorografy-images">
                            <img id="fluorografy2-image" :src="fluorography2Img.file"
                                 alt="user-photos"
                                 class="img-thumbnail passport-photos">
                            <input id="fluorografy2-members-image" class="display-img"
                                   name="newPassportImg1"
                                   type="file" accept="image/jpeg,image/png"
                                   v-on:change="compressPhoto(fluorography2Photo,fluorography2Img)"/>
                            <label
                                for="fluorografy2-members-image">Довідки про флюорографічне
                                обстеження (Сторінка 2, якщо є)</label>
                            <div class="btn btn-outline-primary"
                                 v-on:click="downloadPhoto('fluorografy2-members-image')">
                                Прикріпити фото
                            </div>
                        </div>
                        <div v-if="this.$v.fluorographyPhoto.$dirty">
                            <div v-if="!this.$v.fluorographyPhoto.required" class="error">Поле обов`язкове</div>
                        </div>
                        <div>
                            <label>
                                Дата останього флюорографічного обстеження
                                <input v-model="lastdate" class="form-control item" type="date"/>
                            </label>
                        </div>
                        <div v-if="this.$v.lastdate.$dirty">
                            <div v-if="!this.$v.lastdate.required" class="error">Поле обов`язкове</div>
                            <div v-if="!this.$v.lastdate.isValid" class="error">Флюрографічне обстеження було
                                зроблено
                                дуже давно
                            </div>
                        </div>

                    </div>
                    <div v-if="vaccine_field" class="vaccine">
                        <div class="vaccine-images">
                            <img id="vaccine-image" :src="vaccineImg.file"
                                 alt="user-photos"
                                 class="img-thumbnail passport-photos">
                            <input id="vaccine-members-image" class="display-img" name="newPassportImg1"
                                   type="file" accept="image/jpeg,image/png"
                                   v-on:change="compressPhoto(vaccinePhoto,vaccineImg)"/>
                            <label
                                for="vaccine-members-image">Довідка про щеплення</label>
                            <div class="btn btn-outline-primary"
                                 v-on:click="downloadPhoto('vaccine-members-image')">
                                Прикріпити фото
                            </div>
                            <div v-if="this.$v.vaccinePhoto.$dirty">
                                <div v-if="!this.$v.vaccinePhoto.required" class="error">Поле обов`язкове</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wishes-div">
                <h4>Звернення до адміністрації</h4>
                <div class="wishes-reference">
                    <label>
                        <textarea v-model="appealToTheAdministration"></textarea>
                    </label>
                </div>
            </div>
            <div>
                <input id="checkStatus"
                       v-model="checkStatus"
                       class="checkUserAgreement"
                       name="checkStatus"
                       type="checkbox">
                <label for="checkStatus">Даю згоду на обробку особистих даних.</label>
            </div>
            <div v-if="this.$v.checkStatus.$dirty">
                <div v-if="!this.$v.checkStatus.required" class="error">Це поле має бути заповненим.
                </div>
            </div>
        </div>
        <div class="navigate-btn">
            <a class="btn btn-primary btnPrevious" v-on:click="stepPrev">
                <span class="lg_view">Назад</span>
                <span class="sm_view"><i class="fas fa-arrow-left"></i></span>
            </a>
            <a :class="{btnRegisterActive: clicked, disabled: clicked}"
               class="btn btn-success btnRegister"
               v-on:click="register">
                <span class="lg_view">Зареєструватись</span>
                <span class="sm_view"><i class="fas fa-sign-in-alt"></i></span>
            </a>
        </div>
    </div>
</template>

<script>
import {upload} from "../../imageCompressor";
import {required} from "vuelidate/lib/validators";

export default {
    props: [
        'family_page',
        'vaccine_field'
    ],
    name: "certificatePage",
    mounted() {
        this.loadTypesOfPrivilege();
    },
    validations: {
        fluorographyPhoto: {
            required: function () {
                return this.fluorographyPhoto.file.length !== 0;
            },
        },
        lastdate: {
            required,
            isValid: function () {
                let date = new Date();
                date.setFullYear(date.getFullYear() - 1);
                return this.lastdate >= date.toISOString();
            }
        },
        vaccinePhoto: {
            required: function () {
                return this.vaccinePhoto.file.length !== 0;
            },
        },
        checkStatus: {
            required: function () {
                return this.checkStatus === true;
            }
        },
        validationPrivilegesVaccine: ['fluorographyPhoto', 'lastdate', 'vaccinePhoto', 'checkStatus'],
        validationPrivileges: ['fluorographyPhoto', 'lastdate', 'checkStatus'],
    },
    data: function () {
        return {
            typeOfPrivilegeId: this.typeOfPrivilegeId,
            otherPrivilege: "",
            lastdate: this.lastdate,
            appealToTheAdministration: null,
            privilegeImg: {file: "/images/vacine.png"},
            fluorographyImg: {file: "/images/vacine.png"},
            fluorography2Img: {file: "/images/vacine.png"},
            vaccineImg: {file: "/images/vacine.png"},
            privilegePhoto: {file: ""},
            fluorographyPhoto: {file: ""},
            fluorography2Photo: {file: ""},
            vaccinePhoto: {file: ""},
            typesofprivileges: this.typesofprivileges,
            clicked: false,
            checkStatus: this.checkStatus,
        }
    },
    methods: {
        compressPhoto(Photo, Img) {
            upload(Photo, Img);
        },
        downloadPhoto(id) {
            document.getElementById(id).click();
        },
        loadTypesOfPrivilege() {
            let self = this;
            axios.get(
                '/api/typeOfPrivilege', {})
                .then(function (response) {
                    self.typesofprivileges = response.data
                })
        },
        stepPrev() {
            if (this.family_page) {
                this.$emit('update-parent', 'familyPage');
            } else {
                this.$emit('update-parent', 'addressPage');
            }
        },
        register() {
            if (this.vaccine_field) {
                this.$v.validationPrivilegesVaccine.$touch();
                if (!this.$v.validationPrivilegesVaccine.$invalid) {
                    this.$store.commit('setValue', {'item': 'lastDate', 'value': this.lastdate})
                    this.$store.commit('setValue', {'item': 'fluorographyPhoto', 'value': this.fluorographyPhoto.file})
                    if (this.fluorography2Photo.file !== "") {
                        this.$store.commit('setValue', {
                            'item': 'fluorography2Photo',
                            'value': this.fluorography2Photo.file
                        });
                    }
                    if (this.vaccinePhoto.file !== "") {
                        this.$store.commit('setValue', {'item': 'vaccinePhoto', 'value': this.vaccinePhoto.file})
                    }
                    this.$store.commit('setValue', {'item': 'privilegePhoto', 'value': this.privilegePhoto.file})
                    this.$store.commit('setValue', {
                        'item': 'appealToTheAdministration',
                        'value': this.appealToTheAdministration
                    })
                    this.$store.commit('setValue', {'item': 'otherPrivilege', 'value': this.otherPrivilege})
                    this.$store.commit('setValue', {'item': 'typeOfPrivilegeId', 'value': this.typeOfPrivilegeId})
                    this.$emit("submit");
                    this.clicked = true;
                }
            } else {
                this.$v.validationPrivileges.$touch();
                if (!this.$v.validationPrivileges.$invalid) {
                    this.$store.commit('setValue', {'item': 'lastDate', 'value': this.lastdate})
                    this.$store.commit('setValue', {'item': 'fluorographyPhoto', 'value': this.fluorographyPhoto.file})
                    if (this.fluorography2Photo.file !== "") {
                        this.$store.commit('setValue', {
                            'item': 'fluorography2Photo',
                            'value': this.fluorography2Photo.file
                        });
                    }
                    this.$store.commit('setValue', {'item': 'privilegePhoto', 'value': this.privilegePhoto.file})
                    this.$store.commit('setValue', {
                        'item': 'appealToTheAdministration',
                        'value': this.appealToTheAdministration
                    })
                    this.$store.commit('setValue', {'item': 'otherPrivilege', 'value': this.otherPrivilege})
                    this.$store.commit('setValue', {'item': 'typeOfPrivilegeId', 'value': this.typeOfPrivilegeId})
                    this.$emit("submit");
                    this.clicked = true;
                }
            }

        },
    }
}
</script>
