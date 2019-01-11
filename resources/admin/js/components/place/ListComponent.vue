<template>
    <loginned-layout>
        <div id="tables">
            <div class="header md-6">
                <div class="header-body">
                    <h1 class="header-title">
                        Places
                    </h1>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <router-link to="/place/create" class="btn btn-success create-btn mb-4">Create</router-link>
                    <div class="table-responsive">
                        <form v-on:submit.prevent="handleSearch" class="mb-4 search-form col-md-12">
                            <div class="search-form-row">
                                <div class="col-12 col-md-12 mb-3 search-block">
                                    <input type="text" class="form-control col-md-11 search-input"
                                           placeholder="Search by Name or Street" v-model="form.keyword">
                                    <button type="submit" class="btn btn-primary search-btn" :disabled="loading">
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Street</th>
                                <th scope="col">Fuel Types</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="place in list">
                                <td>{{place.name}}</td>
                                <td>{{place.street}}</td>
                                <td>
                                    <p v-for="type in place.fuel_types">
                                        {{type.fuel_type.name}}-{{type.price}}
                                    </p>
                                </td>
                                <td>
                                    <router-link :to="{path:'/place/edit/'+place.id}" class="btn btn-primary">Edit
                                    </router-link>
                                    <button class="btn btn-danger" @click="deleteItem(place.id)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :changePage="getPlaces" :data="places"/>
                </div>
            </div>
        </div>
    </loginned-layout>
</template>

<script>
    import LoginnedLayout from '../layouts/LoginnedLayoutComponent'
    import {mapActions, mapGetters} from 'vuex'
    import Pagination from 'vue-laravel-paginex'
    import swal from 'sweetalert'

    export default {
        components: {LoginnedLayout, Pagination},
        data() {
            return {
                places: [],
                list: [],
                page: 1,
                loading: false,
                form: {
                    keyword: ""
                }
            }
        },
        mounted() {
            this.getPlaces(1).then(() => {
                this.places = this.placesGetter();
                this.list = this.getPlacesData();
            });
            this.$store.watch(this.placesGetter, places => {
                this.places = places;
            });
            this.$store.watch(this.getPlacesData, list => {
                this.list = list;
            });
            this.$store.watch(this.getPage, page => {
                this.page = page;
            });
            this.$store.watch(this.getKeyword, keyword => {
                this.form.keyword = keyword;
            });
        },
        methods: {
            ...mapActions([
                'getPlaces',
                'deletePlace',
                'changePage',
                'setKeyword',
            ]),
            ...mapGetters({
                placesGetter: 'getPlaces',
                getPlacesData: 'getPlacesData',
                getPage: 'getPage',
                getKeyword: 'getKeyword',
            }),
            deleteItem: function (id) {
                swal({
                    title: "Are you sure?",
                    text: "You want delete this place?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.deletePlace({id: id}).then(() => {
                                if (this.places.data.length === 1 && this.page > 1) {
                                    this.changePage(this.page - 1).then(() => {
                                        this.places = this.getPlaces(this.page);
                                    });
                                } else {
                                    this.places = this.getPlaces(this.page);
                                }
                            });
                        }
                    });
            },
            handleSearch() {
                this.loading = true;
                this.setKeyword({keyword: this.form.keyword}).then(() => {
                    this.changePage(1).then(() => {
                        this.getPlaces(this.page).then(() => {
                            this.loading = false;
                        }).catch(() => {
                            this.loading = false;
                        });
                    });
                });
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
</style>
