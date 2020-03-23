<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Адрес доставки
                </small>
            </div>
            <div class="px-1 pt-2 text-left">
                <label class="small text-left mx-1 w-100">
                    <small>Улица *</small>
                    <b-form-input
                        class="text-center small"
                        list="list-streets"
                        :class="{'border-danger': validateStreet}"
                        type="text"
                        v-model="street"
                        placeholder="Улица"
                        size="sm"
                    />
                    <datalist id="list-streets">
                        <b-row>
                            <b-col v-for="street in streetsDistrict">
                                <option>{{ street.name }}</option>
                            </b-col>
                        </b-row>
                    </datalist>
                    <small v-if="validateStreetMessage" class="text-danger font-weight-bold">{{ validateStreetMessage }}</small>
                </label>
            </div>
            <div class="px-1 d-flex justify-content-between align-items-center">

                <label class="small text-left mx-1 w-100">
                    <small>Дом *</small>
                    <b-form-input
                        class="text-center"
                        :class="{'border-danger': validateHome}"
                        type="text"
                        v-model="home"
                        placeholder="Дом"
                        size="sm"
                    />
                    <small v-if="validateHomeMessage" class="text-danger font-weight-bold">{{ validateHomeMessage }}</small>
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
import { mapGetters } from "vuex";

export default {
    props: ['data', 'district'],

    data() {
        return {
            isValidate: false,
            street: '',
            home: '',
            apartment: '',
            porch: '',
            validateStreet: false,
            validateStreetMessage: false,
            validateHome: false,
            validateHomeMessage: false,
            messageRequiredField: ''
        }
    },

    computed: {
        ...mapGetters({
            dataModal: 'others/dataModal'
        }),

        authUser() {
            return this.$store.getters['users/authUser'] || []
        },

        allStreets() {
            return this.$store.getters['streets/allStreetsCity'] || []
        },

        // Меняем список улиц в зависимости от района
        streetsDistrict() {
            if (this.district.districtId) {
                let [...streets] = this.allStreets
                return streets.filter(street => street.district_id === this.district.districtId)
            }
            return []
        },

    },

    methods: {
        dataCommon() {
            this.data({
                street: this.street,
                home: this.home,
                apartment: this.apartment,
                porch: this.porch,
                isValidate: this.isValidate
            })
        },

        validate() {
            this.сheckStreet()
            this.сheckHome()
            if (!this.street || !this.home) {
                this.isValidate = false
            } else {
                this.isValidate = true
            }
        },

        сheckStreet() {
            // Валидация
            if (!this.street) {
                this.validateStreet = true
                this.validateStreetMessage = this.messageRequiredField
            } else {
                this.validateStreet = false
                this.validateStreetMessage = false
            }
        },

        сheckHome() {
            // Валидация
            if (!this.home) {
                this.validateHome = true
                this.validateHomeMessage = this.messageRequiredField
            } else {
                this.validateHome = false
                this.validateHomeMessage = false
            }
        },
    },

    watch: {
        dataModal: function (val) {
            this.street =  this.dataModal.act.street;
            this.home =  this.dataModal.act.home;
            this.apartment =  this.dataModal.act.apartment;
            this.porch =  this.dataModal.act.porch;
            this.validate();
            this.dataCommon()
        },

        street: function (val) {
            this.validate();
            this.dataCommon()
        },

        home: function (val) {
            this.validate();
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
        this.validate();
        this.dataCommon();
    },

    beforeMount() {
        if (!this.allStreets.length) {
            this.$store.dispatch('streets/getAllStreetsCity', this.authUser.city_id)
        }
    }
}
</script>
