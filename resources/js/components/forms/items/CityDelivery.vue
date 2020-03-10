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

                <b-form-group class="pt-3 mb-0" v-if="cityId != 0">
                    <b-form-radio v-model="districtId" name="some-radios" value="1" required>Автозаводский</b-form-radio>
                    <b-form-radio v-model="districtId" name="some-radios" value="2" required>Комсомольский</b-form-radio>
                    <b-form-radio v-model="districtId" name="some-radios" value="3" required>Центральный</b-form-radio>
                    <b-form-radio v-model="districtId" name="some-radios" value="4" required>Шлюзовой</b-form-radio>
                    <b-form-radio v-model="districtId" name="some-radios" value="5" required>Жигулевское море</b-form-radio>
                </b-form-group>

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
                        <b-col v-for="village in villages">
                            <option>{{ village.name }}</option>
                        </b-col>
                    </b-row>
                </datalist>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            cityUser: 'Тольятти',
            cityId: 1,
            districtId: '',
            city: '',
            district: '',
            villages: '',
            loading: ''
        }
    },
    methods: {
        dataCommon() {
            this.data({
                cityId: this.cityId,
                city: this.city,
                district: this.district,
            })
        },
        fetchData() {
            this.error = this.users = null;
            this.loading = true;
            axios
                .get('/api/villages')
                .then(response => {
                    this.loading = false;
                    this.villages = response.data.villages;
                }).catch(error => {
                this.loading = false;
                this.error = error.response.data.message || error.message;
            });
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
        district: function (val) {
            this.dataCommon()
        },
    },
    created() {
        this.fetchData();
        this.dataCommon()
    }
}
</script>
