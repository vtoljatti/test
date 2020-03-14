<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Адрес доставки
                </small>
            </div>
            <div class="px-1 pt-2 text-left">
                <label class="small text-left w-100">
                    <small>Улица *</small>
                    <b-form-input
                        list="list-streets"
                        class="text-center small"
                        type="text"
                        v-model="street"
                        placeholder="Улица"
                        required
                        size="sm"
                    />
                </label>
                <datalist id="list-streets">
                    <b-row>
                        <b-col v-for="street in allStreets">
                            <option>{{ street.name }}</option>
                        </b-col>
                    </b-row>
                </datalist>
            </div>
            <div class="px-1 d-flex justify-content-between align-items-center">
                <label class="small text-left">
                    <small>Дом *</small>
                    <b-form-input
                        type="text"
                        class="text-center"
                        placeholder="Дом"
                        v-model="home"
                        required
                        size="sm"
                    />
                </label>
                <label class="small text-left mx-1">
                    <small>Квартира/офис</small>
                    <b-form-input
                        type="text"
                        class="text-center"
                        placeholder="кв/оф"
                        v-model="apartment"
                        size="sm"
                    />
                </label>
                <label class="small text-left">
                    <small>Подъезд</small>
                    <b-form-input
                        type="text"
                        class="text-center"
                        placeholder="Подъезд"
                        v-model="porch"
                        size="sm"
                    />
                </label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            street: null,
            home: null,
            apartment: null,
            porch: null
        }
    },
    computed: {
        allStreets() {
            return this.$store.getters['cities/allStreets']
        }
    },
    methods: {
        dataCommon() {
            this.data({
                street: this.street,
                home: this.home,
                apartment: this.apartment,
                porch: this.porch
            })
        }
    },
    watch: {
        street: function (val) {
            this.dataCommon()
        },
        home: function (val) {
            this.dataCommon()
        },
        apartment: function (val) {
            this.dataCommon()
        },
        porch: function (val) {
            this.dataCommon()
        }
    },
    created() {
        this.dataCommon();
    },
    beforeMount() {
        if (this.allStreets.length === 0) {
            this.$store.dispatch('cities/getAllStreets')
            console.log('Загружены данные cities/getAllStreets')
        }
    }
}
</script>
