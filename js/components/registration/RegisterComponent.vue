<template>
    <div class="main-register">
        <navigation-component :currentStep="currentStep" :list="list" :registrationFields="$store.state.registerFields"
                              @goto="updateParent"></navigation-component>
        <form id="form" action="" enctype=multipart/form-data method="post">
            <div class="tab-content card">
                <div class="card-body">
                    <statement-page v-show="currentStep === 'statementPage'" v-on:update-parent="updateParent"></statement-page>
                    <select-university v-show="currentStep === 'universityPage'" v-on:update-parent="updateParent"
                                       :user_type="student"
                    ></select-university>
                    <personal-data-page
                        v-show="currentStep === 'personalPage'"
                        v-on:update-parent="updateParent"
                        :specialization_field="$store.state.registerFields.specializationField"
                        :department_fields="$store.state.registerFields.departmentField"
                        :statement_page="$store.state.registerFields.statementPage"
                    >
                    </personal-data-page>
                    <passport-page
                        v-show="currentStep === 'passportPage'"
                        v-on:update-parent="updateParent"
                        :roomsPage="$store.state.registerFields.roomsPage"
                    ></passport-page>
                    <room-page
                        v-show="currentStep === 'roomPage'"
                        v-on:update-parent="updateParent"
                        :cinema_theater="$store.state.registerFields.cinemaTheater"
                        :getGender="$store.state.registerFields.selectGenderRooms"
                    ></room-page>
                    <address-page
                        v-show="currentStep === 'addressPage'"
                        v-on:update-parent="updateParent"
                        :room_page="$store.state.registerFields.roomsPage"
                        :family_page="$store.state.registerFields.familyPage"
                    ></address-page>
                    <family-page
                        v-show="currentStep === 'familyPage'"
                        v-on:update-parent="updateParent"
                        :user_type="student"
                        :family_photo_field="$store.state.registerFields.familyPhoto"
                    ></family-page>
                    <certificate-page
                        v-show="currentStep === 'certificatePage'"
                        v-on:update-parent="updateParent"
                        v-on:submit="onSubmit"
                        :family_page="$store.state.registerFields.familyPage"
                        :vaccine_field="$store.state.registerFields.vaccineField"
                    ></certificate-page>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: [
        'student',
    ],

    data: function () {
        return {
            list: ['universityPage'],
            currentStep: 'universityPage',
        }
    },
    methods: {
        onSubmit() {
            let formdata = new FormData();
            // присоединяем данные пользователя
            formdata.append("userSecondName", this.$store.state.userSecondName);
            formdata.append("userFirstName", this.$store.state.userFirstName);
            formdata.append("userLastName", this.$store.state.userLastName);
            formdata.append("userEmail", this.$store.state.userEmail);
            formdata.append("userPassword", this.$store.state.userPassword);
            formdata.append("userPhone", this.$store.state.userPhone);
            // присоединяем членов семьи
            formdata.append("members", JSON.stringify(this.$store.state.familyMembers));
            // присоединяем данные пользователя как студента
            if (!this.$store.state.registerFields.departmentField) {
                formdata.append("qualification", this.$store.state.qualification);
                formdata.append("course", this.$store.state.course);
                formdata.append("financialSource", this.$store.state.financialSource);
                formdata.append("formOfEducation", this.$store.state.formOfEducation);
                formdata.append("faculty", this.$store.state.faculty);
                if(this.$store.state.registerFields.specializationField != undefined) {
                    formdata.append("specialization", this.$store.state.specialization);
                }
            } else {
                formdata.append("department", this.$store.state.department);
            }
            // присоединяем паспорт
            formdata.append("typeOfPassport", this.$store.state.typeOfPassport);
            formdata.append("birthDate", this.$store.state.birthDate);
            formdata.append("genderAjax", this.$store.state.genderAjax);
            formdata.append("birthPlace", this.$store.state.birthPlace);
            formdata.append("passportDateIssued", this.$store.state.passportDateIssued);
            formdata.append("passportNumber", this.$store.state.passportNumber);
            formdata.append("passportIssuedBy", this.$store.state.passportIssuedBy);
            if (this.$store.state.passportSeries != null) {
                formdata.append("passportSeries", this.$store.state.passportSeries);
            }
            if (this.$store.state.passportDatePeriod != null) {
                formdata.append("passportDatePeriod", this.$store.state.passportDatePeriod);
            }
            if (this.$store.state.passportUnzdr != null) {
                formdata.append("passportUnzdr", this.$store.state.passportUnzdr);
            }
            // добавляем информацию про комнаты
            formdata.append("rooms", JSON.stringify(this.$store.state.selectedRooms));
            //добавляем информацию про адрес
            formdata.append("regionAjax", this.$store.state.region);
            if (this.$store.state.district != null) {
                formdata.append("districtAjax", this.$store.state.district);
            }
            formdata.append("typeOfCityAjax", this.$store.state.cities);
            formdata.append("cityAjax", this.$store.state.cityName);
            formdata.append("typeOfStreetAjax", this.$store.state.streets);
            formdata.append("streetAjax", this.$store.state.streetName);
            formdata.append("houseAjax", this.$store.state.house);
            if (this.$store.state.apartment != null) {
                formdata.append("apartmentAjax", this.$store.state.apartment);
            }
            // добавляем информацию про льготы
            if (this.$store.state.typeOfPrivilegeId != null) {
                formdata.append("typeOfPrivilege", this.$store.state.typeOfPrivilegeId);
            }
            formdata.append("lastFluorography", this.$store.state.lastDate);
            if (this.$store.state.otherPrivilege !== "") {
                formdata.append("otherPrivilege", this.$store.state.otherPrivilege);
            }
            if (this.$store.state.appealToTheAdministration !== null) {
                formdata.append("appealToTheAdministration", this.$store.state.appealToTheAdministration);
            }
            // фото
            formdata.append("file", this.$store.state.userPhoto);
            if (this.$store.state.familyPhoto) formdata.append("familyPhotoAjax", this.$store.state.familyPhoto);
            formdata.append("photoFluorografyAjax", this.$store.state.fluorographyPhoto);
            if (this.$store.state.fluorography2Photo) formdata.append("photoFluorografy2Ajax", this.$store.state.fluorography2Photo);
            if (this.$store.state.vaccinePhoto) formdata.append("photoVaccineAjax", this.$store.state.vaccinePhoto);
            formdata.append("oldPassportPhoto1", this.$store.state.oldPassportPhoto1);
            formdata.append("oldPassportPhoto2", this.$store.state.oldPassportPhoto2);
            formdata.append("oldPassportPhoto3", this.$store.state.oldPassportPhoto3);
            formdata.append("newPassportPhoto1", this.$store.state.newPassportPhoto1);
            formdata.append("newPassportPhoto2", this.$store.state.newPassportPhoto2);
            formdata.append("newPassportPhoto3", this.$store.state.newPassportPhoto3);
            formdata.append("privilegePhotoAjax", this.$store.state.privilegePhoto);
            formdata.append("statementPhoto", this.$store.state.statementPhoto);
            // axios запрос отправляющий данные в конроллер регистрации
            axios.post('/addUser',
                formdata, {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                })
                .then(function (response) {
                    console.log(response);
                    location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateParent(variable) {
            if(!this.list.includes(variable)){
                this.list.push(variable);
            }
            this.currentStep = variable;
        },
    },
}
</script>
