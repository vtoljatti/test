<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Время доставки
                </small>
            </div>
            <b-row class="p-1 pt-2 justify-content-between align-items-center text-left">
                <b-col class="text-left">
                    <b-form-select
                        v-model="beforeAfter"
                        :options="beforeAfterOptions"
                        size="sm"
                    />
                </b-col>
                <b-col>
                    <b-time
                        v-model="timeValue"
                        locale="ru"
                        @context="onTimeData"
                        minutes-step="10"
                        hide-header
                    />
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            timeValue: '14:00:00',
            timeData: null,
            beforeAfter: 0,
            beforeAfterOptions: [
                { value: '0', text: 'До' },
                { value: '1', text: 'После' }
            ]
        }
    },
    methods: {
        onTimeData(ctx) {
            this.timeData = ctx
        },
        dataCommon() {
            this.data({
                time: this.timeValue,
                beforeAfter: this.beforeAfter,
            })
        }
    },
    watch: {
        timeValue: function (val) {
            this.dataCommon()
        },
        beforeAfterOptions: function (val) {
            this.dataCommon()
        },
        beforeAfter: function (val) {
            this.dataCommon()
        }
    },
    created() {
        this.dataCommon()
    }
}
</script>
