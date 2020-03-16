<template>
    <div class="p-2">
        <Menu class="sticky-top fixed-m-top pb-2" />
        <div class="bg-white p-3">
            <router-view />
        </div>
        <Footer />
        <Notifications />
    </div>
</template>

<script>
import Menu from './Menu'
import Footer from './Footer'
import Notifications from './Notifications'

export default {
    components: {
        Menu,
        Footer,
        Notifications
    },

    computed: {
        authUser() {
            return this.$store.getters['users/authUser'] || []
        },
    },

    beforeMount() {
        this.$store.dispatch('users/getAuthUser');
    }
}
</script>

<style>
    .bg-filter {
        background: #eeeeee;
    }
</style>
