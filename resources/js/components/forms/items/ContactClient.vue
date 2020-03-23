<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Контакты
                </small>
            </div>
            <div class="px-1 pt-2 text-left rounded" :class="{'border border-danger m-2 p-2': !isValidate}">
                <label class="small text-left w-100">
                    <small>Имя клиента</small>
                    <b-form-input
                        class="text-center"
                        type="text"
                        v-model="lastName"
                        placeholder="Имя клиента"
                        size="sm"
                    />
                </label>
                <label class="small text-left w-100">
                    <small>Мобильный</small>
                    <b-form-input
                        class="text-center"
                        type="text"
                        v-model="phone"
                        placeholder="Мобильный"
                        maxlength="16"
                        size="sm"
                        @focusout="focusoutPhone"
                        @input="phoneFormat($event, 'phone')"
                    />
                </label>

                <label class="small text-left w-100">
                    <small>Мобильный</small>
                    <b-form-input
                        class="text-center"
                        type="text"
                        v-model="phoneSpare"
                        placeholder="Мобильный"
                        maxlength="16"
                        size="sm"
                        @focusout="focusoutPhoneSpare"
                        @input="phoneFormat($event, 'phoneSpare')"

                    />
                </label>
                <label class="small text-left w-100">
                    <small>Городской</small>
                    <b-form-input
                        class="text-center"
                        type="text"
                        v-model="phoneHome"
                        placeholder="Городской"
                        maxlength="9"
                        size="sm"
                        @input="phoneFormatHome($event, 'phoneHome')"
                    />
                </label>
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
            lastName: null,
            phone: '',
            phoneSpare: '',
            phoneHome: ''
        }
    },

    methods: {
        validate() {
            if (!this.phone && !this.phoneSpare && !this.phoneHome) {
                this.isValidate = false
            } else {
                this.isValidate = true
            }
        },

        dataCommon() {
            this.data({
                lastName: this.lastName,
                phone: this.phone,
                phoneSpare: this.phoneSpare,
                phoneHome: this.phoneHome,
                isValidate: this.isValidate
            })
        },

        focusoutPhone() {
            if (this.phone === '+7') {
                this.phone = ''
            }
        },

        focusoutPhoneSpare() {
            if (this.phoneSpare === '+7') {
                this.phoneSpare = ''
            }
        },

        phoneFormat(value, field) {
            if (this.value !== '') {
                this[field] = this[field].replace(new RegExp('\\D+', 'g'), '');
                let p1 = this[field].substr(1, 3);
                let p2 = this[field].substr(4, 3);
                let p3 = this[field].substr(7, 2);
                let p4 = this[field].substr(9, 2);
                if (p2.length > 0) {
                    this[field] = '+7(' + p1 + ')' + p2 + '-' + p3 + '-' + p4;
                } else if (p1.length > 0) {
                    this[field] = '+7(' + p1;
                } else {
                    this[field] = '+7';
                }
            }
        },

        phoneFormatHome(value, field) {
            if (this.value !== '') {
                this[field] = this[field].replace(new RegExp('\\D+', 'g'), '');
                var p1 = this[field].substr(0, 2);
                var p2 = this[field].substr(2, 2);
                var p3 = this[field].substr(4, 3);
                if (p2.length > 0) {
                    this[field] = p1 + '-' + p2 + '-' + p3;
                } else if (p1.length > 3) {
                    this[field] = p1 + p2;
                } else {
                    this[field] = p1;
                }
            }
        }
    },

    computed: {
        ...mapGetters({
            dataModal: 'others/dataModal'
        })
    },

    watch: {
        dataModal: function (val) {
            this.lastName =  this.dataModal.act.last_name;
            this.phone =  this.dataModal.act.phone_1;
            this.phoneSpare =  this.dataModal.act.phone_2;
            this.phoneHome =  this.dataModal.act.phone_3;

            this.validate()
            this.dataCommon()
        },

        lastName: function (val) {
            this.dataCommon()
        },
        phone: function (val) {
            this.validate()
            this.dataCommon()
        },
        phoneHome: function (val) {
            this.validate()
            this.dataCommon()
        },
        phoneSpare: function (val) {
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
