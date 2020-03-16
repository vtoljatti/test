<template>
    <div>
        <div v-if="authUser">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        Продавцы
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                    <b-button size="sm" @click="openModalSeller(0)" class="rounded-circle" variant="outline-success" v-b-tooltip.hover placement="bottom" title="Новый пользователь">
                        <i class="fa fa-plus"></i>
                    </b-button>

                    <ModalSeller v-if="showCreateSellerModal" @closeForm="closeModalSeller" :seller-id="editableSellerId" />

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
                    <b-form-select v-model="sortSellersBy">
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

            <div v-if="this.allSellers.length === 0" class="text-center">
                <b-spinner type="grow" label="Loading..."></b-spinner>
            </div>

            <div v-else v-for="seller in completedSellersList" class="border-bottom">
                <b-row class="py-3 mx-1 justify-content-center text-left">

                    <b-col xl="4" lg="4" md="4" class="justify-content-center text-md-left text-center order-md-1 order-2">
                        <div><small class="text-muted">#{{ seller.id }}</small>
                            <strong>{{ seller.name }}</strong>
                        </div>
                        <div v-if="seller.is_hidden" class="badge badge-danger">скрыто</div>
                    </b-col>

                    <b-col xl="4" lg="4" md="4" class="text-md-left text-center order-md-3 order-4">
                        <div class="small text-muted">
                            <strong>{{ cityName(seller.city_id) }}</strong>
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
                            @click="openModalSeller(seller.id)"
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
import ModalSeller from '../components/forms/Seller'
import Page401 from './401'
import { mapActions } from 'vuex'
import { debounce } from 'lodash'

export default {

    components: {
        Page401,
        ModalSeller,
    },

    data() {
        return {
            selectedCity: 0,
            sortSellersBy: 0,
            searchText: '',
            sortVariants: ['По имени', 'По городам'],
            editableSellerId: 0,
            showCreateSellerModal: false
        }
    },

    computed: {
        authUser() {
            return this.$store.getters['users/authUser'] || []
        },

        // Берем Продавцов
        allSellers() {
            return this.$store.getters['sellers/allSellers'] || []
        },

        // Берем Города
        allCities() {
            return this.$store.getters['cities/allCities'] || []
        },

        // Фильтрация и сортировка пользователя
        sellersSortedByFilters() {
            if (this.allSellers.length) {
                let [...sellers] = this.allSellers

                sellers = this.selectedCity ? sellers.filter(seller => seller.city_id === this.selectedCity) : sellers

                if (this.sortSellersBy) {
                    switch(this.sortSellersBy) {
                        case 1 : {
                            sellers.sort((a, b) => {
                                return a.name > b.name ? 1 : -1
                            })
                            break
                        }
                        case 2 : {
                            sellers.sort((a, b) => a.city_id - b.city_id)
                            break
                        }
                    }
                }
                return sellers
            }
            return []
        },

        // Поиск, по фильтрованным и сортированным продавцов
        completedSellersList() {
            let [...sellers] = this.sellersSortedByFilters

            return sellers.filter(seller => {
                if ((seller.name.toLowerCase() || '').includes(this.searchText.toLowerCase()))

                    return seller
            })
        }
    },
    methods: {

        // // Получаем экшены
        ...mapActions({
            getallSellers: 'sellers/getallSellers',
            getAllCities: 'cities/getAllCities',
            showNotify: 'notifications/showNotify'
        }),

        // Добавляем данные при открытии модального окна
        openModalSeller(id = null) {
            this.editableSellerId = id
            this.showCreateSellerModal = true
        },

        // Очищаем данные после закрытия модального окна
        closeModalSeller() {
            this.showCreateSellerModal = false
            this.editableSellerId = null
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
        // Загружаем в store продавцов
        if (!this.allSellers.length) {
            this.$store.dispatch('sellers/getAllSellers');
        }

        // Загружаем в store города
        if (!this.allCities.length) {
            this.getAllCities()
        }
    },
}
</script>
