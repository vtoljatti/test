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
                        value="0"
                        class="btn-light"
                    >
                        не {{ cityUser }}
                    </b-form-radio>
                </b-form-radio-group>

                <div v-if="this.allDistricts.length === 0" class="text-center">
                    <b-spinner type="grow" label="Loading..."></b-spinner>
                </div>
                <div v-else>
                    <b-form-group class="pt-3 mb-0" v-if="cityId != 0">
                        <b-form-radio
                            v-for="district in allDistricts"
                            v-model="districtId"
                            :value="district.id"
                            required
                        >
                            {{ district.name }}
                        </b-form-radio>
                    </b-form-group>
                </div>

                <b-form-input
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
                            <option v-for="village in allVillages">{{ village.name }}</option>
                        </b-col>
                    </b-row>
                </datalist>
            </div>
        </div>
    </div>
</template>

<script>
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
            cityUser: 'Тольятти',
            cityId: 1,
            districtId: '',
            city: 'Тольятти',
            district: '',
            villages: '',
            loading: true
        }
    },
    computed: {
        allVillages() {
            return this.$store.getters['cities/allVillages']
        },
        allDistricts() {
            return this.$store.getters['cities/allDistricts']
        }
    },
    methods: {
        dataCommon() {
            this.data({
                cityId: this.cityId,
                city: this.city,
                district: this.district,
                districtId: this.districtId
            })
        }
    },
    watch: {
        cityId: function (val) {
            this.dataCommon()
            if (this.cityId != 0) {
                this.city = this.cityUser
            } else {
                this.city = ''
            }
        },
        city: function (val) {
            this.dataCommon()
        },
        districtId: function (val) {
            this.dataCommon()
        },
    },
    created() {
        this.dataCommon()
    },
    beforeMount() {
        if (this.allVillages.length === 0) {
            this.$store.dispatch('cities/getAllVillages');
            console.log('Загружены данные cities/getAllVillages')
        }

        if (this.allDistricts.length === 0) {
            this.$store.dispatch('cities/getAllDistricts');
            console.log('Загружены данные cities/getAllDistricts')
        }
    }
}
</script>

