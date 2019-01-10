<template>
    <guest-layout>
        <h1 class="display-4 text-center mb-3">
            Sign in
        </h1>
        <p class="text-muted text-center mb-5">
            Locus
        </p>
        <form v-on:submit.prevent="signIn">
            <div class="alert alert-danger alert-dismissible" role="alert" v-if="error">
                <strong>Wrong E-mail or Password</strong>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="E-mail" v-model="form.email">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Password</label>
                    </div>
                </div>
                <div class="input-group input-group-merge">
                    <input type="password" class="form-control form-control-appended" placeholder="Password"
                           v-model="form.password">
                    <div class="input-group-append">
                          <span class="input-group-text">
                            <EyeIcon/>
                          </span>
                    </div>
                </div>
            </div>
            <button class="btn btn-lg btn-block btn-primary mb-3" :disabled="loading">
                Sign in
            </button>
        </form>
    </guest-layout>
</template>

<script>
    import GuestLayout from '../layouts/GuestLayoutComponent'
    import {EyeIcon} from 'vue-feather-icons'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        components: {GuestLayout, EyeIcon},
        data() {
            return {
                form: {
                    email: null,
                    password: null
                },
                error: false,
                loading: false
            }
        },
        methods: {
            ...mapActions([
                'login'
            ]),
            ...mapGetters([
                'getUser'
            ]),
            signIn() {
                this.error = false;
                this.login({form: this.form}).then((res) => {
                    this.loading = false;
                    localStorage.setItem('locus_token', res.access_token);
                }).catch(() => {
                    this.error = true;
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
