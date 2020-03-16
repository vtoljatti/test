<template>
    <div class="text-center py-5">
        <div class="text-center" v-if="!content">
            <b-spinner type="grow" label="Loading..."></b-spinner>
        </div>
        <div v-else>
            <div class="display-1">401</div>
            <div class="display-4">нет доступа</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                content: false,
            }
        },

        created() {
            setTimeout(function () {
                this.content = true
            }.bind(this), 1500)
        }
    }
</script>
