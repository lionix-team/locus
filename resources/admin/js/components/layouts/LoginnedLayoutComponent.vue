<template>
    <div class="main-block">
        <sidebar-component></sidebar-component>
        <!-- MAIN CONTENT
        ================================================== -->
        <div class="main-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10 col-xl-8">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import SidebarComponent from '../layouts/SidebarComponent'

    export default {
        components: {SidebarComponent}
    }
</script>
<style scoped>
    .main-block {
        width: 100%;
    }
</style>
