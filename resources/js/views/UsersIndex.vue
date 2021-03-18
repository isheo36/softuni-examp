<template>
    <div class="users">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            <p> {{ error }}</p>
            <p>
                <button @click.prevent="fetchData">
                    Try Again
                </button>
            </p>
        </div>
        <table v-if="users" class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>
                        <router-link :to="{ name: 'users.edit', params: { id: user.id } }">Edit</router-link>
                    </td>
                </tr>
            </tbody>
        </table>
        <pagination :data="users" @pagination-change-page="getResults"></pagination>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: {},
            error: null,
            loading: false,
        };
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
          axios.get('api/users?page=' + page,
            {
                headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => {
              this.users = response.data;
            })
            .catch(error => {
                if (error.response.status === 401 || error.response.status === 403) {
                    this.$router.push({name: 'login'})
                }
            })
        }
    }
}
</script>
