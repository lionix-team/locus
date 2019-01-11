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
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </loginned-layout>
</template>

<script>
    import LoginnedLayout from '../layouts/LoginnedLayoutComponent'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        components: {LoginnedLayout},
        data() {
            return {
                id: this.$route.params['id'],
                form: {
                    latitude: 40.0652158,
                    longitude: 43.9197151,
                    street: null,
                    open_at: '',
                    close_at: '',
                    photo: null,
                    photoPath: null,
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
            this.getStreet(this.center);
            this.$store.watch(this.streetGetter, street => {
                this.form.street = street;
            });
            for (let i = 0; i <= 24; i++) {
                let hour = i + ':00';
                if (i < 10) {
                    hour = '0' + hour;
                }
                this.hours.push(hour);
            }
            this.getPlace({id: this.id}).then(() => {
                this.form = this.placeGetter();
                this.form.photo = "";
                this.center.lat = this.form.latitude;
                this.center.lng = this.form.longitude;
                this.markers[0].position.lat = this.form.latitude;
                this.markers[0].position.lng = this.form.longitude;
                this.getFuelTypes().then(() => {
                    this.fuel_types = this.fuelTypesGetter();
                    this.fuel_types.map((type, index) => {
                        let myType = this.form.fuel_types.find(function (item) {
                            return item.fuel_type_id === type.id;
                        });
                        if (myType) {
                            this.fuel_types[index].price = myType.price;
                        }
                    });
                });
            });
        },
        methods: {
            ...mapActions([
                'getStreet',
                'getFuelTypes',
                'getPlace',
                'editPlace'
            ]),
            ...mapGetters({
                streetGetter: 'getStreet',
                fuelTypesGetter: 'getFuelTypes',
                placeGetter: 'getPlace',
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
                let reader = new FileReader();
                let form = this.form;
                reader.addEventListener("load", function () {
                    if (file.type === 'image/jpg' || file.type === 'image/jpeg' || file.type === 'image/png') {
                        form.photo = reader.result;
                        form.photoPath = reader.result;
                    }
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            },
            handleSubmit() {
                this.loading = true;
                this.errors = {};
                this.form.fuel_types = this.fuel_types;
                this.editPlace({id: this.id, form: this.form}).then(() => {
                    this.loading = false;
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
