<template>
    <div class="container p-2">
        <i class="fa fa-check"></i>
        <Menu />
        <br>
        <router-view />
    </div>
</template>

<script>
import Menu from './components/Menu'

export default {
    components: {
        Menu
    }
}
</script>
