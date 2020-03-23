<template>
    <div>
        <div>
            <div class="text-right small text-muted px-2">
                <span class="text-nowrap">всего: <strong>12</strong></span>
                <span class="text-nowrap"> | д 14:00: <strong>4</strong></span>
                <span class="text-nowrap"> | п 14:00: <strong>5</strong></span>
                <span class="text-nowrap"> | п 17:00: <strong>3</strong></span>
                <i id="info" class="fa fa-info-circle text-warning fa-2x ml-2 hover"></i>
                <i class="fa fa-cog text-secondary fa-2x ml-2 hover" ref="show" :disabled="show" @click="show = true"></i>
            </div>

            <b-popover target="info" triggers="hover" placement="leftbottom">
                <div class="p-2">
                    <div>сумма: <strong>4500р</strong></div>
                    <hr>
                    <div>всего: <strong>12</strong> из <strong class="text-danger">13</strong></div>
                    <div>до 14:00: <strong>4</strong> из <strong class="text-danger">13</strong></div>
                    <div>после 14:00: <strong>5</strong></div>
                    <div>после 17:00: <strong>3</strong></div>
                    <hr>
                    <div>Автозаводский: <strong>6</strong></div>
                    <div>Центральный: <strong>6</strong></div>
                    <div>Комсомольский: <strong>6</strong></div>
                    <div>Шлюзовой: <strong>6</strong></div>
                    <div>Жигулевское море: <strong>6</strong></div>
                    <div>За городом: <strong>6</strong></div>
                </div>
            </b-popover>
        </div>

        <div>
            <div class="h4 text-center pt-4 text-muted font-weight-bold">
                {{ pickedDay }}
            </div>
            <div class="h5 py-3 px-1 text-center text-primary font-weight-normal">
                Тут будут картинки, комментарии которые будут писать администраторы для продавцов и для
                водителей о каких либо событиях или других целей сообщить информацию на конкретную дату
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            show: false,
        }
    },

    computed: {
        ...mapGetters({
            pickedDay: 'acts/pickedDay',
        }),
    }
}
</script>
