<template>
    <div class="table-components">
        <div class="control-panel">
            <slot v-if="modalOpen" name="control-add-button" v-bind:item="this.valueSelect"></slot>
            <div v-show="show_add_button">
                <a id="show-modal" class="btn btn-success text-white" v-on:click="openModal(-1)">Додати</a>
            </div>
            <div v-show="show_global_delete_button">
                <delete-modal-component v-if="modalGlobalOpen" :text_header="text_header"
                                        :text_message="text_message"
                                        v-on:close="openDeleteGlobalModal"
                                        v-on:delete="deleteSelected"></delete-modal-component>
                <a id="show-delete-modal" class="btn btn-danger text-white"
                   v-on:click="modalGlobalOpen = true">Видалити</a>
            </div>
        </div>
        <!--        <div class="scroll-container">-->
        <table class="table table-bordered table-font table-hover" v-bind:class="{'table-striped':mobileSize}">
            <slot name="find"></slot>
            <thead class="headerTable">
            <tr v-if="!mobileSize">
                <th v-if="selectable" class="t-fields checkbox">Виділити</th>
                <th v-for="key in keys" v-if="list.includes(key)" class="t-fields">
                    {{ names[key] }}
                </th>
                <th v-if="actions_col" class="t-fields actions">Дії</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="!mobileSize" v-for="item in items.data">
                <td v-if="selectable" class="t-fields-awards checkbox"><input v-bind:id="'checkbox'+item.id"
                                                                              type="checkbox"></td>
                <td v-for="key in keys" v-if="list.includes(key)">
                    <span v-if="item[key] === null || undefined"></span>
                    <span v-else-if="key === 'path'"><a v-bind:href="item[key]">{{ item[key] }}</a></span>
                    <span v-else-if="(item[key].toString().length < 100) && (item[key] != null)">{{ item[key] }}</span>
                    <span v-else>{{ item[key].toString().substr(0, 98) }}..</span>
                </td>
                <td v-if="actions_col" class="t-fields-awards actions">
                    <slot v-bind:item="item"></slot>
                </td>
            </tr>
            <tr v-if="mobileSize" v-for="item in items.data">
                <div v-for="key in keys" v-if="list.includes(key)">
                    <span v-if="item[key] === null || undefined"></span>
                    <span v-else-if="key === 'path'"><a v-bind:href="item[key]"><b>{{ names[key] }}</b>: {{ item[key] }}</a></span>
                    <span v-else-if="(item[key].toString().length < 100) && (item[key] != null)"><b>{{ names[key] }}</b>: {{ item[key] }}</span>
                    <span v-else><b>{{ names[key] }}</b>: {{ item[key].toString().substr(0, 98) }}..</span>
                </div>
                <div v-if="actions_col" class="t-fields-awards actions">
                    <slot v-bind:item="item"></slot>
                </div>
            </tr>
            </tbody>
        </table>
        <!--        </div>-->
        <pagination :data="items" :loading="loading" :size="size" v-on:changePage="search"></pagination>
    </div>
</template>

<script>
import {names} from '../names.js';

export default {
    props: [
        'selectable',
        'actions_col',
        'list',
        'search_path',
        'delete_path',
        'show_add_button',
        'show_global_delete_button',
        'text_message',
        'text_header'
    ],
    data() {
        return {
            headers: [],
            loading: true,
            size: 20,
            modalOpen: false,
            modalGlobalOpen: false,
            items: [],
            currentPage: 1,
            keys: [],
            params: {
                size: 20
            },
            valueSelect: -1,
            mobileSize:this.mobileSize,
        }
    },
    mounted() {
        this.search();
        this.getSize();
        this.names = names;
    },
    created() {
        this.$eventBus.$on('close-modal', this.closeModal);
        this.$eventBus.$on('open-modal', this.openModal);
        this.$eventBus.$on('reload-data', (data) => {
            this.params = {
                lastDate: data,
                size: this.size,
            };
            this.search()
        });

    },
    beforeDestroy() {
        this.$eventBus.$off('close-modal');
        this.$eventBus.$off('open-modal');
        this.$eventBus.$off('reload-data', this.search);
    },
    methods: {
        getSize(){
            this.mobileSize = screen.width <= 760;
        },
        openModal(id) {
            this.valueSelect = id
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
        },
        openDeleteGlobalModal() {
            this.modalGlobalOpen = !this.modalGlobalOpen;
        },
        deleteSelected() {
            this.openDeleteGlobalModal();
            for (const item of this.items.data) {
                let element = document.querySelector("#checkbox" + item.id);
                let self = this;
                if (element.checked === true) {
                    axios({
                        method: 'delete',
                        url: this.delete_path + item.id
                    }).then((response) => {
                        self.search(self.currentPage);
                    }, (error) => {
                        // this.errorMessage = error;
                        // this.errorShow = true;
                    })
                }
            }
        },
        search: function (pageNumber,data) {

            this.loading = true;
            this.currentPage = pageNumber;
            let self = this;
            axios.get(this.search_path + pageNumber, {
                params: self.params,
            })
                .then(response => {
                    this.loading = false
                    this.items = response.data
                    if(response.data.data[0] !== undefined){
                        this.keys = Object.keys(response.data.data[0]);
                        this.keysOrder();
                        console.log(response);
                    }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            // $.ajax({
            //     type: 'get',
            //     url: this.search_path + pageNumber,
            //     dataType: 'json',
            //     data: {
            //         size: self.size,
            //     },
            //     success: function (data) {
            //         self.loading = false
            //         self.keys = Object.keys(data.data[0]);
            //         self.keysOrder();
            //         self.items = data
            //     }, error: function (xhr) {
            //     }
            // })
        },
        keysOrder() {
            for (let i = 0; i < this.list.length; i++) {
                [this.keys[i], this.keys[this.keys.indexOf(this.list[i])]] = [this.keys[this.keys.indexOf(this.list[i])], this.keys[i]];
            }
        }
    },
}
</script>

<style lang="scss" scoped style>

.headerTable {
    background-color: #cfd2d5;
    top: 55px;
    z-index: 1020;

        th {
            box-shadow: inset 1px 1px #999696, 0 1px #999696;
            &:last-child {
                box-shadow: inset 1px 1px #999696, 1px 1px #999696;
            }
        }
 }

.table-components {
    display: block;
    margin-top: 10px;

    .control-panel {
        margin-left: 25px;
        margin-right: 25px;
        display: flex;
        margin-bottom: 10px;

        div {
            margin-right: 5px;
        }

    }

    .table {
        table-layout: fixed;
        overflow-x: auto;
    }
    .checkbox {
        width: 100px;
        text-align: center;
    }

    .actions {
        width: 100px;
        text-align: center;
    }
}





</style>
