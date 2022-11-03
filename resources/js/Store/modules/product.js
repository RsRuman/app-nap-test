import router from "../../Router/router";

const state = {
    categories: [],
    products: [],
};

const getters = {
    productCategories(state){
        return state.categories;
    },

    productList(state){
        return state.products;
    }
};

const actions = {
    //Get product categories
    async getCategories({commit, rootState}){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.get('api/categories')
            .then((response) => {
                if (response.data.status === 200){
                    commit('setCategories',response.data.data)
                }
            })
    },

    //Get products
    async getProducts({commit, rootState}){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.get('api/products')
            .then((response) => {
                if (response.data.status === 200){
                    commit('setProducts',response.data.data)
                }
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
    }
};

const mutations = {
    setCategories (state, value) {
        state.categories = value;
    },

    setProducts (state, value) {
        state.products = value;
    },

    addProduct (state, value) {
        state.products.unshift(value);
    }
};

export default {
    state,
    getters,
    actions,
    mutations,
};
