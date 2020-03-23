<template>
    <div class="my-2 px-2 shadow-sm text-center text-lg-left bg-filter">
        <b-row>

            <b-col lg="4" md="12" class="py-2">
                <b-button size="md"
                          class="font-weight-bold"
                          @click="openModal(0)"
                          variant="primary"
                >
                    <i class="fa fa-plus"></i> ДОБАВИТЬ АКТ
                </b-button>

                <b-button v-if="false" size="md" variant="secondary">
                    <i class="fa fa-print"></i>
                </b-button>

                <b-dropdown v-else size="md" split split-href="#" split-variant="secondary">
                    <template v-slot:button-content>
                        <i class='fa fa-print'></i>
                    </template>
                    <b-dropdown-item v-for="driver in drivers" href="#">
                        <i class='fa fa-print'></i> {{ driver.name }}
                    </b-dropdown-item>
                </b-dropdown>


            </b-col>

            <b-col lg="2" md="3" class="d-none d-md-inline-block py-2">
                <b-select size="md"
                          v-model="filterActDrivers"
                          :class="{'bg-light border-warning' : filterActDrivers}"
                >
                    <b-select-option :value="0">все водители</b-select-option>
                    <b-select-option
                        v-for="driver in drivers"
                        :value="driver.id"
                        :key="driver.id"
                    >
                        {{ driver.name }}
                    </b-select-option>
                </b-select>
            </b-col>

            <b-col lg="2" md="3" class="d-none d-md-inline-block py-2">
                <b-select size="md"
                          class="border-none w-100"
                          v-model="filterActDistricts"
                          :class="{'bg-light border-warning' : filterActDistricts}"
                >
                    <b-select-option :value="0">все районы</b-select-option>
                    <b-select-option
                        v-for="district in allDistrictsCity"
                        :value="district.id"
                        :key="district.id"
                    >
                        {{ district.name }}
                    </b-select-option>
                </b-select>
            </b-col>

            <b-col lg="2" md="3" class="d-none d-md-inline-block py-2">
                <b-select size="md"
                          class="border-none w-100"
                          v-model="filterActShops"
                          :class="{'bg-light border-warning' : filterActShops}"
                >
                    <b-select-option :value="0">все магазины</b-select-option>
                    <b-select-option
                        v-for="shop in stores"
                        :value="shop.id"
                        :key="shop.id"
                    >
                        {{ shop.name }}
                    </b-select-option>
                </b-select>
            </b-col>

            <b-col lg="2" md="3" class="d-none d-md-inline-block py-2">
                <b-select size="md"
                          class="border-none w-100"
                          v-model="filterActSort"
                          :class="{'bg-light border-warning' : filterActSort}"
                >
                    <b-select-option
                        v-for="(sort, index) in filterActSortData"
                        :key="index"
                        :value="index"
                    >
                        {{ sort }}
                    </b-select-option>
                </b-select>
            </b-col>

        </b-row>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    // props: ['modal'],

    data() {
        return {
            filterActDrivers: 0,
            filterActDistricts: 0,
            filterActShops: 0,
            filterActSort: 0,
            filterActSortData: ['сортировка', 'по времени', 'по добавлении', 'по районам', 'по магазинам']
        }
    },

    methods: {
        ...mapActions({
            setFilterActs: 'acts/setFilterActs',
            getAllUsers: 'users/getAllUsers',
            setDataModal: 'others/setDataModal'
        }),

        openModal(id = 0) {
            this.setDataModal({
                id: id,
                show: true,
                act: []
            })
        },

        dataCommon() {
            this.setFilterActs({
                driverId: this.filterActDrivers,
                districtId: this.filterActDistricts,
                shopId: this.filterActShops,
                sort: this.filterActSort
            })
        },
    },

    computed: {
        ...mapGetters({
            filterActs: 'acts/filterActs',
            authUser: 'users/authUser',
            allUsers: 'users/allUsers',
            allShopCity: 'districts/allShopCity',
            allDistrictsCity: 'districts/allDistrictsCity',
            dataModal: 'others/dataModal',
        }),

        getDataModal() {
            return this.dataModal
        },

        // фильтруем магазины
        stores() {
            if (this.allUsers) {
                let [...users] = this.allUsers

                users = users.filter(user => user.is_hidden === 0)
                users = users.filter(user => user.role === 'store')
                users = users.filter(user => user.city_id === this.authUser.city_id)

                return users
            }
            return []
        },

        // фильтруем водителей
        drivers() {
            if (this.allUsers) {
                let [...users] = this.allUsers

                users = users.filter(user => user.is_hidden === 0)
                users = users.filter(user => user.role === 'driver')
                users = users.filter(user => user.city_id === this.authUser.city_id)

                return users
            }
            return []
        }
    },

    watch: {
        filterActDrivers: function (val) {
            this.dataCommon()
        },

        filterActDistricts: function (val) {
            this.dataCommon()
        },

        filterActShops: function (val) {
            this.dataCommon()
        },

        filterActSort: function (val) {
            this.dataCommon()
        }
    },

    beforeMount() {
        if (!this.allUsers.length) {
            this.getAllUsers
        }
    }
}
</script>
