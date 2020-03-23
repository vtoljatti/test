<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Стоимость доставки
                </small>
            </div>
            <b-row class="p-1 pt-2 justify-content-center align-items-center text-left small">
                <b-col>
                    <b-form-checkbox
                        v-model="toBring"
                        name="is_to_bring"
                        value="1"
                        unchecked-value="0"
                        switch
                    >
                        Довоз
                    </b-form-checkbox>
                    <b-form-checkbox
                        v-model="exchange"
                        name="is_exchange"
                        value="1"
                        unchecked-value="0"
                        switch
                    >
                        Обмен
                    </b-form-checkbox>
                    <b-form-checkbox
                        v-model="isFree"
                        name="is_free"
                        switch
                    >
                        Бесплатно
                    </b-form-checkbox>
                </b-col>
                <b-col>
                    <b-input-group>
                        <b-input-group size="sm" append="руб.">
                            <b-form-input
                                :class="{'border-danger': !isValidate}"
                                class="text-center"
                                type="number"
                                v-model="cost"
                                placeholder="Стоимость"
                                min="0"
                                maxlength="6"
                                size="sm"
                            />
                        </b-input-group>
                    </b-input-group>

                </b-col>
            </b-row>
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
            toBring: 0,
            exchange: 0,
            isFree: false,
            cost: null
        }
    },

    methods: {
        validate() {
            if (this.cost > 0 || this.isFree === true) {
                this.isValidate = true
            } else {
                this.isValidate = false
            }
        },

        dataCommon() {
            this.data({
                toBring: this.toBring,
                exchange: this.exchange,
                isFree: this.isFree,
                cost: this.cost,
                isValidate: this.isValidate
            })
        }
    },

    computed: {
        ...mapGetters({
            dataModal: 'others/dataModal'
        })
    },

    watch: {
        dataModal: function (val) {
            this.toBring =  this.dataModal.act.is_to_bring;
            this.exchange =  this.dataModal.act.is_exchange;
            this.cost =  this.dataModal.act.cost;
            this.isFree =  this.dataModal.act.cost > 0 ? false : true;

            this.validate()
            this.dataCommon()
        },

        toBring: function (val) {
            this.dataCommon()
        },

        exchange: function (val) {
            this.dataCommon()
        },

        isFree: function (val) {
            if (this.isFree === true) {
                this.cost = 0
            } else {
                if (this.cost === 0) {
                    this.cost = ''
                }
            }
            this.validate()
            this.dataCommon()
        },

        cost: function (val) {
            if (this.cost > 0) {
                this.isFree = false
            }
            this.validate()
            this.dataCommon()
        }
    },

    created() {
        this.validate()
        this.dataCommon()
    }
}
</script>
