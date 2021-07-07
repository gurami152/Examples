<template>
    <div id="familyMembers"
         aria-labelledby="familyMembers-tab"
         class="main-register-block">
        <div class="family-data">
            <div class="family-members-info">
                <h5 class="text-style">Дані про членів родини з якими проживає студент</h5>
            </div>
            <div class="member-info-block" v-for="(member,index) in familyMembers" v-if="(member !== undefined)">
                <span class="member-name-block">{{ member[0] + ': ' + member[1] }}</span>
                <span class="member-button-block"><i class="fas fa-minus-circle"
                                                     v-on:click="deleteMember(index)"></i></span>
            </div>
            <div class="family-member-button">
                <h5 class="text-style">Якщо Ви живете не один/одна, то додайте родичів з якими
                    мешкаєте</h5>
            </div>
            <div>
                <div class="family-members-div">
                    <h5 class="text-style">Оберіть члена родини який проживає з Вами</h5>
                    <div class="btn-group type-of-family-members" role="group">
                        <div v-for="type in typesOfFamilyMember"
                             v-if="familyMembers[type.id] === undefined"
                             class="btn btn-secondary type-of-family-member"
                             type="button"
                             v-on:click="showFamilyMembersFields(type.id)">{{ type.name }}
                        </div>
                    </div>
                </div>
                <div v-if="familyMemberFields" class="family-member">
                    <h5 class="text-style">Заповніть інформацію про обраного члена родини</h5>
                    <span class="selected-type-of-family-member"></span>
                    <div class="form-group">
                        <label for="name-family-member">ПІБ</label>
                        <input id="name-family-member" v-model="selectedFamilyMemberName"
                               class="form-control"
                               type="text"/>
                    </div>
                    <div class="form-group">
                        <label for="phone-number-family-member">Номер телефону</label>
                        <input id="phone-number-family-member" v-model="selectedFamilyMemberPhone"
                               class="form-control" type="text"/>
                    </div>
                    <div class="added-members">
                        <div class="btn btn-success add-member " v-on:click="hideFamilyMembers">Додати
                        </div>
                    </div>
                </div>
            </div>
            <div class="family-photo">
                <div v-if="family_photo_field" class="family-photo">
                    <div class="family-images">
                        <img id="family-image" :src="familyImg.file"
                             alt="user-photos"
                             class="img-thumbnail passport-photos">
                        <input id="family-members-image" class="display-img"
                               type="file" accept="image/jpeg,image/png"
                               v-on:change="compressPhoto(familyPhoto,familyImg)"/>
                        <label for="family-members-image">Довідка про склад сім'ї</label>
                        <div class="btn btn-outline-primary"
                             v-on:click="downloadPhoto('family-members-image')">
                            Прикріпити фото
                        </div>
                    </div>
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
import {upload} from "../../imageCompressor";

export default {
    name: "familyPageComponent",
    props: [
        'user_type',
        'family_photo_field',
    ],
    mounted() {
        this.loadTypesOfMember();
    },
    data: function () {
        return {
            familyImg: {file: "/images/vacine.png"},
            familyPhoto: {file: ""},
            familyMembers: this.familyMembers,
            familyMember: false,
            familyMemberFields: false,
            typesOfFamilyMember: this.typesOfFamilyMember,
            selectedFamilyMemberId: this.selectedFamilyMemberId,
            selectedFamilyMemberName: this.selectedFamilyMemberName,
            selectedFamilyMemberPhone: this.selectedFamilyMemberPhone,
        }
    },
    methods: {
        compressPhoto(Photo, Img) {
            upload(Photo, Img);
        },
        downloadPhoto(id) {
            document.getElementById(id).click();
        },
        showFamilyMembersFields(id) {
            this.selectedFamilyMemberId = id;
            this.familyMemberFields = true;
        },
        hideFamilyMembers: function () {
            this.$set(this.familyMembers, this["selectedFamilyMemberId"], [this.selectedFamilyMemberName, this.selectedFamilyMemberPhone]);
            this.familyMember = !this.familyMember;
            this.familyMemberFields = !this.familyMemberFields;
            this.selectedFamilyMemberName = "";
            this.selectedFamilyMemberPhone = "";
        },
        loadTypesOfMember() {
            let self = this;
            axios.get(
                '/api/typeOfFamilyMember', {
                    params: {
                        student: this.user_type,
                    }
                })
                .then(function (response) {
                    self.typesOfFamilyMember = response.data
                    self.familyMembers = new Array(response.data.length + 1);
                })
        },
        stepPrev() {
            this.$emit('update-parent', 'addressPage');
        },
        stepNext() {
            this.$store.commit('setValue', {'item': 'familyMembers', 'value': this.familyMembers});
            this.$store.commit('setValue', {'item': 'familyPhoto', 'value': this.familyPhoto.file});
            this.$emit('update-parent', 'certificatePage');
        },
        deleteMember(index) {
            this.$delete(this.familyMembers, index)
            this.familyMembers.splice(index, 0, undefined);
        }
    }
}
</script>
