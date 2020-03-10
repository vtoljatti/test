<template>
    <div>
        <FormAct />
    </div>
</template>

<script>
import FormAct from '../components/forms/Act'
export default {
    components: {
        FormAct,
    },
    data() {
        return {
            error: null,
            loading: false,
        };
    }
}
</script>
