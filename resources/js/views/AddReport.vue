
<template>
  <div>
      <h3 class="pt-2 pl-5"><i class="fas fa-file-medical"> Patient Details</i></h3>
      <div class="form-wrapper">
        <form @submit.prevent="onSubmit($event)" autocomplete="off">
            <div class="form-group row" v-if="message !== null">
                <div  class="alert col-sm-3 offset-sm-1" v-bind:class="{ 'alert-danger': hasError, 'alert-success': success }" role="alert">
                    {{ message }}
                </div>
            </div>
            <div class="form-group row">
                <label for="id_number" class="col-sm-2 col-form-label">ID Number</label>
                <div class="col-sm-2">
                    <input id="id_number" class="form-control" v-model="patient.idnumber" required autofocus />
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.idnumber">
                    {{ errors.idnumber[0].replace("idnumber", "ID Number") }}
                </div>
            </div>

            <div class="form-group row">
                <label for="passport_number" class="col-sm-2 col-form-label">Pasport Number</label>
                <div class="col-sm-2 ">
                    <input id="passport_number" class="form-control" v-model="patient.passportnumber" required/>
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.passportnumber">
                    {{ errors.passportnumber[0].replace("passportnumber", "Pasport Number") }}
                </div>
            </div>

            <div class="form-group row">
                <label for="patient_firstname" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-2">
                    <input id="patient_firstname" class="form-control" v-model="patient.firstname" required/>
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.firstname">
                    {{ errors.firstname[0].replace("firstname", "First Name")  }}
                </div>
            </div>

            <div class="form-group row">
                <label for="patient_surname" class="col-sm-2 col-form-label">Surname</label>

                <div class="col-sm-2">
                    <input id="patient_firstname" class="form-control" v-model="patient.surname" required/>
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.surname">
                    {{ errors.surname[0].replace("surname", "Surname")  }}
                </div>
            </div>

            <div class="form-group row">
                <label for="patient_street_address" class="col-sm-2 col-form-label">Street address</label>

                <div class="col-sm-2">
                    <input id="patient_street_address" class="form-control" v-model="patient.streetaddress" required/>
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.streetaddress">
                    {{ errors.streetaddress[0].replace("streetaddress", "Street address")  }}
                </div>
            </div>

            <div class="form-group row">
                <label for="patient_city" class="col-sm-2 col-form-label">City</label>

                <div class="col-sm-2">
                    <input id="patient_city" class="form-control" v-model="patient.city" required/>
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.city">
                    {{ errors.city[0].replace("city", "City")  }}
                </div>
            </div>

            <div class="form-group row">
                <label for="patient_province" class="col-sm-2 col-form-label">Province</label>
                
                <div class="col-sm-2">
                    <input id="patient_province" class="form-control" v-model="patient.province" required/>
                </div>
                <div class="col-sm-8 float-left text-danger" v-if="errors.province">
                    {{ errors.province[0].replace("province", "Province")  }}
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-2">
                    <button :disabled="saving" type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{action}}</button>
                </div>
            </div>
        </form>
        <vacinereport v-if="patient.id" v-bind:id="patient.id"></vacinereport>
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import vacinereport from './VacineForm';
export default {
    components: {
        vacinereport
    },
    data() {
        return {
            saving: false,
            message: null,
            action: "Create",
            errors: {},
            hasError: false,
            success: false,
            patient: {
                id: null,
                idnumber: "",
                passportnumber: "",
                firstname: "",
                surname: "",
                streetaddress: "",
                city: "",
                province: "",
            }
        }
    },
    methods: {
        onSubmit(event) {
            this.saving = true
            this.errors = {}
            this.hasError = false
            this.success = false
            this.message = null
            if( this.patient.id === null){
                let postdata = this.patient
                axios.post('/api/patient/add', postdata,
                {
                    headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                })
                .then((response) => {
                    this.message = 'Patient Created';
                    this.success = true;
                    setTimeout(() => this.message = null, 2000);
                    this.patient = response.data.data;
                    this.action = "Update";
                }).catch(error => {
                    this.hasError = true;
                    if (error.response) {
                        this.errors = error.response.data.errors;
                        this.message = error.response.data.message;
                        setTimeout(() => this.message = null, 2000);
                    }else{
                        this.message = 'Network error, please try again!!!';
                    }
                }).then(_ => this.saving = false);
            }else{
                let id = this.patient.id;
                let patient = this.patient;
                axios.put(`/api/patient/${id}`, patient,
                {
                    headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                    },
                    
                })
                .then((response) => {
                    this.message = 'Patient Update';
                    this.success = true;
                    setTimeout(() => this.message = null, 2000);
                    this.patient = response.data.data;
                }).catch(error => {
                    this.hasError = true;
                    if (error.response) {
                        this.errors = error.response.data.errors;
                        this.message = error.response.data.message;
                        setTimeout(() => this.message = null, 2000);
                    }else{
                        this.message = 'Network error, please try again!!!';
                    }
                }).then(_ => this.saving = false);
            }
        },
    },
}
</script>
<style scoped>

.form-group {
    margin-bottom: 5px;
}

.form-group input[type="text"] {
    width: 100%;
}

h3{
    color: rgb(36, 160, 237);
}

</style>