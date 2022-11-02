

const state = {

};

const getters = {

};

const actions = {
    async storeProduct({commit, rootState }, formData){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + rootState.auth.authenticated;
        return await axios.post('api/products/store', formData,)
            .then((response) => {
                if (response.data.status === 200){

                }

                if (response.data.status === 406){
                    commit('setValidationError', response.data.errors);
                }

                return response;
            })
    }
};

const mutations = {

};


export default {
    state,
    getters,
    actions,
    mutations,
};
