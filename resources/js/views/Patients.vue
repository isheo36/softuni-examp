<template>
  <div>
    <h3>Patients</h3>
    <table v-if="patients" class="table table-sm">
      <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">PO NUMBER</th>
            <th scope="col">Names</th>
            <th scope="col">Created at</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="data in patients.data" :key="data.id">
            <th scope="row">{{ data.id }}</th>
            <td>{{ data.passportnumber }}</td>
            <td>{{ data.firstname }} {{ data.surname }}</td>
            <td>{{ data.created_at }}</td>
        </tr>
      </tbody>
    </table>
    <pagination :data="patients" @pagination-change-page="getResults"></pagination>
  </div>
</template>

<script>
import api from '../api/patients';

export default {
  data() {
        return {
          patients: {},
        }
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1) {
          axios.get('api/patients?page=' + page,
            {
                headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            },
          )
          .then(response => {
              this.patients = response.data;
              //console.log(this.patients);
          })
          .catch(error => {
                if (error.response.status === 401 || error.response.status === 403) {
                    this.$router.push({name: 'login'})
                }
            })
        },
        fetchData() {
          api.all().then((response) => {
            setTimeout(() => { 
                  this.loaded = true;
                  this.patients = response.data;
            }, 1000);
          });
        }
    },
}
</script>