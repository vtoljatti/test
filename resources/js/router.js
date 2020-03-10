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
            path: '/readme',
            name: 'Readme',
            component: () => import('./views/Readme')
        }
    ]
});

export default router;
