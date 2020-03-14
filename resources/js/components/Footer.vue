<template>
    <div class="position-fixed fixed-bottom text-center bg-light">
        <small class="text-muted">
            © 2012-{{ year }} <a href="https://vtoljatti.ru/">vtoljatti.ru</a>
        </small>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                year: new Date().getFullYear()
            }
        },
    }
</script>
