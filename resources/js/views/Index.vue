<template>
    <div>
        <strong class="text-muted h5 font-weight-normal">
            Главная
        </strong><hr>
        <p class="font-italic">
            Тут будут графики, последние изменения, ну короче вся нужная информация
        </p>
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
