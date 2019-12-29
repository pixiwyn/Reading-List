<template>
    <div class="app-wrapper">
        <div class="row mt-2">
            <div class="col-sm-4">
                <h1>Reading List</h1>
            </div>
            <div class="col-sm-8">
                <nav>
                    <ul class="nav justify-content-end">
                        <li v-if="!$auth.check()" class="nav-item">
                            <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                        </li>
                        <li v-if="!$auth.check()" class="nav-item">
                            <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                        </li>
                        <li v-if="$auth.check()" class="nav-item">
                            <router-link :to="{ name: 'list' }" class="nav-link">List</router-link>
                        </li>
                        <li v-if="$auth.check()" class="nav-item">
                            <router-link :to="{ name: 'search' }" class="nav-link">Search</router-link>
                        </li>
                        <li v-if="$auth.check()" class="nav-item">
                            <a href="#" @click.prevent="$auth.logout()" class="nav-link">Logout</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <hr class="mt-0">
            </div>
        </div>
        <div class="">
            <router-view></router-view>
        </div>
    </div>
</template>
