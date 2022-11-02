<template>
    <general-layout v-if="!authenticated"></general-layout>
    <auth-layout v-else></auth-layout>
    <router-view></router-view>
</template>

<script>
import GeneralLayout from "../Layout/GeneralLayout.vue";
import AuthLayout from "../Layout/AuthLayout.vue";
import {mapGetters} from "vuex";
    export default {
        components: {
            GeneralLayout,
            AuthLayout
        },

        computed: {
            ...mapGetters([
                'authenticated',
                'user',
            ])
        }
    }
</script>
