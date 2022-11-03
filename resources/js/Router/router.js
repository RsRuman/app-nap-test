import { createRouter, createWebHistory } from "vue-router";
import Login from "../Pages/Auth/Login.vue";
import Register from "../Pages/Auth/Register.vue";
import store from "../Store/store";
import Home from "../Home.vue";



const Product = () => import('../Pages/Product/Index.vue');
const ProductShow = () => import('../Pages/Product/Show.vue');
const ProductCreate = () => import('../Pages/Product/CreateUpdate.vue');


const routes = [
    {
        path: '/',
        component: Home,
        name: 'home',
    },

    {
        path: '/login',
        component: Login,
        name: 'login',
        meta:{
            middleware:"guest",
            title:'Login'
        }
    },

    {
        path: '/register',
        component: Register,
        name: 'register',
        meta:{
            middleware:"guest",
            title:'Register'
        }
    },

    {
        path: '/products',
        component: Product,
        name: 'product',
        meta:{
            middleware:"auth",
            title:'Product'
        }
    },

    {
        path: '/products/:slug/show',
        component: ProductShow,
        name: 'product_show',
        meta:{
            middleware:"auth",
            title:'ProductShow'
        }
    },

    {
        path: '/products/create',
        component: ProductCreate,
        name: 'product_create',
        meta:{
            middleware:"auth",
            title:'ProductCreate'
        }
    }
]

const router = createRouter({
    history : createWebHistory(),
    routes: routes
})

router.beforeEach((to, from, next) => {
    if(to.meta.middleware === "guest"){
        if(store.state.auth.authenticated){
            next({name:"dashboard"})
        } else{
            next()
        }
    }else{
        if(store.state.auth.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router;
