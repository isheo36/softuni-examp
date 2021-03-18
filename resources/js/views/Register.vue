<template>
    <div class="text-center form-wrapper">

        <form class="form-signin" v-on:submit.prevent="submitLogin">
            <h1 class="h3 mb-3 font-weight-normal">Register</h1>
            
            <label for="inputName" class="sr-only">Name</label>
            <input type="text" id="inputName" class="form-control" placeholder="Names" required autofocus v-model="user.name">
            <div class="text-danger" v-if="errors.name">
                {{ errors.name[0].replace("name", "Names") }}
            </div>

            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required v-model="user.email">
            <div class="text-danger" v-if="errors.email">
                {{ errors.email[0].replace("email", "Email address") }}
            </div>

            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required v-model="user.password">
            <div class="text-danger" v-if="errors.password">
                {{ errors.password[0].replace("password", "Password") }}
            </div>

            <label for="inputRePassword" class="sr-only">Retype Password</label>
            <input type="password" id="inputRePassword" class="form-control" placeholder="Retype Password" required v-model="user.repassword">
            <div class="text-danger" v-if="errors.repassword">
                {{ errors.repassword[0].replace("repassword", "Retype Password") }}
            </div>

            <button class="btn btn-lg btn-primary btn-block" type="submit" :disabled='isDisabled'>Register</button>
        </form>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    repassword: '',
                },
                errors: {},
                formisok: false,
                isDisabled: true,
            }
        },
        methods: {
            submitLogin() {
                axios.post('/api/auth/register', this.user)
                .then(response => {
                    this.$store.commit('loginUser', { 'name': this.user.name } )
                    localStorage.setItem('token', response.data.access_token)
                    this.$router.push({ name: 'patients' })
                }).catch(error => {
                    this.errors = error.response.data.errors
                });
            }
        },
        watch: {
            repassword(val) {
                if( this.user.password !== val ){
                    console.log(val.repassword);
                    this.errors.repassword = [];
                    this.errors.repassword[0] = "Passwords must be equal";
                }else{
                    delete this.errors.repassword;
                    this.isDisabled = false;
                }
            }
        },
        computed: {
            repassword() {
                return this.user.repassword;
            }
        }
    }
</script>

<style scoped>
    .form-wrapper {
        min-height: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="text"] {
        margin-bottom: -1px;

        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;

    }

    .form-signin input[type="email"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }


    .form-signin input[type="password"] {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .form-signin button[type="submit"] {
        margin-top: 10px;
    }
</style>