<template>
    <div>
        <strong class="text-muted h5 font-weight-normal">
            Акты
        </strong><hr>
        <p class="font-italic">
            Тут будут все акты, так же куча функций с ними
        </p>
        <ModalAct />
    </div>
</template>

<script>
import ModalAct from '../components/forms/Act'

export default {
    components: {
        ModalAct
    }
}
</script>
