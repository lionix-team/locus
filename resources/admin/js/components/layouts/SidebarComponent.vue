<template>
        <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light" id="sidebar">
            <div class="container-fluid">

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse"
                        aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="index-2.html">
                    <img src="/assets/admin/img/logo.svg" class="navbar-brand-img
            mx-auto" alt="...">
                </a>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidebarCollapse">

                    <!-- Navigation -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <router-link to="/gas-stations" class="nav-link">Gas Stations</router-link>
                        </li>
                    </ul>


                </div> <!-- / .navbar-collapse -->

            </div>
        </nav>
</template>
