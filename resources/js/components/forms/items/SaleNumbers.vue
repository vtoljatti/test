<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Номер документа продажи
                </small>
            </div>
            <div class="p-1 pt-2 d-flex justify-content-between align-items-center">
                <b-form-input
                    type="number"
                    class="text-center"
                    v-model="salesNumber1"
                    placeholder="000001"
                    min="0"
                    maxlength="6"
                    required
                    size="sm"
                />
                <b-form-input
                    type="number"
                    class="text-center mx-1"
                    v-model="salesNumber2"
                    placeholder="000002"
                    min="0"
                    maxlength="6"
                    size="sm"
                />
                <b-form-input
                    type="number"
                    class="text-center"
                    v-model="salesNumber3"
                    placeholder="000003"
                    min="0"
                    maxlength="6"
                    size="sm"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            salesNumber1: '',
            salesNumber2: '',
            salesNumber3: ''
        }
    },
    methods: {
        dataCommon() {
            this.data({
                salesNumber1: this.salesNumber1,
                salesNumber2: this.salesNumber2,
                salesNumber3: this.salesNumber3
            })
        }
    },
    watch: {
        salesNumber1: function (val) {
            this.dataCommon()
        },
        salesNumber2: function (val) {
            this.dataCommon()
        },
        salesNumber3: function (val) {
            this.dataCommon()
        }
    },
    created() {
        this.dataCommon()
    }
}
</script>
