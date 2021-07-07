<template>
    <div id="Statement" aria-labelledby="Statement"
         class="tab-pane statement-register-block">
        <h3>Роздрукуйте шаблон заяви на листі <b>А4</b> та заповніть</h3>
        <a class="btn btn-primary statement-blank-button" href="/files/zayava.doc"><i
            class="far fa-file-word"></i><span class=" file-world">Завантажити шаблон заяви </span></a>
        <h5>Завантажте фото заповненої власноруч заяви</h5>
        <div class="statement-images">
            <img id="statementPhoto" :src="statementImg.file"
                 alt="Фото заяви"
                 class="img-thumbnail user-photo">
            <input id="statementFile" class="display-img"
                   type="file" accept="image/jpeg,image/png" v-on:change="compressPhoto(statementPhoto, statementImg)"/>
            <div class="btn btn-outline-primary"
                 v-on:click="downloadPhoto('statementFile')">
                Прикріпити фото
            </div>
            <div v-if="this.$v.statementPhoto.$dirty">
                <div v-if="!this.$v.statementPhoto.required" class="error">Поле обов`язкове</div>
            </div>
        </div>
        <div class="navigate-btn">
            <a class="btn btn-primary btnPrevious" v-on:click="statementPagePrev">
                <span class="lg_view">Назад</span>
                <span class="sm_view"><i class="fas fa-arrow-left"></i></span>
            </a>
            <a class="btn btn-primary btnNext"
               v-on:click="statementPageNext">
                <span class="lg_view">Далі</span>
                <span class="sm_view"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</template>

<script>

import {upload} from "../../imageCompressor";

export default {
    name: "statementPage",
    validations: {
        statementPhoto: {
            required: function () {
                return this.statementPhoto.file.length !== 0;
            },
        },
    },
    data: function () {
        return {
            statementPhoto: {file: ""},
            statementImg: {file: "/images/pass.png"},
        }
    },
    methods: {
        statementPageNext() {
            this.$v.statementPhoto.$touch();
            if (!this.$v.statementPhoto.$invalid) {
                this.$store.commit('setValue', {'item': 'statementPhoto', 'value': this.statementPhoto.file})
                this.$emit('update-parent', 'personalPage');
            }
        },

        statementPagePrev() {
            this.$emit('update-parent', 'universityPage');
        },
        compressPhoto(Photo, Img) {
            upload(Photo, Img);
        },
        downloadPhoto(id) {
            document.getElementById(id).click();
        },
    }
}
</script>

<style scoped>

</style>
