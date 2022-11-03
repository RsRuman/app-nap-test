<template>
    <section class="bg-gray-500 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                       Login Here
                    </h1>
                    <form class="space-y-4 md:space-y-6">

                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                email</label>
                            <input
                                v-model="form.email"
                                type="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" required="">
                            <div v-if="validationMessage.hasOwnProperty('email')" class="px-2 text-red-500">{{ validationMessage.email[0] }}</div>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input
                                v-model="form.password"
                                type="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="">
                            <div v-if="validationMessage.hasOwnProperty('password')" class="px-2 text-red-500">{{ validationMessage.password[0] }}</div>
                        </div>

                        <button
                            @click.prevent="submit"
                            type="submit"
                            class="w-full text-white bg-red-500 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Login
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Login",
    components: {
    },

    data(){
        return {
            form: {
                email: '',
                password: '',
            },

            validationMessage: {}
        }
    },

    methods: {
        ...mapActions([
            'login'
        ]),

        async submit(){
            return await this.login(this.form)
                .then((response) => {
                    if (response.data.status === 200){
                        this.$swal({
                            position: 'center',
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                    if (response.data.status === 406){
                        this.$swal({
                            position: 'center',
                            icon: 'error',
                            title: 'Please provide valid data',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                    if (response.data.status === 400){
                        this.$swal({
                            position: 'center',
                            icon: 'error',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
        }
    },

    computed: {
        ...mapGetters([
            'validationError'
        ]),

        checkValidationError(){
            return JSON.parse(JSON.stringify(this.validationError));
        }
    },

    watch: {
        checkValidationError: {
            handler: function handler(newVal, oldVal){
                if (newVal !== oldVal){
                    this.validationMessage = this.validationError;
                }
            },
            deep: true
        }
    }

}
</script>

<style scoped>

</style>
