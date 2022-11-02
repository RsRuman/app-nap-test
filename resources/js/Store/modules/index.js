const state = {
    validation_error:{}
};

const getters = {
    validationError(state){
        return state.validation_error;
    }
};

const actions = {

};

const mutations = {
    setValidationError (state, value) {
        state.validation_error = value;
    }
};


export default {
    state,
    getters,
    actions,
    mutations,
};
