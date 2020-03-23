<template>
    <div class="p-2">
        <Menu class="sticky-top fixed-m-top pb-2" />
        <router-view />
        <Footer />
        <Notifications />
    </div>
</template>

<script>
import Menu from './Menu'
import Footer from './Footer'
import Page401 from '../views/401'
import Notifications from './Notifications'

export default {
    components: {
        Menu,
        Footer,
        Notifications,
        Page401
    }
}
</script>

<style>
    .bg-filter {
        background: #eeeeee;
    }
    .hover {
        opacity: 0.8;
    }
    .hover:hover {
        opacity: 1;
        cursor: pointer;
    }
</style>
