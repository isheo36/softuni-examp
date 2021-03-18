import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isLoggedIn: !!localStorage.getItem('token'),
        user: {}
    },
    mutations: {
        loginUser (state, user) {
            state.isLoggedIn = true
            state.user = user
        },
        logoutUser (state) {
            state.isLoggedIn = false
        },
    },
    getters: {
        getUser: state => state.user,
    }
})
