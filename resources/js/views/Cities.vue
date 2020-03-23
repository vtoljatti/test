<template>
    <div>
        <div v-if="authUser">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        Города
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                    <b-button size="sm"
                              @click="openModalCity(0)"
                              class="rounded-circle"
                              variant="outline-success"
                              v-b-tooltip.hover
                              placement="bottom"
                              title="Новый пользователь"
                    >
                        <i class="fa fa-plus"></i>
                    </b-button>

                    <ModalCity v-if="showCreateCityModal" @closeForm="closeModalCity" :city-id="editableCityId" />

                </b-col>
            </b-row>

            <b-row class="p-3 justify-content-left text-left bg-filter">
                <b-col xl="3" lg="3" md="4" class="my-1 justify-content-center">
                    <b-form-input type="search" v-model="searchText" @input="searchByText($event)" placeholder="Поиск"/>
                </b-col>

                <b-col xl="6" lg="6" md="6" class="my-1 justify-content-center"></b-col>

                <b-col xl="3" lg="3" md="4" class="my-1 justify-content-center">
                    <b-form-select v-model="sortCitiesBy">
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

            <div v-if="this.allCities.length === 0" class="text-center">
                <b-spinner type="grow" label="Loading..."></b-spinner>
            </div>

            <div v-else v-for="city in completedCitiesList" class="border-bottom">
                <b-row class="py-3 mx-1 justify-content-center text-left">

                    <b-col xl="4" lg="4" md="4" class="justify-content-center text-md-left text-center order-md-1 order-2">
                        <div><small class="text-muted">#{{ city.id }}</small>
                            <strong>{{ city.name }}</strong>
                        </div>
                        <div v-if="city.is_hidden" class="badge badge-danger">скрыто</div>
                    </b-col>

                    <b-col xl="8" lg="8" md="8" class="text-right order-md-4 order-0">
                        <b-button
                            size="sm"
                            class="rounded text-muted"
                            variant="outline-light"
                            v-b-tooltip.hover
                            placement="bottom"
                            title="Редактировать"
                            @click="openModalCity(city.id)"
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
    import ModalCity from '../components/forms/City'
    import Page401 from './401'
    import { mapActions } from 'vuex'
    import { debounce } from 'lodash'

    export default {

        components: {
            Page401,
            ModalCity,
        },

        data() {
            return {
                selectedCity: 0,
                sortCitiesBy: 0,
                searchText: '',
                sortVariants: ['По имени'],
                editableCityId: 0,
                showCreateCityModal: false
            }
        },

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            },

            // Берем Города
            allCities() {
                return this.$store.getters['cities/allCities'] || []
            },

            // Фильтрация и сортировка пользователя
            citiesSortedByFilters() {
                if (this.allCities.length) {
                    let [...cities] = this.allCities

                    if (this.sortCitiesBy) {
                        switch(this.sortCitiesBy) {
                            case 1 : {
                                cities.sort((a, b) => {
                                    return a.name > b.name ? 1 : -1
                                })
                                break
                            }
                        }
                    }
                    return cities
                }
                return []
            },

            // Поиск, по фильтрованным и сортированным продавцов
            completedCitiesList() {
                let [...cities] = this.citiesSortedByFilters

                return cities.filter(city => {
                    if ((city.name.toLowerCase() || '').includes(this.searchText.toLowerCase()))

                        return city
                })
            }
        },

        methods: {
            // Получаем экшены
            ...mapActions({
                getAllCities: 'cities/getAllCities',
                showNotify: 'notifications/showNotify'
            }),

            searchByText: debounce(function(searchText) {
                this.searchText = searchText
            }, 200),

            // Добавляем данные при открытии модального окна
            openModalCity(id = null) {
                this.editableCityId = id
                this.showCreateCityModal = true
            },

            // Очищаем данные после закрытия модального окна
            closeModalCity() {
                this.showCreateCityModal = false
                this.editableCityId = null
            },
        },

        beforeMount() {
            this.$store.dispatch('users/getAuthUser');

            // Загружаем в store города
            if (!this.allCities.length) {
                this.getAllCities()
            }
        }
    }
</script>
