<template>
    <div class="p-1">
        <div class="p-2 pb-4 bg-white rounded w-100 block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Дата доставки
                </small>
            </div>
            <div class="pt-1">
                <b-calendar
                    v-model="dateValue"
                    @context="onDateData"
                    :dateFormatOptions="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                    selected-variant="primary"
                    today-variant="primary"
                    start-weekday="1"
                    hide-header
                    locale="ru"
                    labelHelp=""
                />
                <div class="text-center" dir="ltr">
                    <b-button
                        size="sm"
                        variant="outline-primary"
                        class="py-2 px-3 border-light"
                        :class="{active: dateTomorrowActive}"
                        @click="setTomorrow"
                    >
                        <i class="fa fa-calendar"></i> на завтра
                    </b-button>
                    <b-button
                        size="sm"
                        variant="outline-primary"
                        class="py-2 px-3 border-light"
                        :class="{active: dateAfterTomorrowActive}"
                        @click="setAfterTomorrow"
                    >
                        <i class="fa fa-calendar"></i> на послезавтра
                    </b-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            dateValue: '',
            dateData: '',
            date: '',
            dateTomorrow: '',
            dateAfterTomorrow: '',
            dateTomorrowActive: '',
            dateAfterTomorrowActive: '',
        }
    },
    methods: {
        onDateData(ctx) {
            this.dateData = ctx
        },
        setTomorrow() {
            this.dateValue = this.dateTomorrow;
        },
        setAfterTomorrow() {
            this.dateValue = this.dateAfterTomorrow;
        },
        setDate(field, addDay = 0) {
            this[field] = new Date(new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate() + addDay));
            let d = this[field].getDate();
            let m = this[field].getMonth() + 1;
            let y = this[field].getFullYear();
            this[field] = y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
        },
        dataCommon() {
            this.data({
                date: this.dateData.selectedYMD ?? '',
                dateAdd: this.date,
            })
        },
    },
    watch: {
        dateData: function (val) {
            this.dataCommon()
        },
        dateValue: function (val) {
            if (this.dateValue === this.dateTomorrow) {
                this.dateTomorrowActive = true
            } else {
                this.dateTomorrowActive = false
            }
            if (this.dateValue === this.dateAfterTomorrow) {
                this.dateAfterTomorrowActive = true
            } else {
                this.dateAfterTomorrowActive = false
            }
        }
    },
    created() {
        this.setTomorrow();
        this.setAfterTomorrow();
        this.setDate('date')
        this.setDate('dateValue', 1)
        this.setDate('dateTomorrow', 1)
        this.setDate('dateAfterTomorrow', 2)
    }
}
</script>
