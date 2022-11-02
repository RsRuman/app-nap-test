<template>
    <nav class="p-4 bg-red-500 rounded">
        <router-link class="p-2 rounded text-white" :to="{name : 'home' }">Home</router-link>
        <router-link class="p-2 rounded text-white" :to="{name : 'product' }">Product</router-link>
        <button @click.prevent="logout" class="p-2 rounded text-white">Logout </button>
    </nav>
</template>

<script>
import router from "../Router/router";

export default {
    name: "AuthLayout",

    methods: {
        logout(){
            this.$store.commit('SET_USER', {});
            this.$store.commit('SET_AUTHENTICATED', false);
            this.$store.commit('SET_AUTHORIZATION', '');
            router.push('/login');
        }
    }
}
</script>

<style scoped>

</style>
