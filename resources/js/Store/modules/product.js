import router from "../../Router/router";

const state = {
    categories: [],
    products: [],
    product: {},
};

const getters = {
    productCategories(state){
        return state.categories;
    },

    productList(state){
        return state.products;
    },

    productDetail(state){
        return state.product;
    }
};

const actions = {
    //Get product categories
    async getCategories({commit, rootState}){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.get('api/categories')
            .then((response) => {
                if (response.data.status === 200){
                    commit('setCategories',response.data.data);
                }
            })
    },

    //Get products
    async getProducts({commit, rootState}){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.get('api/products')
            .then((response) => {
                if (response.data.status === 200){
                    commit('setProducts',response.data.data);
                }
            })
    },

    //Get product
    async getProduct({commit, rootState}, productSlug){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.get(`api/products/${productSlug}/show`)
            .then((response) => {
                if (response.data.status === 200){
                    commit('setProductDetail',response.data.data);
                }
            })
    },

    //Destroy product
    async destroyProduct({commit, rootState}, productSlug){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.delete(`api/products/${productSlug}/delete`)
            .then((response) => {
                if (response.data.status === 200){
                    commit('removeProduct',productSlug);
                }
                return response;
            })
    },

    //Store product
    async storeProduct({commit, rootState}, formData){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.post('api/products', formData,)
            .then((response) => {
                if (response.data.status === 200){
                    commit('addProduct', response.data.data);
                    router.push('/products');
                }

                if (response.data.status === 406){
                    commit('setValidationError', response.data.errors);
                }

                return response;
            })
    },

    //Update product
    async updateProduct({commit, rootState}, formData){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.post(`api/products/${formData.slug}/update`, formData.product)
            .then((response) => {
                if (response.data.status === 200){
                    commit('setUpdateProduct', response.data.data);
                    router.push('/products');
                }

                if (response.data.status === 406){
                    commit('setValidationError', response.data.errors);
                }

                return response;
            })
    }
};

const mutations = {
    setCategories (state, value) {
        state.categories = value;
    },

    setProducts (state, value) {
        state.products = value;
    },

    setProductDetail (state, value) {
        state.product = value;
    },

    addProduct (state, value) {
        state.products.unshift(value);
    },

    setUpdateProduct (state, value) {
        const index = state.products.map((item) => item.slug).indexOf(value.slug);
        if (index > -1){
            state.products.splice(index, 1, value);
        }
    },

    removeProduct (state, value) {
        const index = state.products.map((item) => item.slug).indexOf(value);
        if (index > -1){
            state.products.splice(index, 1);
        }
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
