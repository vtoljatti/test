<template>
    <div class="notifications">
        <b-alert
            v-for="notification in notifications"
            :key="notification.id"
            :variant="notification.variant"
            show
            class="notification border-light"
            :class="{notification_active: notification.isVisible}"
        >
            {{ notification.message }}
        </b-alert>
    </div>
</template>

<script>
export default {
    computed: {
        notifications() {
            return this.$store.getters['notifications/notifications'] || []
        }
    }
}
</script>

<style lang="scss">
.notifications {
    position: fixed;
    bottom: .1rem;
    right: .3rem;
    width: 300px;
    max-width: 100%;
    z-index: 1070;
}

.notification {
    margin: 0 0 .3rem 0;
    opacity: 0;
    transition: opacity 1s ease-out;

    &_active {
        opacity: 1;
    }
}
</style>
