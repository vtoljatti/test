<template>
    <div>
        <div v-if="authUser">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        Населенные пункты
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                    <b-button size="sm" @click="openModalVillage(0)" class="rounded-circle" variant="outline-success" v-b-tooltip.hover placement="bottom" title="Новый пользователь">
                        <i class="fa fa-plus"></i>
                    </b-button>

                    <ModalVillage v-if="showCreateVillageModal" @closeForm="closeModalVillage" :village-id="editableVillageId" />

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
                    <b-form-select v-model="sortVillagesBy">
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

            <div v-if="this.allVillages.length === 0" class="text-center">
                <b-spinner type="grow" label="Loading..."></b-spinner>
            </div>

            <div v-else v-for="village in completedVillagesList" class="border-bottom">
                <b-row class="py-3 mx-1 justify-content-center text-left">

                    <b-col xl="5" lg="5" md="5" class="justify-content-center text-md-left text-center order-md-1 order-2">
                        <div><small class="text-muted">#{{ village.id }}</small>
                            <strong>{{ village.name }}</strong>
                        </div>
                        <div v-if="village.is_hidden" class="badge badge-danger">скрыто</div>
                    </b-col>


                    <b-col xl="2" lg="2" md="2" class="text-md-left text-center order-md-3 order-4">
                        <div class="small text-muted">
                            {{ village.price }} руб.
                        </div>
                    </b-col>

                    <b-col xl="3" lg="3" md="3" class="text-md-left text-center order-md-3 order-4">
                        <div class="small text-muted">
                            <strong>{{ cityName(village.city_id) }}</strong>
                        </div>
                    </b-col>

                    <b-col xl="2" lg="2" md="2" class="text-right order-md-4 order-0">
                        <b-button
                            size="sm"
                            class="rounded text-muted"
                            variant="outline-light"
                            v-b-tooltip.hover
                            placement="bottom"
                            title="Редактировать"
                            @click="openModalVillage(village.id)"
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
    import ModalVillage from '../components/forms/Village'
    import Page401 from './401'
    import { mapActions } from 'vuex'
    import { debounce } from 'lodash'

    export default {

        components: {
            Page401,
            ModalVillage,
        },

        data() {
            return {
                selectedCity: 0,
                sortVillagesBy: 0,
                searchText: '',
                sortVariants: ['По имени', 'По городам'],
                editableVillageId: 0,
                showCreateVillageModal: false
            }
        },

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            },

            // Берем Районы
            allVillages() {
                return this.$store.getters['villages/allVillages'] || []
            },

            // Берем Города
            allCities() {
                return this.$store.getters['cities/allCities'] || []
            },

            // Фильтрация и сортировка пользователя
            villagesSortedByFilters() {
                if (this.allVillages.length) {
                    let [...villages] = this.allVillages

                    villages = this.selectedCity ? villages.filter(village => village.city_id === this.selectedCity) : villages

                    if (this.sortVillagesBy) {
                        switch(this.sortVillagesBy) {
                            case 1 : {
                                villages.sort((a, b) => {
                                    return a.name > b.name ? 1 : -1
                                })
                                break
                            }
                            case 2 : {
                                villages.sort((a, b) => a.city_id - b.city_id)
                                break
                            }
                        }
                    }
                    return villages
                }
                return []
            },

            // Поиск, по фильтрованным и сортированным
            completedVillagesList() {
                let [...villages] = this.villagesSortedByFilters

                return villages.filter(village => {
                    if ((village.name.toLowerCase() || '').includes(this.searchText.toLowerCase()))

                        return village
                })
            }
        },
        methods: {

            // // Получаем экшены
            ...mapActions({
                getallVillages: 'villages/getallVillages',
                getAllCities: 'cities/getAllCities',
                showNotify: 'notifications/showNotify'
            }),

            // Добавляем данные при открытии модального окна
            openModalVillage(id = null) {
                this.editableVillageId = id
                this.showCreateVillageModal = true
            },

            // Очищаем данные после закрытия модального окна
            closeModalVillage() {
                this.showCreateVillageModal = false
                this.editableVillageId = null
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
            }
        },

        beforeMount() {
            // Загружаем в store
            if (!this.allVillages.length) {
                this.$store.dispatch('villages/getAllVillages');
            }

            // Загружаем в store города
            if (!this.allCities.length) {
                this.getAllCities()
            }
        },
    }
</script>
