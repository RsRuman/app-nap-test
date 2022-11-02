import { createRouter, createWebHistory } from "vue-router";
import Login from "../Pages/Login.vue";
import Register from "../Pages/Register.vue";
import store from "../Store/store";
import Home from "../Home.vue";



const Product = () => import('../Pages/Product.vue')


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
        path: '/product',
        component: Product,
        name: 'product',
        meta:{
            middleware:"auth",
            title:'Product'
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
