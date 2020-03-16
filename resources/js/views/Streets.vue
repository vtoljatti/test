<template>
    <div>
        <div v-if="authUser">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        Улицы
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                    <b-button size="sm" @click="openModalStreet(0)" class="rounded-circle" variant="outline-success" v-b-tooltip.hover placement="bottom" title="Новый пользователь">
                        <i class="fa fa-plus"></i>
                    </b-button>

                    <ModalStreet v-if="showCreateStreetModal" @closeForm="closeModalStreet" :street-id="editableStreetId" />

                </b-col>
            </b-row>

            <b-row class="p-3 justify-content-left text-left bg-filter">
                <b-col xl="3" lg="3" md="4" class="my-1 justify-content-center">
                    <b-form-input type="search" v-model="searchText" @change="searchByText" placeholder="Поиск"/>
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
                    <b-form-select v-model="sortStreetsBy">
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

            <div v-if="this.allStreets.length === 0" class="text-center">
                <b-spinner type="grow" label="Loading..."></b-spinner>
            </div>

            <div v-else v-for="street in completedStreetsList" class="border-bottom">
                <b-row class="py-3 mx-1 justify-content-center text-left">

                    <b-col xl="4" lg="4" md="4" class="justify-content-center text-md-left text-center order-md-1 order-2">
                        <div><small class="text-muted">#{{ street.id }}</small>
                            <strong>{{ street.name }}</strong>
                        </div>
                        <div v-if="street.is_hidden" class="badge badge-danger">скрыто</div>
                    </b-col>

                    <b-col xl="4" lg="4" md="4" class="text-md-left text-center order-md-3 order-4">
                        <div class="small text-muted">
                            <strong>{{ cityName(street.city_id) }}</strong>
                            <div>{{ districtName(street.district_id) }}</div>
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
                            @click="openModalStreet(street.id)"
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
    import ModalStreet from '../components/forms/Street'
    import Page401 from './401'
    import { mapActions } from 'vuex'
    import { debounce } from 'lodash'

    export default {

        components: {
            Page401,
            ModalStreet,
        },

        data() {
            return {
                selectedCity: 0,
                sortStreetsBy: 0,
                searchText: '',
                sortVariants: ['По имени', 'По городам'],
                editableStreetId: 0,
                showCreateStreetModal: false
            }
        },

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            },

            // Берем Улицы
            allStreets() {
                return this.$store.getters['streets/allStreets'] || []
            },

            // Берем Города
            allCities() {
                return this.$store.getters['cities/allCities'] || []
            },

            // Берем Районы
            allDistricts() {
                return this.$store.getters['districts/allDistricts'] || []
            },

            // Фильтрация и сортировка пользователя
            streetsSortedByFilters() {
                if (this.allStreets.length) {
                    let [...streets] = this.allStreets

                    streets = this.selectedCity ? streets.filter(street => street.city_id === this.selectedCity) : streets

                    if (this.sortStreetsBy) {
                        switch(this.sortStreetsBy) {
                            case 1 : {
                                streets.sort((a, b) => {
                                    return a.name > b.name ? 1 : -1
                                })
                                break
                            }
                            case 2 : {
                                streets.sort((a, b) => a.city_id - b.city_id)
                                break
                            }
                        }
                    }
                    return streets
                }
                return []
            },

            // Поиск, по фильтрованным и сортированным улицам
            completedStreetsList() {
                let [...streets] = this.streetsSortedByFilters

                return streets.filter(street => {
                    if ((street.name.toLowerCase() || '').includes(this.searchText.toLowerCase()))

                        return street
                })
            }
        },
        methods: {

            // Получаем экшены
            ...mapActions({
                getAllCities: 'cities/getAllCities',
                getAllDistricts: 'districts/getAllDistricts',
                showNotify: 'notifications/showNotify'
            }),

            // Добавляем данные при открытии модального окна
            openModalStreet(id = null) {
                this.editableStreetId = id
                this.showCreateStreetModal = true
            },

            // Очищаем данные после закрытия модального окна
            closeModalStreet() {
                this.showCreateStreetModal = false
                this.editableStreetId = null
            },

            searchByText: debounce(function() {
                // разобраться
            }, 5000),

            // Название города по id
            cityName(cityId) {
                if (cityId) {
                    return this.allCities && this.allCities.length ?
                        this.allCities.find(city => city.id === cityId).name : ''
                }
            },

            // Название района по id
            districtName(districtId) {
                if (districtId) {
                    return this.allDistricts && this.allDistricts.length && this.allDistricts.find(district => district.id === districtId) ?
                        this.allDistricts.find(district => district.id === districtId).name : ''
                }
            },
        },

        beforeMount() {
            // Загружаем в store улицы
            if (!this.allStreets.length) {
                this.$store.dispatch('streets/getAllStreets');
            }

            // Загружаем в store города
            if (!this.allCities.length) {
                this.getAllCities()
            }

            // Загружаем в store города
            if (!this.allDistricts.length) {
                this.getAllDistricts()
            }
        },
    }
</script>
