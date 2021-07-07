<template>
    <div id="personalData" aria-labelledby="personalData-tab" class="main-register-block">
        <div class="col-12 no-padding">
            <div class="for-personal-data">
                <div class="personal-data-user">
                    <div class="col-3">
                        <div class="user-images">
                            <span>Фото <small>(як на документи)</small></span>
                            <img id="photos-1" :src="userImg.file"
                                 alt="user-photos"
                                 class="img-thumbnail user-photo">
                            <input id="selectedFile" class="display-img"
                                   type="file" accept="image/jpeg,image/png" v-on:change="compressPhoto(userPhoto, userImg)"/>
                            <div class="btn btn-outline-primary"
                                 v-on:click="downloadPhoto('selectedFile')">
                                Прикріпити фото
                            </div>
                        </div>
                        <div v-if="this.$v.userPhoto.$dirty">
                            <div v-if="!this.$v.userPhoto.required" class="error">Фото обов`язкове</div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="user-main-info">
                            <div class="user-infos">
                                <div class="form-group">
                                    <label for="user-second-name">Прізвище</label>
                                    <input
                                        id="user-second-name"
                                        v-model="userSecondName"
                                        class="form-control"
                                        placeholder="Прізвище">
                                </div>
                                <div v-if="this.$v.userSecondName.$dirty">
                                    <div v-if="!this.$v.userSecondName.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>

                            <div class="user-infos">
                                <div class="form-group">
                                    <label for="user-first-name">Ім'я</label>
                                    <input
                                        id="user-first-name"
                                        v-model="userFirstName"
                                        class="form-control"
                                        placeholder="Ім'я">
                                </div>
                                <div v-if="this.$v.userFirstName.$dirty">
                                    <div v-if="!this.$v.userFirstName.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                            <div class="user-infos">
                                <div class="form-group">
                                    <label for="user-third-name">По батькові</label>
                                    <input
                                        id="user-third-name"
                                        v-model="userLastName"
                                        class="form-control"
                                        placeholder="По батькові">
                                </div>
                                <div v-if="this.$v.userLastName.$dirty">
                                    <div v-if="!this.$v.userLastName.required" class="error">Поле
                                        обов`язкове
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="user-main-info-next">
                            <div class="user-email">
                                <div class="form-group">
                                    <label for="InputEmail">Електронна пошта (логін
                                        кабінету)</label>
                                    <input id="InputEmail"
                                           v-model="userEmail"
                                           aria-describedby="emailHelp"
                                           class="form-control"
                                           placeholder="Введіть email"
                                           type="email">
                                    <small id="emailHelp" class="form-text text-muted">всі окрім
                                        yandex.ru, rambler.ru або mail.ru
                                    </small>
                                    <div v-if="this.$v.userEmail.$dirty">
                                        <div v-if="!this.$v.userEmail.emailCheck" class="error">Використовуйте будь-яку
                                            пошту окрім yandex.ru, rambler.ru або mail.ru
                                        </div>
                                        <div v-if="!this.$v.userEmail.required" class="error">Це поле обов'язкове
                                        </div>
                                        <div v-if="!this.$v.userEmail.checkEmail" class="error">Така почта вже є
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="password-and-phone">
                                <div class="user-pass">
                                    <div class="form-group">
                                        <label for="UserPassword">Пароль</label>
                                        <input id="UserPassword"
                                               v-model="userPassword"
                                               class="form-control"
                                               placeholder="Пароль"
                                               v-bind:type="type">
                                        <i class="fas fa-eye" v-on:click="showPassport"></i>
                                    </div>
                                    <div v-if="this.$v.userPassword.$dirty">
                                        <div v-if="!this.$v.userPassword.minLength" class="error">
                                            Мінімальна довжина паролю 8 символів
                                        </div>
                                        <div v-if="!this.$v.userPassword.required" class="error">Це поле
                                            обов'язкове
                                        </div>
                                    </div>
                                </div>
                                <div class="user-pass">
                                    <div class="form-group">
                                        <label for="VerifyUserPassword">Підтвердіть пароль</label>
                                        <input id="VerifyUserPassword"
                                               v-model="userPasswordConfirm"
                                               class="form-control"
                                               placeholder="Пароль"
                                               v-bind:type="typeConfirm">
                                        <i class="fas fa-eye" v-on:click="showConfirmPassport"></i>
                                    </div>
                                    <div v-if="this.$v.userPasswordConfirm.$dirty">
                                        <div v-if="!this.$v.userPasswordConfirm.sameAsPassword"
                                             class="error">Паролі не співпадають
                                        </div>
                                    </div>
                                </div>
                                <div class="user-infos">
                                    <div class="form-group">
                                        <label for="phone-number">Телефон</label>
                                        <input id="phone-number"
                                               v-model="userPhone"
                                               class="form-control item"
                                               placeholder="(000) 000-00-00"
                                               type="text">
                                    </div>
                                    <div v-if="this.$v.userPhone.$dirty">
                                        <div v-if="!this.$v.userPhone.maxLength" class="error">Введено
                                            занадто довгий номер
                                        </div>
                                        <div v-if="!this.$v.userPhone.minLength" class="error">Введено
                                            занадто короткий номер
                                        </div>
                                        <div v-if="!this.$v.userPhone.required" class="error">Це поле
                                            обов'язкове
                                        </div>
                                        <div v-if="!this.$v.userPhone.numeric" class="error">Вводьте
                                            лише цифри
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!department_fields" class="person-qualification-info">
                    <div class="qualification-info">
                        <label for="qualification">Освітній рівень</label>
                        <select id="qualification" v-model="qualificationId"
                                class="custom-select">
                            <option disabled hidden value="undefined">Оберіть...</option>
                            <option v-for="qualification in qualifications"
                                    v-bind:value="qualification.id">{{ qualification.name }}
                            </option>
                        </select>
                        <div v-if="this.$v.qualificationId.$dirty">
                            <div v-if="!this.$v.qualificationId.required" class="error">Поле
                                обов`язкове
                            </div>
                        </div>
                    </div>
                    <div class="qualification-info">
                        <label for="course">Курс (майбутній)</label>
                        <select id="course" v-model="courseId" class="custom-select">
                            <option disabled hidden value="undefined">Оберіть...</option>
                            <option v-for="course in courses" v-if="course.qualification_id === qualificationId"
                                    v-bind:value="course.id">{{ course.name }}
                            </option>
                        </select>
                        <div v-if="this.$v.courseId.$dirty">
                            <div v-if="!this.$v.courseId.required" class="error">Поле обов`язкове</div>
                        </div>
                    </div>
                    <div class="qualification-info">
                        <label for="formOfEducation">Форма навчання</label>
                        <select id="formOfEducation" v-model="formOfEducationId"
                                class="custom-select">
                            <option disabled hidden value="undefined">Оберіть...</option>
                            <option v-for="form in formsOfEducation" v-bind:value="form.id">
                                {{ form.name }}
                            </option>
                        </select>
                        <div v-if="this.$v.formOfEducationId.$dirty">
                            <div v-if="!this.$v.formOfEducationId.required" class="error">Поле
                                обов`язкове
                            </div>
                        </div>
                    </div>
                    <div class="qualification-info">
                        <label for="payment">Джерело фінансування</label>
                        <select id="payment" v-model="financialSourceId" class="custom-select">
                            <option disabled hidden value="undefined">Оберіть...</option>
                            <option v-for="financialSource in financialSources"
                                    v-bind:value="financialSource.id">{{ financialSource.name }}
                            </option>
                        </select>
                        <div v-if="this.$v.financialSourceId.$dirty">
                            <div v-if="!this.$v.financialSourceId.required" class="error">Поле
                                обов`язкове
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!department_fields" class="person-faculty-info">
                    <div class="faculty-info">
                        <label for="selectFaculty">Факультет</label>
                        <select id="selectFaculty" v-model="facultyId"
                                class="custom-select">
                            <option disabled hidden value="undefined">Оберіть...</option>
                            <option v-for="fac in faculties"
                                    v-if="$store.state.university_id === fac.educationalInstitution_id"
                                    v-bind:value="fac.id">{{ fac.fullName }}
                            </option>
                        </select>
                        <div v-if="this.$v.facultyId.$dirty">
                            <div v-if="!this.$v.facultyId.required" class="error">Поле обов`язкове</div>
                        </div>
                    </div>
                    <div v-if="specialization_field" class="faculty-info">
                        <label for="edu_program">Освітня програма</label>
                        <select id="edu_program" v-model="specializationId"
                                class="custom-select">
                            <option disabled hidden value="undefined">Оберіть...</option>
                            <option v-for="specialization in specializations"
                                    v-if="facultyId === specialization.faculty_id"
                                    v-bind:value="specialization.id">{{ specialization.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div v-if="department_fields" class="person-department-info">
                    <label for="department-select">Підрозділ</label>
                    <select id="department-select" v-model="departmentId"
                            class="custom-select">
                        <option hidden selected value="undefined">Оберіть...</option>
                        <option v-for="department in departments" v-bind:value="department.id">
                            {{ department.name }}
                        </option>
                    </select>
                    <div v-if="this.$v.departmentId.$dirty">
                        <div v-if="!this.$v.departmentId.required" class="error">Поле обов`язкове</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="navigate-btn">
            <a class="btn btn-primary btnPrevious" v-on:click="personalDataPagePrevious">
                <span class="lg_view">Назад</span>
                <span class="sm_view"><i class="fas fa-arrow-left"></i></span>
            </a>
            <a class="btn btn-primary btnNext"
               v-on:click="personalDataPageNext">
                <span class="lg_view">Далі</span>
                <span class="sm_view"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</template>

<script>
import {upload} from "../../imageCompressor";
import {maxLength, minLength, numeric, required, sameAs} from "vuelidate/lib/validators";

export default {
    name: "personalDataPageComponet",
    props: [
        'specialization_field',
        'department_fields',
        'statement_page'
    ],
    validations: {
        userPhoto: {
            required: function () {
                return this.userPhoto.file.length !== 0;
            },
        },
        userSecondName: {
            required,
        },
        userFirstName: {
            required,
        },
        userLastName: {
            required,
        },
        userEmail: {
            required,
            emailCheck: function () {
                return (!/[^@ \t\r\n]+@(yandex|mail|rambler)+\.(ru)/.test(this.userEmail));
            },
            checkEmail: async function () {
                let self = this;
                let value;
                await axios.get('/emailCheck', {
                    params: {
                        email: self.userEmail
                    }
                })
                    .then(function (response) {
                        value = response.data.original
                    })
                return value;
            }
        },
        userPassword: {
            required,
            minLength: minLength(8),
        },
        userPasswordConfirm: {
            sameAsPassword: sameAs('userPassword')
        },
        userPhone: {
            numeric,
            required,
            maxLength: maxLength(13),
            minLength: minLength(10),
        },
        qualificationId: {
            required,
        },
        courseId: {
            required,
        },
        formOfEducationId: {
            required,
        },
        financialSourceId: {
            required,
        },
        facultyId: {
            required,
        },
        departmentId: {
            required,
        },
        validationGroupPersonalStudentData: ['userPhoto', 'userSecondName', 'userFirstName', 'userLastName', 'userEmail', 'userPassword', 'userPasswordConfirm', 'userPhone', 'qualificationId', 'courseId', 'formOfEducationId', 'financialSourceId', 'facultyId'],
        validationGroupPersonalWorkerData: ['userPhoto', 'userSecondName', 'userFirstName', 'userLastName', 'userEmail', 'userPassword', 'userPasswordConfirm', 'userPhone', 'departmentId'],
    },
    data: function () {
        return {
            // userInfo
            userSecondName: this.userSecondName,
            userFirstName: this.userFirstName,
            userLastName: this.userLastName,
            userEmail: this.userEmail,
            userPassword: this.userPassword,
            userPasswordConfirm: this.userPasswordConfirm,
            userPhone: this.userPhone,
            userPhoto: {file: ""},
            userImg: {file: "/images/profile.png"},
            qualificationId: this.qualificationId,
            courseId: this.courseId,
            financialSourceId: this.financialSourceId,
            formOfEducationId: this.formOfEducationId,
            facultyId: this.facultyId,
            specializationId: this.specializationId,
            departmentId: this.departmentId,
            faculties: this.faculties,
            specializations: this.specializations,
            qualifications: this.qualifications,
            courses: this.courses,
            formsOfEducation: this.formsOfEducation,
            financialSources: this.financialSources,
            departments: this.departments,
            type: 'password',
            typeConfirm: 'password'
        }
    },
    mounted() {
        this.loadFaculties();
        this.loadDepartments();
        this.loadSpecializations();
        this.loadQualifications();
        this.loadCourse();
        this.loadFinancialSourse();
        this.loadFormOfEducation();
    },
    methods: {
        showPassport() {
            if (this.type === 'password') {
                this.type = 'text'
            } else {
                this.type = 'password'
            }
        },
        showConfirmPassport() {
            if (this.typeConfirm === 'password') {
                this.typeConfirm = 'text'
            } else {
                this.typeConfirm = 'password'
            }
        },
        loadFaculties() {
            let self = this;
            axios({
                url: '/api/faculties',
                method: 'get',
            })
                .then(function (response) {
                    console.log(response.data);
                    self.faculties = response.data
                })
        },
        loadSpecializations() {
            let self = this;
            axios.get(
                '/api/specialization'
            )
                .then(function (response) {
                    self.specializations = response.data
                })
        },
        loadQualifications() {
            let self = this;
            axios.get(
                '/api/qualification'
            )
                .then(function (response) {
                    self.qualifications = response.data
                })
        },
        loadCourse() {
            let self = this;
            axios.get(
                '/api/course'
            )
                .then(function (response) {
                    self.courses = response.data
                })
        },
        loadFinancialSourse() {
            let self = this;
            axios.get(
                '/api/financialSource'
            )
                .then(function (response) {
                    self.financialSources = response.data
                })
        },
        loadFormOfEducation() {
            let self = this;
            axios.get(
                '/api/formOfEducation'
            )
                .then(function (response) {
                    self.formsOfEducation = response.data
                })
        },
        loadDepartments() {
            let self = this;
            axios.get(
                '/api/department'
            )
                .then(function (response) {
                    self.departments = response.data
                })
        },
        compressPhoto(Photo, Img) {
            upload(Photo, Img);
        },
        downloadPhoto(id) {
            document.getElementById(id).click();
        },
        personalDataPageNext() {
            if (this.department_fields) {
                this.$v.validationGroupPersonalWorkerData.$touch();
                if (!this.$v.validationGroupPersonalWorkerData.$invalid) {
                    this.$store.commit('setValue', {'item': 'userPhoto', 'value': this.userPhoto.file});
                    this.$store.commit('setValue', {'item': 'userSecondName', 'value': this.userSecondName});
                    this.$store.commit('setValue', {'item': 'userFirstName', 'value': this.userFirstName});
                    this.$store.commit('setValue', {'item': 'userLastName', 'value': this.userLastName});
                    this.$store.commit('setValue', {'item': 'userEmail', 'value': this.userEmail});
                    this.$store.commit('setValue', {'item': 'userPassword', 'value': this.userPassword});
                    this.$store.commit('setValue', {'item': 'userPhone', 'value': this.userPhone});
                    this.$store.commit('setValue', {'item': 'department', 'value': this.departmentId});
                    this.$emit('update-parent', 'passportPage');
                }
            } else {
                this.$v.validationGroupPersonalStudentData.$touch();
                if (!this.$v.validationGroupPersonalStudentData.$invalid) {
                    this.$store.commit('setValue', {'item': 'userPhoto', 'value': this.userPhoto.file});
                    this.$store.commit('setValue', {'item': 'userSecondName', 'value': this.userSecondName});
                    this.$store.commit('setValue', {'item': 'userFirstName', 'value': this.userFirstName});
                    this.$store.commit('setValue', {'item': 'userLastName', 'value': this.userLastName});
                    this.$store.commit('setValue', {'item': 'userEmail', 'value': this.userEmail});
                    this.$store.commit('setValue', {'item': 'userPassword', 'value': this.userPassword});
                    this.$store.commit('setValue', {'item': 'userPhone', 'value': this.userPhone});
                    this.$store.commit('setValue', {'item': 'qualification', 'value': this.qualificationId});
                    this.$store.commit('setValue', {'item': 'course', 'value': this.courseId});
                    this.$store.commit('setValue', {'item': 'financialSource', 'value': this.financialSourceId});
                    this.$store.commit('setValue', {'item': 'formOfEducation', 'value': this.formOfEducationId});
                    this.$store.commit('setValue', {'item': 'faculty', 'value': this.facultyId});
                    this.$store.commit('setValue', {'item': 'specialization', 'value': this.specializationId});
                    this.$emit('update-parent', 'passportPage');
                }
            }
        },
        personalDataPagePrevious() {
            if (!this.statement_page) {
                this.$emit('update-parent', 'universityPage');
            } else {
                this.$emit('update-parent', 'statementPage');
            }
        },

    }
}
</script>

<style scoped>
.user-pass {
    position: relative;
}

.fa-eye {
    position: absolute;
    top: 44px;
    border-radius: 5px;
    right: 20px;
    z-index: 2;
}
</style>
