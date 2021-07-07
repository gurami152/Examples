<template>
    <div class="pagination">
        <div v-if="loading" class="loading-animation">
            <div class="spinner-border"></div>
        </div>
        <ul v-if="pageCount>1" class="pagination table-pagination">
            <button :disabled="pageNumber === 1" class="page-item page-link first-radius" v-on:click="firstPage">
                <i class="fas fa-angle-double-left"></i>
            </button>
            <button :disabled="pageNumber === 1" class="page-item page-link" v-on:click="prevPage">
                <i class="fas fa-angle-left"></i>
            </button>
            <button v-for="(page,index) in pageCount"
                    v-if="(index >= pageNumber -1-pageNeighbours) &&(index <= pageNumber-1 +pageNeighbours )"
                    class="page-item page-link"
                    v-bind:class="{ 'activePage': pageNumber === index+1}" v-on:click="gotoPage(index+1)">
                <b>{{ index + 1 }}</b>
            </button>
            <button :disabled="pageNumber >= pageCount" class="page-item page-link" v-on:click="nextPage">
                <i class="fas fa-angle-right"></i>
            </button>
            <button :disabled="pageNumber >= pageCount" class="page-item page-link last-radius" v-on:click="lastPage">
                <i class="fas fa-angle-double-right"></i>
            </button>
        </ul>
    </div>
</template>

<script>
export default {
    props: [
        'data',
        'size',
        'loading',
    ],
    name: "pagination",
    data() {
        return {
            pageNumber: 1,
            totalPages: this.totalPages,
            itemsOnPage: this.itemsOnPage,
            pageCount: this.pageCount,
            pageNeighbours: 3,
        }
    },
    mounted() {
        this.pagination();
    },
    methods: {
        prevPage() {
            this.pageNumber--;
        },
        nextPage() {
            this.pageNumber++;
        },
        gotoPage(number) {
            this.pageNumber = number;
        },
        firstPage() {
            this.pageNumber = 1;
        },
        lastPage() {
            this.pageNumber = this.pageCount;
        },
        pagination() {
            let l = this.data.total;
            let s = this.size;
            this.pageCount = Math.ceil(l / s);
            this.itemsOnPage = this.data.data
        }
    },
    watch: {
        pageNumber: function () {
            this.$emit('changePage', this.pageNumber);
        },
        size: function () {
            this.pagination();
        },
        data: function () {
            this.pagination();
        },
    }
}
</script>

<style lang="scss">

    .pagination {
        margin-left: 1px;

        .activePage {
            background-color: #3490dc;
            color: white;
            border: 1px #3490dc;
        }

        .page-link {
            font-size: 14px;
        }

        .first-radius {
            border-radius: 5px 0 0 5px;
        }

        .last-radius {
            border-radius: 0 5px 5px 0;
        }
    }

</style>
