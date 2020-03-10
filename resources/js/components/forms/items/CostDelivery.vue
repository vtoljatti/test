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
                        value="1"
                        unchecked-value="0"
                        switch
                    >
                        Бесплатно
                    </b-form-checkbox>
                </b-col>
                <b-col>
                    <b-input-group>
                        <b-input-group size="sm" append="руб.">
                            <b-form-input
                                class="text-center"
                                type="number"
                                v-model="cost"
                                placeholder="Стоимость"
                                min="0"
                                maxlength="6"
                                required
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
export default {
    props: ['data'],
    data() {
        return {
            toBring: 0,
            exchange: 0,
            isFree: 0,
            cost: null
        }
    },
    methods: {
        dataCommon() {
            this.data({
                toBring: this.toBring,
                exchange: this.exchange,
                isFree: this.isFree,
                cost: this.cost
            })
        },
        clickIsFree() {
             if (this.isFree === '0') {
                this.cost = 0
            }
        }
    },
    watch: {
        toBring: function (val) {
            this.dataCommon()
        },
        exchange: function (val) {
            this.dataCommon()
        },
        isFree: function (val) {
            this.dataCommon()
            if (this.isFree === '1') {
                this.cost = 0
            } else {
                if (this.cost === 0) {
                    this.cost = ''
                }
            }
        },
        cost: function (val) {
            this.dataCommon()
            if (this.cost > 0) {
                this.isFree = 0
            }
        }
    },
    created() {
        this.dataCommon()
    }
}
</script>
