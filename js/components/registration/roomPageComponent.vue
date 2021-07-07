<template>
    <div id="selectRoom"
         aria-labelledby="selectRoom-tab"
         class="main-register-block">
        <div class="info">
            <div class="selectedRooms">
                <div class="selected-rooms-info">
                    <h5>Дані про кімнати</h5>
                </div>
            </div>
            <div class="form-group hostel-selection">
                <label for="select-hostel">
                    Оберіть гуртожиток
                </label>
                <select id="select-hostel" v-model="dormitoryId" class="form-control"
                        v-on:change="getRoomsAjax(); startTimer()">
                    <option disabled hidden value="undefined">Оберіть...</option>
                    <option v-for="dormitory in dormitories" v-bind:value="dormitory.id">
                        {{ dormitory.name }}
                    </option>
                </select>
            </div>
            <div>
            </div>
            <div class="timer-and-legend" v-if="cinema_theater">
                            <span class="timer">До актуализации комнат осталось
                                <span
                                    class="timeLeft">{{ timeToUpdate }}</span>
                            </span>
                <div class="legend">
                    <span class="empty-room"></span><span>- Свободна кімната</span>
                    <span class="not-empty-room"></span><span>- Частично заповнена кімната</span>
                    <span class="full-room"></span><span>- Заповнена кімната</span>
                </div>
            </div>
        </div>
        <div id="mainDiv" v-show="roomsdata" v-if="showBlocks ">
            <dorm-block v-for="dormblock in roomsdata.data.block"
                        :dormblock="dormblock"
                        :load="cinema_theater"
                        :selected="selectedRooms"
                        :types="typesOfUserRoomSelection"
                        @getRooms="getRoomsAjax"
                        @storeroom="storeSelectedRooms">
            </dorm-block>
            <corridor-dorm-block v-for="flour in roomsdata.data.flour"
                                 :flour="flour"
                                 :load="cinema_theater"
                                 :selected="selectedRooms"
                                 :types="typesOfUserRoomSelection"
                                 @getRooms="getRoomsAjax"
                                 @storeroom="storeSelectedRooms">
            </corridor-dorm-block>
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
export default {
    name: "roomPageComponent",
    props: [
        'cinema_theater',
        'getGender'
    ],
    mounted() {
        this.loadDormitories();
        this.loadTypesOfRooms();
    },
    data: function () {
        return {
            dormitoryId: this.dormitoryId,
            roomsdata: [],
            showBlocks: false,
            selectedRooms: [],
            dormitories: this.dormitories,
            typesOfUserRoomSelection: this.typesOfUserRoomSelection,
            timerStarted: false,
            timeToUpdate: 15,
        }
    },
    methods: {
        loadTypesOfRooms() {
            self = this;
            axios.get('/getTypesOfUserSelection').then(function (response) {
                self.typesOfUserRoomSelection = response.data;
            });
        },
        loadDormitories() {
            let self = this;
            axios.get(
                '/api/dormitory', {
                    params: {
                        lang: 1
                    }
                })
                .then(function (response) {
                    self.dormitories = response.data
                })
        },
        getRoomsAjax() {
            self = this;
            axios.get('/roomsInfo', {
                params: {
                    faculty_id: this.$store.state.faculty,
                    gender_id: this.$store.state.genderAjax,
                    hostel_id: this.dormitoryId,
                    getGender: this.getGender,
                }
            }).then(function (response) {
                self.roomsdata = response;
                self.showBlocks = true;
            })
        },
        getTypesOfRooms() {
            self = this;
            axios.get('/getTypesOfUserSelection').then(function (response) {
                self.typesOfUserRoomSelection = response.data;
            });
        },
        startTimer() {
            if (this.cinema_theater) {
                if (!this.timerStarted) {
                    this.timerStarted = true;
                    setInterval(() => {
                        this.timeToUpdate--;
                        if (this.timeToUpdate <= 0) {
                            this.getRoomsAjax();
                            this.timeToUpdate = 15;
                        }
                    }, 1000);
                }
            }
        },
        storeSelectedRooms(roomId, typeId) {
            this.selectedRooms[typeId] = roomId;
            this.timeToUpdate = 0;
        },
        stepNext() {
            this.timerStarted = false;
            this.$store.commit('setValue', {'item': 'selectedRooms', 'value': this.selectedRooms});
            this.$emit('update-parent', 'addressPage');
        },
        stepPrev() {
            this.$emit('update-parent', 'passportPage');
        }
    }
}
</script>
