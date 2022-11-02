<template>
    <h1>Home</h1>
</template>

<script>
import GeneralLayout from "./Layout/GeneralLayout.vue";
import AuthLayout from "./Layout/AuthLayout.vue";
import {mapGetters} from "vuex";

export default {
    name: "Home",
    components: {
        AuthLayout,
        GeneralLayout
    },

    computed: {
        ...mapGetters([
            'authenticated'
        ])
    }

}
</script>

<style scoped>

</style>
