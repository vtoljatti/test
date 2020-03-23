<template>
    <div>
        <div v-if="authUser">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        Районы
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                    <b-button size="sm"
                              @click="openModalDistrict(0)"
                              class="rounded-circle"
                              variant="outline-success"
                              v-b-tooltip.hover
                              placement="bottom"
                              title="Новый пользователь">
                        <i class="fa fa-plus"></i>
                    </b-button>

                    <ModalDistrict v-if="showCreateDistrictModal" @closeForm="closeModalDistrict" :district-id="editableDistrictId" />

                </b-col>
            </b-row>

            <b-row class="p-3 justify-content-left text-left bg-filter">
                <b-col xl="3" lg="3" md="4" class="my-1 justify-content-center">
                    <b-form-input type="search" v-model="searchText" @input="searchByText($event)" placeholder="Поиск"/>
                </b-col>

                <b-col xl="3" lg="3" md="4" class="my-1 justify-content-center">
                    <b-form-select v-model="selectedCity">
                        <b-form-select-option :value="0">Все города</b-form-select-option>
                        <b-form-select-option
                            v-for="city in allCities"
                            :value="city.id"
                            :key="city.id"
                        >
                            {{ city.name }}
                        </b-form-select-option>
                    </b-form-select>
                </b-col>

                <b-col xl="3" lg="3" md="1" class="my-1 justify-content-center"></b-col>

                <b-col xl="3" lg="3" md="3" class="my-1 justify-content-center">
                    <b-form-select v-model="sortDistrictsBy">
                        <b-form-select-option :value="0">Сортировка</b-form-select-option>
                        <b-form-select-option
                            v-for="(variant, index) in sortVariants"
                            :key="index + 1"
                            :value="index + 1"
                        >
                            {{ variant }}
                        </b-form-select-option>
                    </b-form-select>
                </b-col>
            </b-row>

            <div v-if="this.allDistricts.length === 0" class="text-center">
                <b-spinner type="grow" label="Loading..."></b-spinner>
            </div>

            <div v-else v-for="district in completedDistrictsList" class="border-bottom">
                <b-row class="py-3 mx-1 justify-content-center text-left">

                    <b-col xl="4" lg="4" md="4" class="justify-content-center text-md-left text-center order-md-1 order-2">
                        <div><small class="text-muted">#{{ district.id }}</small>
                            <strong>{{ district.name }}</strong>
                        </div>
                        <div v-if="district.is_hidden" class="badge badge-danger">скрыто</div>
                    </b-col>

                    <b-col xl="4" lg="4" md="4" class="text-md-left text-center order-md-3 order-4">
                        <div class="small text-muted">
                            <strong>{{ cityName(district.city_id) }}</strong>
                        </div>
                    </b-col>

                    <b-col xl="4" lg="4" md="4" class="text-right order-md-4 order-0">
                        <b-button
                            size="sm"
                            class="rounded text-muted"
                            variant="outline-light"
                            v-b-tooltip.hover
                            placement="bottom"
                            title="Редактировать"
                            @click="openModalDistrict(district.id)"
                        >
                            <i class="fa fa-ellipsis-v"></i>
                        </b-button>
                    </b-col>
                </b-row>
            </div>
        </div>
        <div v-else>
            <Page401 />
        </div>
    </div>
</template>

<script>
    import ModalDistrict from '../components/forms/District'
    import Page401 from './401'
    import { mapActions } from 'vuex'
    import { debounce } from 'lodash'

    export default {
        components: {
            Page401,
            ModalDistrict,
        },

        data() {
            return {
                selectedCity: 0,
                sortDistrictsBy: 0,
                searchText: '',
                sortVariants: ['По имени', 'По городам'],
                editableDistrictId: 0,
                showCreateDistrictModal: false
            }
        },

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            },

            allDistricts() {
                return this.$store.getters['districts/allDistricts'] || []
            },

            allCities() {
                return this.$store.getters['cities/allCities'] || []
            },

            // Фильтрация и сортировка пользователя
            districtsSortedByFilters() {
                if (this.allDistricts.length) {
                    let [...districts] = this.allDistricts

                    districts = this.selectedCity ? districts.filter(district => district.city_id === this.selectedCity) : districts

                    if (this.sortDistrictsBy) {
                        switch(this.sortDistrictsBy) {
                            case 1 : {
                                districts.sort((a, b) => {
                                    return a.name > b.name ? 1 : -1
                                })
                                break
                            }
                            case 2 : {
                                districts.sort((a, b) => a.city_id - b.city_id)
                                break
                            }
                        }
                    }
                    return districts
                }
                return []
            },

            // Поиск, по фильтрованным и сортированным районам
            completedDistrictsList() {
                let [...districts] = this.districtsSortedByFilters

                return districts.filter(district => {
                    if ((district.name.toLowerCase() || '').includes(this.searchText.toLowerCase()))

                        return district
                })
            }
        },

        methods: {

            // // Получаем экшены
            ...mapActions({
                getallDistricts: 'districts/getallDistricts',
                getAllCities: 'cities/getAllCities',
                showNotify: 'notifications/showNotify'
            }),

            // Добавляем данные при открытии модального окна
            openModalDistrict(id = null) {
                this.editableDistrictId = id
                this.showCreateDistrictModal = true
            },

            // Очищаем данные после закрытия модального окна
            closeModalDistrict() {
                this.showCreateDistrictModal = false
                this.editableDistrictId = null
            },

            searchByText: debounce(function(searchText) {
                this.searchText = searchText
            }, 200),

            // Название города по id
            cityName(cityId) {
                if (cityId) {
                    return this.allCities && this.allCities.length ?
                        this.allCities.find(city => city.id === cityId).name : ''
                }
            }
        },

        beforeMount() {
            this.$store.dispatch('users/getAuthUser');

            if (!this.allDistricts.length) {
                this.$store.dispatch('districts/getAllDistricts');
            }

            if (!this.allCities.length) {
                this.getAllCities()
            }
        },
    }
</script>
