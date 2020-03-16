<template>
    <div>
        <b-modal ref="newUserModal" size="lg" hide-footer hide-header>

            <b-row>
                <b-col class="text-left pb-1">
                    <span class="h5 p-0 m-0 text-muted font-weight-normal">
                        {{ id ? 'Редактирование' : 'Новый пользователь' }}
                    </span>
                </b-col>
                <b-col class="text-right justify-content-top">
                    <button @click="hideUserModal" class="btn btn-white text-muted font-weight-normal">
                        <i class="fa fa-close"></i>
                    </button>
                </b-col>
            </b-row>

            <div class="d-block text-center p-2">
                <form @submit.prevent>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Имя</small>
                                <b-form-input
                                    class="text-center"
                                    :class="{'border-danger': validateName}"
                                    type="text"
                                    v-model="name"
                                    placeholder="Имя"
                                />
                                <small v-if="validateNameMessage" class="text-danger font-weight-bold">{{ validateNameMessage }}</small>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Короткое имя</small>
                                <b-form-input
                                    class="text-center"
                                    :class="{'border-danger': validateShortName}"
                                    type="text"
                                    v-model="short_name"
                                    placeholder="Короткое имя"
                                />
                                <small v-if="validateShortNameMessage" class="text-danger font-weight-bold">{{ validateShortNameMessage }}</small>
                            </label>
                        </b-col>
                    </b-row>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>email</small>
                                <b-form-input
                                    class="text-center"
                                    :class="{'border-danger': validateEmail}"
                                    type="text"
                                    v-model="email"
                                    placeholder="Email"
                                />
                                <small v-if="validateEmailMessage" class="text-danger font-weight-bold">{{ validateEmailMessage }}</small>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Телефон</small>
                                <b-form-input
                                    class="text-center"
                                    type="text"
                                    v-model="phone"
                                    placeholder="Телефон"
                                />
                            </label>
                        </b-col>
                    </b-row>

                    <b-row class="d-flex justify-content-between">

                        <b-col md="6" sm="12">
                            <label v-if="this.authUser.role === 'admin' || this.authUser.role === 'warehouse' || this.authUser.id === 1" class="small text-left mx-1 w-100 mb-3">
                                <small>Роль</small>
                                <b-form-select v-model="role" :class="{'border-danger': validateRole}">
                                    <b-form-select-option :value="null" disabled>Выберите роль</b-form-select-option>
                                    <b-form-select-option v-for="role in allRoles" :value="role.role">{{ role.name }}</b-form-select-option>
                                </b-form-select>
                                <small v-if="validateRoleMessage" class="text-danger font-weight-bold">{{ validateRoleMessage }}</small>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100 mb-3" v-if="this.authUser.role === 'admin' || this.authUser.role === 'warehouse'">
                                <small>Город</small>
                                <b-form-select v-model="city_id" :class="{'border-danger': validateCity}">
                                    <b-form-select-option :value="null" disabled>Выберите город</b-form-select-option>
                                    <b-form-select-option v-for="city in allCities" :value="city.id">{{ city.name }}</b-form-select-option>
                                </b-form-select>
                                <small v-if="validateCityMessage" class="text-danger font-weight-bold">{{ validateCityMessage }}</small>
                            </label>
                        </b-col>

                    </b-row>

                    <b-row class="d-flex justify-content-between">

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100 mb-3">
                                <small>Район</small>
                                <b-form-select v-model="district_id">
                                    <b-form-select-option value="0">Без района</b-form-select-option>
                                    <b-form-select-option v-for="district in districtsCity" :value="district.id">{{ district.name }}</b-form-select-option>
                                </b-form-select>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100 mb-3">
                                <small>Продавец (для магазинов)</small>
                                <b-form-select v-model="seller_id">
                                    <b-form-select-option value="0">Нет продавца</b-form-select-option>
                                    <b-form-select-option v-for="seller in sellersCity" :value="seller.id">{{ seller.name }}</b-form-select-option>
                                </b-form-select>
                            </label>
                        </b-col>

                    </b-row>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>{{ id ? 'Новый пароль (не обязательно)' : 'Пароль'}}</small>
                                <b-form-input
                                    class="text-center"
                                    type="password"
                                    v-model="password"
                                    :class="{'border-danger': validatePassword}"
                                />
                                <small v-if="validatePasswordMessage" class="text-danger font-weight-bold">{{ validatePasswordMessage }}</small>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label v-if="password.trim()" class="small text-left mx-1 w-100">
                                <small>Подтверждение пароля</small>
                                <b-form-input
                                    class="text-center"
                                    type="password"
                                    v-model="password_confirmation"
                                    :class="{'border-danger': validatePasswordConfirmation}"
                                />
                                <small v-if="validatePasswordConfirmationMessage" class="text-danger font-weight-bold">{{ validatePasswordConfirmationMessage }}</small>
                            </label>
                        </b-col>
                    </b-row>

                    <div class="text-left p-2" v-if="this.authUser.role === 'admin' || this.authUser.role === 'warehouse'">
                        <b-form-checkbox
                            v-model="is_hidden"
                            name="is_hidden"
                            value="1"
                            unchecked-value="0"
                            :state="false"
                        >
                            Скрыть
                        </b-form-checkbox>
                    </div>

                    <br>
                    <div class="form-group">
                        <button
                            type="submit"
                            class="btn btn-success"
                            :class="[id ? 'btn-warning' : 'btn-success']"
                            @click="submitFormUser"
                        >
                            {{ id ? 'Изменить' : 'Добавить' }}
                        </button>
                    </div>
                </form>
            </div>
        </b-modal>

    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {

    props: {
      userId: {
          type: Number,
          default: 0,
          required: true
      }
    },

    data: () => ({
        id: null,
        name: '',
        short_name: '',
        email: '',
        phone: '',
        role: '',
        city_id: 0,
        district_id: 0,
        seller_id: 0,
        is_hidden: 0,
        password: '',
        password_confirmation: '',
        isEditMode: false,

        isValidate: false,
        validateName: false,
        validateNameMessage: false,
        validateShortName: false,
        validateShortNameMessage: false,
        validateEmail: false,
        validateEmailMessage: false,
        validateRole: false,
        validateRoleMessage: false,
        validateCity: false,
        validateCityMessage: false,
        validatePassword: false,
        validatePasswordMessage: false,
        validatePasswordConfirmation: false,
        validatePasswordConfirmationMessage: false,

        messageRequiredField: 'Поле обязательно для заполнения'
    }),

    computed: {
        authUser() {
            return this.$store.getters['users/authUser'] || []
        },
        allCities() {
            return this.$store.getters['cities/allCities'] || []
        },
        allDistricts() {
            return this.$store.getters['districts/allDistricts'] || []
        },
        allRoles() {
            return this.$store.getters['others/allRoles'] || []
        },
        allSellers() {
            return this.$store.getters['sellers/allSellers'] || []
        },

        // Меняем список районов в зависимости от города
        districtsCity() {
            if (this.allDistricts.length) {
                let [...districts] = this.allDistricts
                return this.city_id ? districts.filter(district => district.city_id === this.city_id) : districts
            }
            return []
        },

        // Меняем список продавцов в зависимости от города
        sellersCity() {
            if (this.allSellers.length) {
                let [...sellers] = this.allSellers
                return this.city_id ? sellers.filter(seller => seller.city_id === this.city_id) : sellers
            }
            return []
        },
    },

    methods: {
        ...mapActions({
            showNotify: 'notifications/showNotify'
        }),

        // Проверяем и отправляем данные
        submitFormUser() {

            // Валидируем данные
            if (!this.validateName && !this.validateShortName && !this.validateEmail && !this.validateRole &&
                !this.validateCity && !this.validatePassword && !this.validatePasswordConfirmation) {
                this.isValidate = true
            } else {
                this.isValidate = false
                this.showNotify({message: 'Некоректные данные', variant: 'danger'})
            }

            if (this.isValidate) {

                // Устанавливаем данные
                let userData = {
                    name: this.name.trim(),
                    short_name: this.short_name.trim(),
                    email: this.email.trim(),
                    phone: this.phone,
                    role: this.role,
                    city_id: this.city_id,
                    district_id: this.district_id,
                    seller_id: this.seller_id,
                    is_hidden: this.is_hidden,
                }

                if (!this.userId) {

                    userData.password = this.password.trim()
                    userData.password_confirmation = this.password_confirmation.trim()

                    // режим создания
                    this.$store.dispatch('users/addNewUser', userData)
                        .then(res => {
                            this.hideUserModal()
                            this.showNotify({ message: res, variant: 'success' })
                        })
                        .catch(
                            errors => {
                                if (Array.isArray(errors)) {
                                    errors.forEach(err => {
                                        this.showNotify({message: err, variant: 'danger'})
                                    })
                                } else {
                                    this.showNotify({message: errors, variant: 'danger'})
                                }
                            })

                } else {
                    // режим редактирования
                    userData.id = this.id
                    if (this.password.trim()) {
                        if (this.password.trim() === this.password_confirmation.trim()) {
                            userData.password = this.password.trim()
                            userData.password_confirmation = this.password_confirmation.trim()
                        }
                    }
                    this.$store.dispatch('users/updateUser', userData)
                        .then(res => {
                            this.hideUserModal()
                            this.showNotify({ message: res, variant: 'success' })
                        })
                        .catch(
                            errors => {
                                if (Array.isArray(errors)) {
                                    errors.forEach(err => {
                                        this.showNotify({message: err, variant: 'danger'})
                                    })
                                } else {
                                    this.showNotify({message: errors, variant: 'danger'})
                                }
                            }
                        )
                    if (this.authUser.id === this.id) {
                        window.location.reload()
                    }
                }
            } else {
                return
            }
        },

        // Закрываем модальное окно
        hideUserModal() {
            this.$refs.newUserModal.hide()
            this.$emit('closeForm')
        },

        // Название города по id
        cityName(cityId) {
            if (cityId) {
                return this.allCities && this.allCities.length ?
                    this.allCities.find(city => city.id === cityId).name : ''
            }
        },

        сheckName() {
            // Валидация
            if (!this.name && !this.name.trim()) {
                this.validateName = true
                this.validateNameMessage = this.messageRequiredField
            } else {
                this.validateName = false
                this.validateNameMessage = false
            }
        },

        сheckShortName() {
            // Валидация
            if (!this.short_name && !this.short_name.trim()) {
                this.validateShortName = true
                this.validateShortNameMessage = this.messageRequiredField
            } else {
                this.validateShortName = false
                this.validateShortNameMessage = false
            }
        },

        сheckEmail() {
            // Валидация
            if (!this.email && !this.email.trim()) {
                this.validateEmail = true
                this.validateEmailMessage = this.messageRequiredField
            } else {
                this.validateEmail = false
                this.validateEmailMessage = false
            }
        },

        сheckCityId() {
            // Валидация
            if (!this.city_id) {
                this.validateCity = true
                this.validateCityMessage = this.messageRequiredField
            } else {
                this.validateCity = false
                this.validateCityMessage = false
            }
        },

        сheckRole() {
            // Валидация
            if (!this.role) {
                this.validateRole = true
                this.validateRoleMessage = this.messageRequiredField
            } else {
                this.validateRole = false
                this.validateRoleMessage = false
            }
        },

        сheckPassword() {
            // Валидация
            if (!this.userId) {
                if (!this.password.trim()) {
                    this.validatePassword = true
                    this.validatePasswordMessage = this.messageRequiredField
                } else {
                    this.validatePassword = false
                    this.validatePasswordMessage = false
                }
                this.matchCheckPassword()
            } else {
                if (this.password.trim()) {
                    if (!this.password_confirmation.trim()) {
                        this.validatePassword = true
                        this.validatePasswordMessage = this.messageRequiredField
                    } else {
                        this.validatePassword = false
                        this.validatePasswordMessage = false
                    }
                    this.matchCheckPassword()
                } else {
                    this.validatePassword = false
                    this.validatePasswordMessage = false
                }
            }
        },

        сheckPasswordConfirmation() {
            // Валидация
            if (!this.userId) {
                if (!this.password_confirmation.trim()) {
                    this.validatePasswordConfirmation = true
                    this.validatePasswordConfirmationMessage = this.messageRequiredField
                } else {
                    this.validatePasswordConfirmation = false
                    this.validatePasswordConfirmationMessage = false
                }
                this.matchCheckPassword()
            } else {
                if (this.password.trim()) {
                    if (!this.password_confirmation.trim()) {
                        this.validatePasswordConfirmation = true
                        this.validatePasswordConfirmationMessage = this.messageRequiredField
                    } else {
                        this.validatePasswordConfirmation = false
                        this.validatePasswordConfirmationMessage = false
                    }
                    this.matchCheckPassword()
                } else {
                    this.validatePassword = false
                    this.validatePasswordMessage = false
                    this.validatePasswordConfirmation = false
                    this.validatePasswordConfirmationMessage = false
                }
            }
        },

        matchCheckPassword() {
            if (this.password.trim() || this.password_confirmation.trim()) {
                if (this.password.trim() !== this.password_confirmation.trim()) {
                    this.validatePasswordConfirmation = true
                    this.validatePasswordConfirmationMessage = 'Пароли не совподают'
                    this.validatePassword = true
                    this.validatePasswordMessage = 'Пароли не совподают'
                } else {
                    this.validatePasswordConfirmation = false
                    this.validatePasswordConfirmationMessage = false
                    this.validatePassword = false
                    this.validatePasswordMessage = false
                }
            }
        }
    },

    watch: {
        name: function (val) {
            this.сheckName()
        },

        short_name: function (val) {
            this.сheckShortName()
        },

        email: function (val) {
            this.сheckEmail()
        },

        city_id: function (val) {
            this.сheckCityId()
        },

        role: function (val) {
            this.сheckRole()
        },

        password: function (val) {
            this.сheckPassword()
            this.сheckPasswordConfirmation()
        },

        password_confirmation: function (val) {
            this.сheckPasswordConfirmation()
        }
    },

    beforeMount() {
        this.сheckName()
        this.сheckShortName()
        this.сheckEmail()
        this.сheckCityId()
        this.сheckRole()
        this.сheckPassword()
        this.сheckPasswordConfirmation()

        // Устанавливаем значения в режиме редактирования
        if (this.userId) {
            this.$store.dispatch('users/getOneUserById', this.userId)
                .then(res => {
                    this.id = res.id
                    this.name = res.name
                    this.short_name = res.short_name
                    this.email = res.email
                    this.phone = res.phone
                    this.role = res.role
                    this.city_id = res.city_id
                    this.district_id = res.district_id
                    this.seller_id = res.seller_id
                    this.is_hidden = res.is_hidden
                })
                .catch(err => console.error(err))
        }
    },

    mounted() {

        // Запрещаем закрытие модального окна по заднему фону
        this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
            if (bvEvent.trigger === 'backdrop') bvEvent.preventDefault()
        })

        // Загружаем в store города
        if (!this.allCities.length) {
            this.$store.dispatch('cities/getAllCities');
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

        // Показываем модально окно
        this.$refs['newUserModal'].show()
    }
}
</script>
