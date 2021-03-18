<template>
    <div>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;" v-bind:class=" { 'navbarOpen': show }">
            <a class="navbar-brand" v-if="isLogged" href="#"><i class="fas fa-user"> {{username}}</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                aria-expanded="false" aria-label="Toggle navigation" @click.stop="toggleNavbar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" v-bind:class="{ 'show': show }">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link :to="{ name: 'addreport' }" class="nav-link"><i class="fas fa-file-medical"> Add Report</i></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'patients' }" class="nav-link"><i class="fas fa-hospital-user"> Patients</i></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'hello' }" class="nav-link">Other Test</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'users.index' }" class="nav-link"><i class="fas fa-users"> Users</i></router-link>
                    </li>
                    <li class="nav-item" v-if="isLogged">
                        <router-link :to="{ name: 'logout' }" class="nav-link"><i class="fas fa-sign-out-alt"> Logout</i></router-link>
                    </li>

                    <li class="nav-item" v-if="isLogged === false">
                        <router-link :to="{ name: 'login' }" class="nav-link"><i class="fas fa-sign-in-alt"> Login</i></router-link>
                    </li>

                    <li class="nav-item" v-if="isLogged === false">
                        <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="container-fluid" style="margin-top: 60px;" @click="hideNavbar">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            username: '',
            show: false,
        }
    },
    created() {
        if(localStorage.token) {
            axios.get('/api/auth/user', {
                headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            },
            ).then(response => {
                let user = response.data
                this.username = user.name
                this.$store.commit('loginUser', user)
            }).catch(error => {
                if (error.response.status === 401 || error.response.status === 403) {
                    this.$store.commit('logoutUser')
                    localStorage.setItem('token', '')
                    this.$router.push({name: 'login'})
                }
            });
        }
    },
    methods: {
        toggleNavbar() {
            this.show = !this.show
        },
        hideNavbar() {
            this.show = false
        },
    },
    computed: {
        isLogged () {
            return this.$store.state.isLoggedIn
        },
    }
}
</script>

<style scoped>
    .navbar-brand i {
        color: rgb(36, 160, 237);
    }
    .nav-item i {
        color: rgb(36, 160, 237);
    }

    .nav-item i:hover {
        color:rgb(34, 125, 199);
    }
</style>