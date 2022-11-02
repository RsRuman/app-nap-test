<template>
    <nav class="p-4 bg-red-500 rounded">
        <router-link class="p-2 rounded text-white" :to="{name : 'home' }">Home</router-link>
        <router-link class="p-2 rounded text-white" :to="{name :'login' }">Login </router-link>
        <router-link class="p-2 rounded text-white" :to="{name : 'register' }">Register</router-link>

    </nav>
</template>

<script>

export default {
    name: "GeneralLayout",
}
</script>

<style scoped>

</style>
