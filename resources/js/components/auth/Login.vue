<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">

        </form>
    </div>
</template>

<script>
export default {
    methods: {
        login() {
            // Add your login logic here
            console.log('Login method called');
        }
    }
}
</script>