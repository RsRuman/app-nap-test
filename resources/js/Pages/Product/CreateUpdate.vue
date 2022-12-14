<template>
    <div class="flex justify-center mt-8">
        <form @submit.prevent="submit" class="rounded-lg shadow-xl bg-gray-50 lg:w-1/2">
            <div class="m-4">
                <label for="name" class="inline-block mb-2 text-gray-500">
                    Product Name</label>
                <input
                    v-model="form.name"
                    type="text" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                <div v-if="validationMessage.hasOwnProperty('name')" class="px-2 text-red-500">{{ validationMessage.name[0] }}</div>
            </div>

            <div class="m-4">
                <label for="price" class="inline-block mb-2 text-gray-500">
                    Product Price
                </label>
                <input
                    v-model="form.price"
                    type="number"
                    min="0"
                    step="0.01"
                    placeholder="0.00"
                    id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                <div v-if="validationMessage.hasOwnProperty('price')" class="px-2 text-red-500">{{ validationMessage.price[0] }}</div>
            </div>

            <div class="m-4">
                <label for="categories" class="inline-block mb-2 text-gray-500">
                    Product Categories
                </label>
                <VueMultiselect
                    id="categories"
                    v-model="form.categories"
                    :options="options"
                    :multiple="true"
                    :close-on-select="true"
                    placeholder="Pick Categories"
                    label="name"
                    track-by="name"/>
                <div v-if="validationMessage.hasOwnProperty('categories')" class="px-2 text-red-500">{{ validationMessage.categories[0] }}</div>
            </div>

            <div class="m-4">
                <label class="inline-block mb-2 text-gray-500">Upload
                    Image(jpg,png,svg,jpeg)
                </label>
                <div class="flex items-center justify-center w-full">
                    <label
                        class="flex flex-col w-full h-32 border-4 border-dashed hover:bg-gray-100 hover:border-gray-300">
                        <div class="flex flex-col items-center justify-center pt-7">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-12 h-12 text-gray-400 group-hover:text-gray-600" viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-gray-600">
                                Select a photo</p>
                        </div>
                        <input @change="onChange($event)" type="file" multiple class="opacity-0"/>
                    </label>
                    <div v-if="validationMessage.hasOwnProperty('image')" class="px-2 text-red-500">{{ validationMessage.image[0] }}</div>
                </div>
            </div>

            <div class="m-4">
                <label for="details" class="inline-block mb-2 text-gray-500">
                    Product Details</label>
                <textarea v-model="form.details"
                          id="details"
                          class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg
                           focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700
                           dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                </textarea>
                <div v-if="validationMessage.hasOwnProperty('details')" class="px-2 text-red-500">{{ validationMessage.details[0] }}</div>
            </div>

            <div class="m-4" v-if="previewImageUrls.length > 0">
                <div class="flex items-center w-full">
                    <img class="h-20 p-2 border border-gray-300 m-1" v-for="(previewImageUrl, iIdx) in previewImageUrls" :key="'productImage'+iIdx" :src="previewImageUrl" width="100" height="100"  alt="image_preview"/>
                </div>
            </div>

            <div class="flex p-2 space-x-4">
                <button class="px-4 py-2 text-white bg-red-500 rounded shadow-xl">Cancel</button>
                <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded shadow-xl">Submit</button>
            </div>
        </form>
    </div>
</template>

<script>
import VueMultiselect from 'vue-multiselect';
import {mapActions, mapGetters} from "vuex";

export default {
    name: "CreateUpdateProduct",
    components: {
        VueMultiselect
    },

    data() {
        return {
            form: {
                slug: '',
                name: '',
                price:'',
                categories:[],
                details:'',
                images:[]
            },
            options: [],

            previewImageUrls: [],

            validationMessage:{}
        }
    },

    mounted() {
        this.fetchCategories();
        if (this.$route.params.slug){
            this.fetchProduct(this.$route.params.slug);
        }
    },

    methods: {
        ...mapActions([
            'storeProduct',
            'updateProduct',
            'getCategories',
            'getProduct'
        ]),

        //Fetch Product Categories
        async fetchCategories(){
            return await this.getCategories().then(() => {
                this.options = this.productCategories;
            });
        },

        //Fetch Product
        async fetchProduct(slug){
            return await this.getProduct(slug).then(() => {
                this.form.slug = this.productDetail.slug;
                this.form.name = this.productDetail.name;
                this.form.price = this.productDetail.price;
                this.form.categories = this.productDetail.categories;
                this.form.details = this.productDetail.details;
                this.previewImageUrls = Object.keys(this.productDetail).length > 0 ? this.productDetail.images.map((item) => item.imagePath) : [];
            });
        },

        //On select images
        onChange(e){
            for (let i=0; i<e.target.files.length; i++){
                this.form.images.push(e.target.files[i]);
                this.previewImageUrls.push(URL.createObjectURL(e.target.files[i]));
            }
        },

        //Store product
        async submit(){
            let data = new FormData();
            data.append('name', this.form.name);
            data.append('price', this.form.price);
            data.append('details', this.form.details);

            if (this.form.categories.length > 0){
                for (let i = 0; i < this.form.categories.length; i++) {
                    data.append('categories[]', this.form.categories[i].id);
                }
            }

            if (this.form.images.length > 0){
                for(let i=0; i<this.form.images.length; i++){
                    data.append('images[]', this.form.images[i]);
                }
            }

            if (this.form.slug === ''){
                return await this.storeProduct(data)
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
            } else {
                data.append('_method', 'PUT');
                const productObject = {
                    'slug' : this.form.slug,
                    'product' : data
                };
                return await this.updateProduct(productObject)
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


        }
    },

    computed: {
        ...mapGetters([
            'user',
            'authenticated',
            'productCategories',
            'productDetail',
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

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<style scoped>

</style>
