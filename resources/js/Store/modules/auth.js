import router from "../../Router/router";

const state = {
    authenticated:false,
    user:{}
};

const getters = {
    authenticated(state){
        return state.authenticated
    },
    user(state){
        return state.user
    }
};

const actions = {
    async login({state,commit}, formData){
        return await axios.post('api/login', formData)
            .then((response) => {
                if (response.data.status === 200){
                    commit('SET_USER', response.data.data.user);
                    commit('SET_AUTHENTICATED', response.data.data.token);
                    router.push('/');
                }

                if (response.data.status === 406){
                    console.log(response)
                    commit('setValidationError', response.data.errors);
                }

                return response;
            })
    },

    async register({commit}, formData){
        return await axios.post('api/register', formData)
            .then((response) => {
                if (response.data.status === 200){
                    router.push('/login');
                }

                if (response.data.status === 406){
                    commit('setValidationError', response.data.errors);
                }

                return response;
            })
    }
};

const mutations = {
    SET_AUTHENTICATED (state, value) {
        state.authenticated = value
    },

    SET_USER (state, value) {
        state.user = value
    }
};


export default {
    state,
    getters,
    actions,
    mutations,
};
