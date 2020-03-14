import Vue from 'vue';
import VueRouter from 'vue-router';
import Index from './views/Index';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'Главная',
            component: Index
        },
        {
            path: '/acts',
            name: 'Acts',
            component: () => import('./views/Acts')
        },
        {
            path: '/users',
            name: 'Users',
            component: () => import('./views/Users')
        }
    ]
});

export default router;
