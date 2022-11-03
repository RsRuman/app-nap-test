<template>
    <div class="md:container md:mx-auto">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-center p-4 text-lg font-bold text-gray-500">Products Table</h1>
            <router-link class="text-center px-4 py-2 rounded bg-red-500 text-white" :to="{name : 'product_create' }">Create Product</router-link>
        </div>
        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full border text-center">

                            <thead class="border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                    #
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                    Name
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 border-r">
                                    Categories
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                                    Images
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                                    Status
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                                    Action
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr class="border-b" v-for="(product, pIdx) in productList" :key="'product'+pIdx">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r">{{ pIdx+1 }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">{{ product.name }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                    <span v-for="(category, cIdx) in product.categories" :key="'category'+cIdx" class="px-2 py-1 rounded bg-gray-500 text-white mx-1">{{ category.name }}</span>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-4 py-2 whitespace-nowrap border-r">
                                    <span class="flex items-center justify-center w-full">
                                        <img class="h-10 w-10 border border-gray-300 m-1"
                                             v-if="product.images.length > 0" v-for="(image, iIdx) in product.images" :key="'image'+iIdx"
                                             :src="image.imagePath"
                                             width="50"
                                             height="50"
                                             alt="image_preview"/>
                                    </span>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">{{ product.statusLabel }}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap border-r">
                                    <span>
                                        <router-link class="px-2 py-1 m-1 bg-green-500 text-white rounded cursor-pointer" :to="{name : 'product_show', params: { slug: product.slug } }">Show</router-link>
                                        <router-link class="px-2 py-1 m-1 bg-blue-500 text-white rounded cursor-pointer" :to="{name : 'product_update', params: { slug: product.slug } }">Edit</router-link>
                                        <router-link class="px-2 py-1 m-1 bg-red-500 text-white rounded cursor-pointer" :to="{name : 'product_show', params: { slug: product.slug } }">Delete</router-link>
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Product",

    mounted() {
        this.fetchProducts();
    },

    methods: {
        ...mapActions([
            'getProducts',
        ]),


        async fetchProducts(){
            return await this.getProducts().then(() => {
                console.log(this.productList);
            });
        }
    },

    computed: {
        ...mapGetters([
            'user',
            'authenticated',
            'productList',
        ])
    }
}

</script>

<style scoped>

</style>
