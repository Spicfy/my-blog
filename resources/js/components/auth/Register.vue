<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <input type="text" v-model="formData.first_name" placeholder="First Name"  />
            <input type="text" v-model="formData.last_name" placeholder = "Last Name" />
            <input type="text"v-model="formData.address" placeholder="Address" />
            <input type="email" v-model="formData.email" placeholder="Email" />
            <input type="password" v-model="formData.password" placeholder="Password" />
            <input type="password" v-model="formData.password_confirmation" placeholder="Confirm Password"/>
            <button type="submit">Register</button>
            <div v-if="error">{{ error }}</div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return {
                formData:{
                    first_name: '',
                    last_name: '',
                    address: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error: ''
            }
        },
        methods:{
            register(){
                axios.post('/api/register', this.formData)
                    .then(response => {
                        alert('Registration successful');
                        // Redirect to login page
                    })
                    .catch(error => {
                        if(error.response && error.response.data && error.response.data.errors){
                            const errors = error.response.data.errors;
                            alert(Object.values(errors).flat().join('\n'));
                        }else{
                            alert('An error occurred. Please try again');
                        }
                    });
            }
        },
    };

</script>