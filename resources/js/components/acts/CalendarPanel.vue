<template>
    <div>
        <b-calendar
            block
            v-model="date"
            @context="onDateData"
            :dateFormatOptions="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
            selected-variant="primary"
            today-variant="primary"
            start-weekday="1"
            hide-header
            locale="ru"
            labelHelp=""
        />
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    data: () => ({
        date: '',
    }),

    methods: {
        ...mapActions({
            setPicketDay: 'acts/setPickedDay'
        }),

        onDateData(ctx) {
            this.dateData = ctx
        },

        // устанавливаем сегодняшнюю дату
        setDate(addDay = 0) {
            let date = new Date()
            return `${date.getFullYear()}-${(date.getMonth() <= 9 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1))}-${date.getDate() + addDay}`
        }
    },

    computed: {
        ...mapGetters({
            dateFromState: 'acts/pickedDay'
        })
    },

    watch: {
        // Записываем в store если дата изменилась
        date(val) {
            this.setPicketDay(val)
        },

        // Наблюдаем за изменениями даты в store
        dateFromState(val) {
            if (this.dateFromState && this.dateFromState !== this.date) {
                this.date = this.dateFromState
            }
        }
    },

    created() {
        // Устанавливаем дату на колендаре
        if (!this.dateFromState) {
            this.date = this.setDate(1)
        } else {
            this.date = this.dateFromState
        }
    }
}
</script>
