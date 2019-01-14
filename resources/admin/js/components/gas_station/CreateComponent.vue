<template>
    <loginned-layout>
        <div id="forms">
            <div class="header mt-md-6">
                <div class="header-body">
                    <h1 class="header-title">
                        Add new gas station
                    </h1>
                </div>
            </div>
            <div class="card col-md-12">
                <div class="card-body">

                    <form v-on:submit.prevent="handleSubmit">
                        <div class="form-row">
                            <div class="col-12 col-md-12 mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control"
                                       :class="{'is-invalid':errors.name}"
                                       placeholder="Name" v-model="form.name">
                                <div class="invalid-feedback" v-if="errors.name">
                                    {{errors.name[0]}}
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label>Latitude</label>
                                <input type="text" class="form-control"
                                       :class="{'is-invalid':errors.latitude}"
                                       placeholder="First name" v-model="markers[0].position.lat"
                                       @keyup="handleCoordinateChange">
                                <div class="invalid-feedback" v-if="errors.latitude">
                                    {{errors.latitude[0]}}
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label>Longitude</label>
                                <input type="text" class="form-control"
                                       :class="{'is-invalid':errors.longitude}"
                                       placeholder="First name" v-model="markers[0].position.lng"
                                       @keyup="handleCoordinateChange">
                                <div class="invalid-feedback" v-if="errors.longitude">
                                    {{errors.longitude[0]}}
                                </div>
                            </div>
                            <gmap-map
                                :center="center"
                                :zoom="15"
                                id="map">
                                <gmap-marker
                                    :key="index"
                                    v-for="(m, index) in markers"
                                    :position="m.position"
                                    :draggable="true"
                                    @dragend="updateCoordinates"
                                ></gmap-marker>
                            </gmap-map>
                            <div class="col-12 col-md-12 mb-3">
                                <label>Street</label>
                                <input type="text" class="form-control"
                                       :class="{'is-invalid':errors.street}"
                                       placeholder="Street"
                                       v-model="form.street">
                                <div class="invalid-feedback" v-if="errors.street">
                                    {{errors.street[0]}}
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label>Photo</label>
                                <input type="file" @change="handleFileUpload">
                                <div class="invalid-feedback" v-if="errors.photo">
                                    {{errors.photo[0]}}
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <img :src="form.photoPath" v-if="form.photoPath"/>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label>Open At</label>
                                <select v-model="form.open_at" class="form-control"
                                        :class="{'is-invalid':errors.open_at}">
                                    <option value="">Full Day</option>
                                    <option v-for="hour in hours" :value="hour">{{hour}}</option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.open_at">
                                    {{errors.open_at[0]}}
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label>Close At</label>
                                <select v-model="form.close_at" class="form-control"
                                        :class="{'is-invalid':errors.close_at}">
                                    <option value="">Full Day</option>
                                    <option v-for="hour in hours" :value="hour">{{hour}}</option>
                                </select>
                                <div class="invalid-feedback" v-if="errors.close_at">
                                    {{errors.close_at[0]}}
                                </div>
                            </div>
                            <div class="col-12 col-md-12 mb-3" v-for="(fuel_type,index) in fuel_types">
                                <label>{{fuel_type.name}}</label>
                                <input type="number" v-model="fuel_types[index].price" placeholder="Price"
                                       class="form-control"
                                       :class="{'is-invalid':errors['fuel_types.'+index+'.price']}">
                                <div class="invalid-feedback"
                                     v-if="errors['fuel_types.'+index+'.price'] && errors['fuel_types.'+index+'.price'][0]">
                                    {{errors['fuel_types.'+index+'.price'] && errors['fuel_types.'+index+'.price'][0]}}
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" :disabled="loading">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </loginned-layout>
</template>

<script>
    import LoginnedLayout from '../layouts/LoginnedLayoutComponent'
    import {mapActions, mapGetters} from 'vuex'
    import {generateHours} from '../../helpers/hours';
    import {getImageBase64Code} from '../../helpers/upload';

    export default {
        components: {LoginnedLayout},
        data() {
            return {
                form: {
                    latitude: 40.0652158,
                    longitude: 43.9197151,
                    street: null,
                    open_at: '',
                    close_at: '',
                    photo: null,
                    photoPath: null
                },
                fuel_types: [],
                loading: false,
                errors: {},
                center: {
                    lat: 40.0652158,
                    lng: 43.9197151
                },
                markers: [{
                    position: {lat: 40.0652158, lng: 43.9197151}
                }],
                hours: [],
            }
        },
        mounted() {
            this.getFuelTypes().then(() => {
                this.fuel_types = this.fuelTypesGetter();
            });
            this.getStreet(this.center);
            this.$store.watch(this.streetGetter, street => {
                this.form.street = street;
            });
            this.hours = generateHours();
        },
        methods: {
            ...mapActions([
                'getStreet',
                'getFuelTypes',
                'createPlace'
            ]),
            ...mapGetters({
                streetGetter: 'getStreet',
                fuelTypesGetter: 'getFuelTypes'
            }),
            updateCoordinates(location) {
                this.form.latitude = location.latLng.lat();
                this.form.longitude = location.latLng.lng();
                this.markers[0].position.lat = this.form.latitude;
                this.markers[0].position.lng = this.form.longitude;
                this.center.lat = this.form.latitude;
                this.center.lng = this.form.longitude;
                this.getStreet(this.markers[0].position);
            },
            handleCoordinateChange() {
                this.markers[0].position.lat = isNaN(parseFloat(this.markers[0].position.lat)) ? 0 : parseFloat(this.markers[0].position.lat);
                this.markers[0].position.lng = isNaN(parseFloat(this.markers[0].position.lng)) ? 0 : parseFloat(this.markers[0].position.lng);
                this.form.latitude = parseFloat(this.markers[0].position.lat);
                this.form.longitude = parseFloat(this.markers[0].position.lng);
                this.center = this.markers[0].position;
                this.getStreet(this.center);
            },
            handleFileUpload(e) {
                let file = e.target.files[0];
                getImageBase64Code(file).then((code) => {
                    this.form.photo = code;
                    this.form.photoPath = code;
                });
            },
            handleSubmit() {
                this.loading = true;
                this.errors = {};
                this.form.fuel_types = this.fuel_types;
                this.createPlace({form: this.form}).then(() => {
                    this.loading = false;
                    this.$router.push('/places');
                }).catch((errors) => {
                    this.errors = errors;
                    this.loading = false;
                });
            }
        }
    }
</script>

<style scoped>
    #map {
        width: 100%;
        height: 400px;
    }
</style>
