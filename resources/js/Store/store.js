import { createStore } from "vuex";
import auth from './modules/auth.js'
import index from './modules/index.js'
import product from './modules/product.js'
import createPersistedState from 'vuex-persistedstate'
const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules: {
        auth,
        index,
        product
    }
});

export default store;
