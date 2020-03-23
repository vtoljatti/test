<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Пункт доставки
                </small>
            </div>
            <div class="p-1 pt-2 small text-left">

                <b-form-radio-group class="text-center w-100" buttons>
                    <b-form-radio
                        :class="{ active: cityId != 0 }"
                        v-model="cityId"
                        name="some-radios"
                        value="1"
                        class="btn-light"
                    >
                        {{ cityUser }}
                    </b-form-radio>
                    <b-form-radio
                        :class="{ active: cityId == 0 }"
                        v-model="cityId"
                        name="some-radios"
                        value=""
                        class="btn-light"
                    >
                        не {{ cityUser }}
                    </b-form-radio>
                </b-form-radio-group>

                <div v-if="this.allDistrictsCity.length === 0" class="text-center">
                    <b-spinner type="grow" label="Loading..."></b-spinner>
                </div>
                <div v-else>
                    <b-form-group class="pt-3 mb-0 rounded" v-if="cityId != 0" required :class="{'border border-danger p-2 m-1': !districtId}">
                        <b-form-radio required
                            v-for="district in allDistrictsCity"
                            v-model="districtId"
                            :value="district.id"
                        >
                            {{ district.name }}
                        </b-form-radio>
                    </b-form-group>
                </div>

                <b-form-input
                    :class="{'border-danger': !isValidate}"
                    list="list-villages"
                    class="mt-3 mb-0 text-center"
                    v-if="cityId == 0"
                    type="text"
                    value=""
                    v-model="city"
                    placeholder="Населенный пункт"
                    required
                    size="sm"
                />
                <datalist id="list-villages">
                    <b-row>
                        <b-col>
                            <option v-for="village in allVillagesCity">{{ village.name }}</option>
                        </b-col>
                    </b-row>
                </datalist>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    props: {
      data: {
          type: Function,
          default: () => {},
          required: true
      }
    },

    data() {
        return {
            isValidate: false,
            cityUser: '',
            cityId: '',
            districtId: '',
            city: '',
            district: '',
            villages: '',
            loading: true
        }
    },

    computed: {
        ...mapGetters({
            dataModal: 'others/dataModal',
            authUser: 'users/authUser'
        }),

        authUser() {
            return this.$store.getters['users/authUser'] || []
        },

        allVillagesCity() {
            return this.$store.getters['villages/allVillagesCity'] || []
        },

        allDistrictsCity() {
            return this.$store.getters['districts/allDistrictsCity'] || []
        },
    },

    methods: {
        dataCommon() {
            this.data({
                cityId: this.cityId,
                city: this.city,
                district: this.district,
                districtId: this.districtId,
                isValidate: this.isValidate
            })
        },
        validate() {
            if (!this.city) {
                this.isValidate = false
            } else {
                if (!this.cityId) {
                    this.isValidate = true
                } else {
                    if (!this.districtId) {
                        this.isValidate = false
                    } else {
                        this.isValidate = true
                    }
                }
            }
        }
    },

    watch: {
        dataModal: function (val) {
            this.cityId = this.dataModal.act.city_id;
            this.district = this.dataModal.act.district;
            this.districtId = this.dataModal.act.district_id;
            this.city = this.dataModal.act.city;

            this.validate();
            this.dataCommon()
        },

        cityId: function (val) {
            if (this.cityId != 0) {
                this.city = this.cityUser
            } else {
                // this.city = ''
            }
            this.validate()
            this.dataCommon()
        },

        city: function (val) {
            this.validate()
            this.dataCommon()
        },

        districtId: function (val) {
            this.validate()
            this.dataCommon()
        },
    },

    mounted() {
        this.cityUser = this.authUser.city;

        if (!this.dataModal.act.length) {
            this.cityId = this.authUser.city_id;
            this.districtId = this.authUser.district_id;
        }

        if (!this.allVillagesCity.length) {
            this.$store.dispatch('villages/getAllVillagesCity', this.authUser.city_id);
        }

        if (!this.allDistrictsCity.length) {
            this.$store.dispatch('districts/getAllDistrictsCity', this.authUser.city_id);
        }

        this.validate()
        this.dataCommon()
    }
}
</script>

