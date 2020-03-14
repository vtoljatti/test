<template>
    <div>

        <b-row class="justify-content-center">
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

        <hr>

        <b-row class="pb-3 justify-content-center text-left">
            <b-col xl="3" lg="4" md="4" class="justify-content-center">
                <b-form-input type="search" v-model="searchText" @change="searchByText"/>
            </b-col>

            <b-col xl="3" lg="4" md="4" class="justify-content-center">
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

            <b-col xl="3" lg="4" md="4" class="justify-content-center">
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

            <b-col xl="3" lg="4" md="4" class="justify-content-center">
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

        <div class="border-bottom"></div>
        <div v-if="this.allUsers.length === 0" class="text-center">
            <b-spinner type="grow" label="Loading..."></b-spinner>
        </div>
        <div v-else v-for="user in completedUsersList" class="border-bottom">
            <b-row class="py-3 mx-1 justify-content-center text-left">
                <b-col xl="4" lg="4" md="4" class="justify-content-center text-md-left text-center order-md-1 order-2">
                    <div><small class="text-muted">#{{ user.id }}</small>
                        <strong>{{ user.name }}</strong>
                        <small class="text-muted">({{ user.short_name }})</small></div>
                    <div class="small text-muted">{{ user.phone }}</div>
                    <div class="small text-muted">{{ user.email }}</div>
                </b-col>
                <b-col xl="3" lg="3" md="3" class="text-md-left text-center order-md-2 order-3">
                    <div class="badge badge-success">{{ user.role }}</div>
                    <div v-if="user.is_hidden" class="badge badge-danger">скрыто</div>
                </b-col>
                <b-col xl="4" lg="4" md="4" class="text-md-left text-center order-md-3 order-4">
                    <div class="small text-muted">{{ cityName(user.city_id) }}</div>
                    <div class="small text-muted">{{ user.district_id }}</div>
                    <div class="small text-muted">{{ user.address }}</div>
                    <div class="small text-muted">{{ user.seller_id }}</div>
                    <div class="small text-muted">{{ user.is_hidden }}</div>
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
</template>

<script>
import ModalUser from '../components/forms/User'
import { mapActions } from 'vuex'
import { debounce } from 'lodash'

export default {
    components: {
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
        // allUsers() {
        //     return this.$store.state.users.users
        // },
        allUsers() {
            return this.$store.getters['users/allUsers'] || []
        },
        allCities() {
            return this.$store.getters['cities/allCities'] || []
        },
        allRoles() {
            return this.$store.getters['others/allRoles'] || []
        },
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
        completedUsersList() {
            let [...users] = this.usersSortedByFilters

            return users.filter(user => {
                if (user.email.includes(this.searchText) ||
                    user.name.toLowerCase().includes(this.searchText.toLowerCase()) ||
                    user.phone.includes(this.searchText)) return user
            })
        }
    },
    methods: {
        ...mapActions({
            getAllUsers: 'users/getAllUsers',
            getAllCities: 'cities/getAllCities',
            showNotify: 'notifications/showNotify'
        }),

        openModalUser(id = null) {
            this.editableUserId = id
            this.showCreateUserModal = true
        },

        closeModalUser() {
            this.showCreateUserModal = false
            this.editableUserId = null
        },

        searchByText: debounce(function() {

        }, 500),

        cityName(cityId) {
            return this.allCities && this.allCities.length ?
                this.allCities.find(city => city.id === cityId).name :
                'N/A'
        },

        handleHover(hovered) {
            this.isHovered = hovered
        }

    },
    beforeMount() {
        if (!this.allUsers.length) {
            this.getAllUsers()
            // this.$store.dispatch('users/getAllUsers')
            console.log('Загружены данные users/getAllUsers')
        }

        if (!this.allCities.length) {
            this.getAllCities()
            // this.$store.dispatch('cities/getAllCities')
            console.log('Загружены данные cities/getAllCities')
        }

        if (!this.allRoles.length) {
            this.$store.dispatch('others/getAllRoles');
            console.log('Загружены данные others/getAllRoles')
        }
    },
}
</script>
