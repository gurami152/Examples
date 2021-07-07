<template>
    <div id="University" aria-labelledby="University-tab"
         class="tab-pane main-register-block">
        <label for="selectUniversity">Оберіть университет</label>
        <select id="selectUniversity" v-model="universityId"
                :class="this.$v.universityId.$error ? 'custom-select custom-select--error' : 'custom-select'  "
                name="selectUniversityValid">
            <option disabled hidden value="undefined">Оберіть...</option>
            <option v-for="edu in educationalInstitutions" v-bind:value="edu.id">{{ edu.fullName }}
            </option>
        </select>
        <div v-if="this.$v.universityId.$dirty">
            <div v-if="!this.$v.universityId.required" class="error">Поле обов`язкове</div>
        </div>
        <label for="lived">Чи Ви проживали в гуртожитку в 2020 - 2021 навчальному році</label>
        <select id="lived" v-model="isLived"
                :class="this.$v.isLived.$error ? 'custom-select custom-select--error' : 'custom-select'  ">
            <option disabled hidden value="undefined">Оберіть...</option>
            <option value="1">Так</option>
            <option value="0">Ні</option>
        </select>
        <div v-if="this.$v.validationGroup.isLived.$dirty">
            <div v-if="!this.$v.isLived.required" class="error">Поле обов`язкове</div>
        </div>
        <div class="navigate-btn">
            <a class="btn btn-primary btnNext"
               v-on:click="loadRegistrationFields">
                <span class="lg_view">Далі</span>
                <span class="sm_view"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</template>

<script>
import {required} from "vuelidate/lib/validators";

export default {
    props: [
        'user_type',
    ],
    name: "selectUniversityAndStatementComponent",
    mounted() {
        this.loadEducationalInstitutions();
    },
    validations: {
        isLived: {
            required,
        },
        universityId: {
            required
        },
        validationGroup: ['universityId', 'isLived'],
    },
    data: function () {
        return {
            isLived: this.isLived,
            universityId: this.universityId,
            educationalInstitutions: null,
            registrationFields: {}
        }
    },
    methods: {

        loadEducationalInstitutions() {
            let self = this;
            axios({
                url: '/api/educationalInstitution',
                method: 'get',
            })
                .then(function (response) {
                    self.educationalInstitutions = response.data
                })
        },
        loadRegistrationFields() {
            let self = this;
            this.$v.validationGroup.$touch();
            if (!this.$v.validationGroup.$invalid) {
                this.$store.commit('setValue', {'item': 'university_id', 'value': self.universityId});
                axios({
                    url: '/loadRegistrationFields',
                    method: 'get',
                    params: {
                        university_id: this.universityId,
                        isLived: this.isLived,
                        user_type: this.user_type,
                    }
                })
                    .then(function (response) {
                        self.registrationFields = response.data
                        self.$store.commit('setValue', {'item': 'registerFields', 'value': self.registrationFields});
                        if (self.registrationFields.statementPage) {
                            self.$emit('update-parent', 'statementPage');
                        } else {
                            self.$emit('update-parent', 'personalPage');
                        }
                    })
            }
        },

    }
}
</script>

<style scoped>

</style>
