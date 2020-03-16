<template>
    <div>
        <div v-if="authUser">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        История изменений актов
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                </b-col>
            </b-row>

            <div class="p-3 justify-content-left text-left bg-filter">
                Тут будет история изменений актов
            </div>

        </div>
        <div v-else>
            <Page401 />
        </div>
    </div>
</template>

<script>
    import Page401 from "./401";

    export default {

        components: {
            Page401
        },

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            }
        }
    }
</script>
