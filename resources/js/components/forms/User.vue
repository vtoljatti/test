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
<!--                <form @submit.prevent="createNewUserModal">-->
                <form @submit.prevent>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Имя</small>
                                <b-form-input
                                    class="text-center"
                                    type="text"
                                    v-model="name"
                                    placeholder="Имя"
                                />
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Короткое имя</small>
                                <b-form-input
                                    class="text-center"
                                    type="text"
                                    v-model="short_name"
                                    placeholder="Короткое имя"
                                />
                            </label>
                        </b-col>
                    </b-row>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>email</small>
                                <b-form-input
                                    class="text-center"
                                    type="text"
                                    v-model="email"
                                    placeholder="Email"
                                />
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
                            <label class="small text-left mx-1 w-100">
                                <small>Город</small>
                                <b-form-select v-model="city_id" class="mb-3">
                                    <b-form-select-option :value="null" disabled>Выберите город</b-form-select-option>
                                    <b-form-select-option v-for="city in allCities" :value="city.id">{{ city.name }}</b-form-select-option>
                                </b-form-select>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Район</small>
                                <b-form-select v-model="district_id" class="mb-3">
                                    <b-form-select-option :value="null" disabled>Без района</b-form-select-option>
                                    <b-form-select-option v-for="district in allDistricts" :value="district.id">{{ district.name }}</b-form-select-option>
                                </b-form-select>
                            </label>
                        </b-col>
                    </b-row>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Роль</small>
                                <b-form-select v-model="role" class="mb-3">
                                    <b-form-select-option :value="null" disabled>Выберите роль</b-form-select-option>
                                    <b-form-select-option v-for="role in allRoles" :value="role.role">{{ role.name }}</b-form-select-option>
                                </b-form-select>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Продавец</small>
                                <b-form-select v-model="seller_id" class="mb-3">
                                    <b-form-select-option :value="null" disabled>Продавец для магазина</b-form-select-option>
                                    <b-form-select-option v-for="seller in allSellers" :value="seller.id">{{ seller.name }}</b-form-select-option>
                                </b-form-select>
                            </label>
                        </b-col>
                    </b-row>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Пароль</small>
                                <b-form-input
                                    class="text-center"
                                    type="password"
                                    v-model="password"
                                />
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label v-if="password.trim()" class="small text-left mx-1 w-100">
                                <small>Подтверждение пароля</small>
                                <b-form-input
                                    class="text-center"
                                    type="password"
                                    v-model="password_confirmation"
                                />
                            </label>
                        </b-col>
                    </b-row>

                    <div class="text-left p-2">
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
                            @click="addNewUser"
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
        role: 'guest',
        city_id: 0,
        district_id: 0,
        seller_id: 0,
        is_hidden: 0,
        password: '',
        password_confirmation: '',
        isEditMode: false
    }),

    computed: {
        allCities() {
            return this.$store.getters['cities/allCities']
        },
        allDistricts() {
            return this.$store.getters['cities/allDistricts']
        },
        allRoles() {
            return this.$store.getters['others/allRoles']
        },
        allSellers() {
            return this.$store.getters['sellers/allSellers']
        }
    },

    methods: {
        ...mapActions({
            showNotify: 'notifications/showNotify'
        }),

        addNewUser() {
            if (this.name && this.name.trim() && this.short_name && this.short_name.trim() &&
                this.email && this.email.trim() && this.phone && this.phone.trim() && this.city_id) {

                let userData = {
                    name: this.name.trim(),
                    short_name: this.short_name.trim(),
                    email: this.email.trim(),
                    phone: this.phone.trim(),
                    role: this.role,
                    city_id: this.city_id,
                    district_id: this.district_id,
                    seller_id: this.seller_id,
                    is_hidden: this.is_hidden,
                }

                if (!this.userId) { // режим создания
                    if (this.password.trim() && this.password_confirmation.trim() &&
                        this.password.trim() === this.password_confirmation.trim()) {

                        userData.password = this.password.trim()
                        userData.password_confirmation = this.password_confirmation.trim()

                        this.$store.dispatch('users/addNewUser', userData)
                            .then(() => {

                                this.hideUserModal()
                            })
                            .catch(err => console.error(err))
                    }
                } else {
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
                }
            } else {
                return
            }
        },
        showNewUserModal() {
            this.$refs['newUserModal'].show()
        },
        hideUserModal() {
            this.$refs.newUserModal.hide()
            this.$emit('closeForm')
        },
        createNewUserModal() {
            console.log('Форма отправлена')
        }
    },

    beforeMount() {
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
        this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
            if (bvEvent.trigger === 'backdrop') bvEvent.preventDefault()
        })

        if (!this.allCities.length) {
            this.$store.dispatch('cities/getAllCities');
            console.log('Загружены данные 2 cities/getAllCities')
        }

        if (!this.allDistricts.length) {
            this.$store.dispatch('cities/getAllDistricts');
            console.log('Загружены данные cities/getAllDistricts')
        }

        if (!this.allRoles.length) {
            this.$store.dispatch('others/getAllRoles');
            console.log('Загружены данные others/getAllRoles')
        }

        if (!this.allSellers.length) {
            this.$store.dispatch('sellers/getAllSellers');
            console.log('Загружены данные sellers/getAllSellers')
        }

        this.$refs['newUserModal'].show()
    }
}
</script>
