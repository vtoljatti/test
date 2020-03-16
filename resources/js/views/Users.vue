<template>
    <div>
        <div v-if="authUser.role === 'admin' || authUser.role === 'warehouse'">
            <b-row class="justify-content-center pb-3">
                <b-col class="justify-content-center text-md-left text-center">
                    <strong class="text-muted h5 font-weight-normal">
                        Пользователи
                    </strong>
                </b-col>
                <b-col class="justify-content-center text-md-right text-center">

                    <b-button size="sm" @click="openModalUser(0)" class="rounded-circle" variant="outline-success" v-b-tooltip.hover placement="bottom" title="Новый пользователь">
                        <i class="fa fa-plus"></i>
                    </b-button>

                    <ModalUser v-if="showCreateUserModal" @closeForm="closeModalUser" :user-id="editableUserId" />

                </b-col>
            </b-row>

            <b-row class="p-3 justify-content-center text-left bg-filter">
                <b-col xl="3" lg="3" md="6" class="my-1 justify-content-center">
                    <b-form-input type="search" v-model="searchText" @change="searchByText" placeholder="Поиск"/>
                </b-col>

                <b-col xl="3" lg="3" md="6" class="my-1 justify-content-center">
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

                <b-col xl="3" lg="3" md="6" class="my-1 justify-content-center">
                    <b-form-select v-model="selectedRole">
                        <b-form-select-option :value="0">Все роли</b-form-select-option>
                        <b-form-select-option
                            v-for="oneRole in allRoles"
                            :value="oneRole.role"
                            :key="oneRole.role"
                        >
                            {{ oneRole.name }}
                        </b-form-select-option>
                    </b-form-select>
                </b-col>

                <b-col xl="3" lg="3" md="6" class="my-1 justify-content-center">
                    <b-form-select v-model="sortUsersBy">
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

            <div v-if="this.allUsers.length === 0" class="text-center">
                <b-spinner type="grow" label="Loading..."></b-spinner>
            </div>

            <div v-else v-for="user in completedUsersList" class="border-bottom">
                <b-row class="py-3 mx-1 justify-content-center text-left">

                    <b-col xl="4" lg="4" md="4" class="justify-content-center text-md-left text-center order-md-1 order-2">
                        <div><small class="text-muted">#{{ user.id }}</small>
                            <strong>{{ user.name }}</strong>
                            <small class="text-muted">({{ user.short_name }})</small>
                        </div>
                        <div class="small text-muted" v-if="user.seller_id">{{ sellerName(user.seller_id) }}</div>
                        <div v-if="user.is_hidden" class="badge badge-danger">скрыто</div>
                    </b-col>

                    <b-col xl="3" lg="3" md="3" class="text-md-left text-center order-md-2 order-3">
                        <b-badge :variant="badgeVariant(user.role)">{{ roleName(user.role) }}</b-badge>
                    </b-col>

                    <b-col xl="4" lg="4" md="4" class="text-md-left text-center order-md-3 order-4">
                        <div class="small text-muted">
                            <strong>{{ cityName(user.city_id) }}</strong>
                            <span v-if="user.district_id">({{ districtName(user.district_id) }})</span>
                        </div>
                        <div class="small text-muted">{{ user.phone }}</div>
                        <div class="small text-muted">{{ user.email }}</div>

                    </b-col>

                    <b-col xl="1" lg="1" md="1" class="text-right order-md-4 order-0">
                        <b-button
                            size="sm"
                            class="rounded text-muted"
                            variant="outline-light"
                            v-b-tooltip.hover
                            placement="bottom"
                            title="Редактировать"
                            @click="openModalUser(user.id)"
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
import ModalUser from '../components/forms/User'
import Page401 from './401'
import { mapActions } from 'vuex'
import { debounce } from 'lodash'

export default {

    components: {
        Page401,
        ModalUser,
    },

    data() {
        return {
            selectedCity: 0,
            selectedRole: 0,
            sortUsersBy: 0,
            isHovered: false,
            showCreateUserModal: false,
            sortVariants: ['По имени', 'По ролям', 'По городам'],
            searchText: '',
            editableUserId: 0
        }
    },

    computed: {
        authUser() {
            return this.$store.getters['users/authUser'] || []
        },

        // Берем Пользователей
        allUsers() {
            return this.$store.getters['users/allUsers'] || []
        },

        // Берем Города
        allCities() {
            return this.$store.getters['cities/allCities'] || []
        },

        // Берем Роли
        allRoles() {
            return this.$store.getters['others/allRoles'] || []
        },

        // Берем Районы
        allDistricts() {
            return this.$store.getters['districts/allDistricts'] || []
        },

        // Берем Продавцов
        allSellers() {
            return this.$store.getters['sellers/allSellers'] || []
        },

        // Фильтрация и сортировка пользователя
        usersSortedByFilters() {
            if (this.allUsers.length) {
                let [...users] = this.allUsers

                users = this.selectedCity ? users.filter(user => user.city_id === this.selectedCity) : users
                users = this.selectedRole ? users.filter(user => user.role === this.selectedRole) : users

                if (this.sortUsersBy) {
                    switch(this.sortUsersBy) {
                        case 1 : {
                            users.sort((a, b) => {
                                return a.name > b.name ? 1 : -1
                            })
                            break
                        }
                        case 2 : {
                            users.sort((a, b) => {
                                return a.role > b.role ? 1 : -1
                            })
                            break
                        }
                        case 3 : {
                            users.sort((a, b) => a.city_id - b.city_id)
                            break
                        }
                    }
                }
                return users
            }
            return []
        },

        // Поиск, по фильтрованным и сортированным пользователям
        completedUsersList() {
            let [...users] = this.usersSortedByFilters

            return users.filter(user => {
                if ((user.email.toLowerCase() || '').includes(this.searchText.toLowerCase()) ||
                    (user.name.toLowerCase() || '').includes(this.searchText.toLowerCase()) ||
                    (user.phone || '').includes(this.searchText))

                    return user
            })
        }
    },
    methods: {

        // Получаем экшены
        ...mapActions({
            getAllUsers: 'users/getAllUsers',
            getAllCities: 'cities/getAllCities',
            showNotify: 'notifications/showNotify'
        }),

        // Добавляем данные при открытии модального окна
        openModalUser(id = null) {
            this.editableUserId = id
            this.showCreateUserModal = true
        },

        // Очищаем данные после закрытия модального окна
        closeModalUser() {
            this.showCreateUserModal = false
            this.editableUserId = null
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
                return this.allDistricts && this.allDistricts.length ?
                    this.allDistricts.find(district => district.id === districtId).name : ''
            }
        },

        // Имя продавца по id
        sellerName(sellerId) {
            if (sellerId) {
                return this.allSellers && this.allSellers.length ?
                    this.allSellers.find(seller => seller.id === sellerId).name : ''
            }
        },

        // Стиль роли по id
        badgeVariant(variantName) {
            if (variantName) {
                return this.allRoles && this.allRoles.length ?
                    this.allRoles.find(role => role.role === variantName).variant : ''
            }
        },

        // Роль по id
        roleName(roleName) {
            if (roleName) {
                return this.allRoles && this.allRoles.length ?
                    this.allRoles.find(role => role.role === roleName).name : ''
            }
        }
    },

    beforeMount() {
        // Загружаем в store пользователей
        if (!this.allUsers.length) {
            this.getAllUsers()
        }

        // Загружаем в store города
        if (!this.allCities.length) {
            this.getAllCities()
        }

        // Загружаем в store районы
        if (!this.allDistricts.length) {
            this.$store.dispatch('districts/getAllDistricts');
        }

        // Загружаем в store роли
        if (!this.allRoles.length) {
            this.$store.dispatch('others/getAllRoles');
        }

        // Загружаем в store продавцов
        if (!this.allSellers.length) {
            this.$store.dispatch('sellers/getAllSellers');
        }
    },
}
</script>
