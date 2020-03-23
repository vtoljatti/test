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
                    :class="{'border-danger': !isValidate}"
                    type="number"
                    class="text-center"
                    v-model="salesNumber1"
                    placeholder="000001"
                    min="0"
                    :has-counter="false"
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
import { mapGetters } from "vuex";

export default {
    props: ['data'],

    data() {
        return {
            isValidate: false,
            salesNumber1: '',
            salesNumber2: '',
            salesNumber3: '',
            max: 5,
        }
    },

    methods: {
        validate() {
            if (!this.salesNumber1) {
                this.isValidate = false
            } else {
                this.isValidate = true
            }
        },

        dataCommon() {
            this.data({
                salesNumber1: this.salesNumber1,
                salesNumber2: this.salesNumber2,
                salesNumber3: this.salesNumber3,
                isValidate: this.isValidate
            })
        }
    },

    computed: {
        ...mapGetters({
            dataModal: 'others/dataModal'
        }),
    },

    watch: {
        dataModal: function (val) {
            this.salesNumber1 = this.dataModal.act.number_sales_1;
            this.salesNumber2 = this.dataModal.act.number_sales_2;
            this.salesNumber3 = this.dataModal.act.number_sales_3;
            this.validate()
            this.dataCommon()
        },

        salesNumber1: function (val) {
            this.validate()
            this.dataCommon()
        },
        salesNumber2: function (val) {
            this.dataCommon()
        },
        salesNumber3: function (val) {
            this.dataCommon()
        }
    },

    beforeMount() {
        this.validate()
        this.dataCommon()
    }
}
</script>
