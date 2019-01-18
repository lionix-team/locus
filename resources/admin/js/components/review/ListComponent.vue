<template>
    <loginned-layout>
        <div id="tables">
            <div class="header md-6">
                <div class="header-body">
                    <h1 class="header-title">
                        Reviews
                    </h1>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form v-on:submit.prevent="handleSearch" class="mb-4 search-form col-md-12">
                            <div class="search-form-row">
                                <div class="col-12 col-md-12 mb-3 search-block">
                                    <input type="text" class="form-control col-md-8 search-input"
                                           placeholder="Search by Feedback or Place" v-model="form.keyword">
                                    <select v-model="form.status" class="form-control col-md-3 ml-2 status-filter">
                                        <option value="">All</option>
                                        <option :value="statusPending">Pending</option>
                                        <option :value="statusApproved">Approved</option>
                                        <option :value="statusDeclined">Declined</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary search-btn" :disabled="loading">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Feedback</th>
                                <th scope="col">Star</th>
                                <th scope="col">Status</th>
                                <th scope="col">Place</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="review in reviews.data">
                                <td>{{review.text}}</td>
                                <td>{{review.star}}</td>
                                <td>{{review.status===statusPending ? "Pending" : review.status===statusDeclined ?
                                    "Declined" : "Approved"}}
                                </td>
                                <td>{{review.place.name}}</td>
                                <td>
                                    <button v-if="review.status===statusDeclined || review.status===statusPending"
                                            class="btn btn-primary"
                                            @click="handleStatusChange(statusApproved,review.id)">
                                        Accept
                                    </button>
                                    <button v-if="review.status===statusApproved || review.status===statusPending"
                                            class="btn btn-danger"
                                            @click="handleStatusChange(statusDeclined,review.id)">
                                        Decline
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :changePage="getList" :data="reviews" :requestParams="paginationParams"/>
                </div>
            </div>
        </div>
    </loginned-layout>
</template>

<script>
    import LoginnedLayout from '../layouts/LoginnedLayoutComponent'
    import {mapActions, mapGetters} from 'vuex'
    import Pagination from 'vue-laravel-paginex'
    import {STATUS_PENDING, STATUS_DECLINED, STATUS_APPROVED} from '../../store/modules/review/constants'

    export default {
        name: "ReviewsListComponent",
        components: {LoginnedLayout, Pagination},
        data() {
            return {
                reviews: [],
                // reviewsData: {},
                page: 1,
                loading: false,
                form: {
                    keyword: "",
                    status: ""
                },
                statusPending: STATUS_PENDING,
                statusDeclined: STATUS_DECLINED,
                statusApproved: STATUS_APPROVED,
            }
        },
        mounted() {
            this.getList(this.paginationParams()).then(() => {
                this.reviews = this.reviewsGetter();
            });
            this.$store.watch(this.reviewsGetter, reviews => {
                this.reviews = reviews;
            });
        },
        methods: {
            ...mapActions({
                getList: 'getReviews',
                changeStatus: 'changeReviewStatus',
            }),
            ...mapGetters({
                reviewsGetter: 'getReviews'
            }),
            handleSearch() {
                this.loading = true;
                this.page = 1;
                // this.changePage(1).then(() => {
                // conso
                    this.getList(this.paginationParams()).then(() => {
                        this.loading = false;
                    }).catch(() => {
                        this.loading = false;
                    });
                // });
            },
            handleStatusChange(status, reviewId) {
                this.changeStatus({status: status, review: reviewId}).then((res) => {
                    console.log(res);
                });
            },
            paginationParams() {
                return {
                    keyword: this.form.keyword,
                    status: this.form.status,
                    page: this.page
                }
            }
        }
    }
</script>
<style scoped>
    .search-input {
        float: left;
    }

    .search-btn {
        float: right;
    }

    .create-btn {
        float: right;
    }

    .search-form {
        float: left;
        padding: 0;
    }

    .search-form-row {
        margin-right: 0 !important;
    }

    .search-block {
        padding: 0 0 !important;
    }

    .status-filter {
        float: left;
    }
</style>
