import Vue from 'vue';
import VueRouter from 'vue-router';
import Index from './views/Index';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'Index',
            component: Index
        },
        {
            path: '/acts',
            name: 'Acts',
            component: () => import('./views/Acts')
        },
        {
            path: '/acts-search',
            name: 'Acts Search',
            component: () => import('./views/ActsSearch')
        },
        {
            path: '/acts-history',
            name: 'Acts History',
            component: () => import('./views/ActsHistory')
        },
        {
            path: '/users',
            name: 'Users',
            component: () => import('./views/Users')
        },
        {
            path: '/sellers',
            name: 'Sellers',
            component: () => import('./views/Sellers')
        },
        {
            path: '/drivers-statistics',
            name: 'Drivers Statistics',
            component: () => import('./views/DriverStatistics')
        },
        {
            path: '/cities',
            name: 'Cities',
            component: () => import('./views/Cities')
        },
        {
            path: '/districts',
            name: 'Districts',
            component: () => import('./views/Districts')
        },
        {
            path: '/streets',
            name: 'Streets',
            component: () => import('./views/Streets')
        },
        {
            path: '/villages',
            name: 'Villages',
            component: () => import('./views/Villages')
        }
    ]
});

export default router;
