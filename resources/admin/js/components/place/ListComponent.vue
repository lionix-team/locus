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

                    <div class="table-responsive">
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
                            <tr v-for="place in places.data">
                                <td>{{place.name}}</td>
                                <td>{{place.street}}</td>
                                <td>
                                    <p v-for="type in place.fuel_types">
                                        {{type.fuel_type.name}}-{{type.price}}
                                    </p>
                                </td>
                                <td>
                                    <router-link :to="{path:'/place/edit/'+place.id}" class="btn btn-primary">Edit</router-link>
                                    <router-link :to="{path:'/place/edit/'+place.id}" class="btn btn-danger">Delete</router-link>
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

    export default {
        components: {LoginnedLayout, Pagination},
        data() {
            return {
                places: []
            }
        },
        mounted() {
            this.getPlaces(1).then(() => {
                this.places = this.placesGetter();
            });
            this.$store.watch(this.placesGetter, places => {
                this.places = places;
            });
        },
        methods: {
            ...mapActions([
                'getPlaces'
            ]),
            ...mapGetters({
                placesGetter: 'getPlaces',
            })
        }
    }
</script>
