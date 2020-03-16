<template>
    <div>
        <b-modal ref="newStreetModal" size="lg" hide-footer hide-header>

            <b-row>
                <b-col class="text-left pb-1">
                    <span class="h5 p-0 m-0 text-muted font-weight-normal">
                        {{ id ? 'Редактирование' : 'Новая улица' }}
                    </span>
                </b-col>
                <b-col class="text-right justify-content-top">
                    <button @click="hideStreetModal" class="btn btn-white text-muted font-weight-normal">
                        <i class="fa fa-close"></i>
                    </button>
                </b-col>
            </b-row>

            <div class="d-block text-center p-2">
                <form @submit.prevent>

                    <b-row class="d-flex justify-content-between">
                        <b-col md="12" sm="12">
                            <label class="small text-left mx-1 w-100">
                                <small>Название</small>
                                <b-form-input
                                    class="text-center"
                                    :class="{'border-danger': validateName}"
                                    type="text"
                                    v-model="name"
                                    placeholder="Название"
                                />
                                <small v-if="validateNameMessage" class="text-danger font-weight-bold">{{ validateNameMessage }}</small>
                            </label>
                        </b-col>

                    </b-row>

                    <b-row class="d-flex justify-content-between">

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100 mb-3">
                                <small>Город</small>
                                <b-form-select v-model="city_id" :class="{'border-danger': validateCity}">
                                    <b-form-select-option :value="null" disabled>Выберите город</b-form-select-option>
                                    <b-form-select-option v-for="city in allCities" :value="city.id">{{ city.name }}</b-form-select-option>
                                </b-form-select>
                                <small v-if="validateCityMessage" class="text-danger font-weight-bold">{{ validateCityMessage }}</small>
                            </label>
                        </b-col>

                        <b-col md="6" sm="12">
                            <label class="small text-left mx-1 w-100 mb-3">
                                <small>Район</small>
                                <b-form-select v-model="district_id" :class="{'border-danger': validateDistrict}">
                                    <b-form-select-option :value="null" disabled>Выберите район</b-form-select-option>
                                    <b-form-select-option v-for="district in districtsCity" :value="district.id">{{ district.name }}</b-form-select-option>
                                </b-form-select>
                                <small v-if="validateDistrictMessage" class="text-danger font-weight-bold">{{ validateDistrictMessage }}</small>
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
                            @click="submitFormStreet"
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
            streetId: {
                type: Number,
                default: 0,
                required: true
            }
        },

        data: () => ({
            id: null,
            name: '',
            city_id: 0,
            district_id: 0,
            is_hidden: 0,
            isEditMode: false,

            isValidate: false,
            validateName: false,
            validateNameMessage: false,
            validateCity: false,
            validateCityMessage: false,
            validateDistrict: false,
            validateDistrictMessage: false,

            messageRequiredField: 'Поле обязательно для заполнения'
        }),

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            },

            allCities() {
                return this.$store.getters['cities/allCities']
            },

            allDistricts() {
                return this.$store.getters['districts/allDistricts'] || []
            },

            // Меняем список районов в зависимости от города
            districtsCity() {
                if (this.allDistricts.length) {
                    let [...districts] = this.allDistricts
                    return this.city_id ? districts.filter(district => district.city_id === this.city_id) : districts
                }
                return []
            },
        },

        methods: {
            ...mapActions({
                showNotify: 'notifications/showNotify'
            }),

            // Проверяем и отправляем данные
            submitFormStreet() {

                // Валидируем данные
                if (!this.validateName && !this.validateCity) {
                    this.isValidate = true
                } else {
                    this.isValidate = false
                    this.showNotify({message: 'Некоректные данные', variant: 'danger'})
                }

                if (this.isValidate) {

                    // Устанавливаем данные
                    let streetData = {
                        name: this.name.trim(),
                        city_id: this.city_id,
                        district_id: this.district_id,
                        is_hidden: this.is_hidden,
                    }

                    if (!this.streetId) {

                        // режим создания
                        this.$store.dispatch('streets/addNewStreet', streetData)
                            .then(res => {
                                this.hideStreetModal()
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
                        streetData.id = this.id

                        this.$store.dispatch('streets/updateStreet', streetData)
                            .then(res => {
                                this.hideStreetModal()
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

            // Закрываем модальное окно
            hideStreetModal() {
                this.$refs.newStreetModal.hide()
                this.$emit('closeForm')
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

            сheckDistrictId() {
                // Валидация
                if (!this.district_id) {
                    this.validateDistrict = true
                    this.validateDistrictMessage = this.messageRequiredField
                } else {
                    this.validateDistrict = false
                    this.validateDistrictMessage = false
                }
            }

        },

        watch: {
            name: function (val) {
                this.сheckName()
            },

            city_id: function (val) {
                this.сheckCityId()
            },

            district_id: function (val) {
                this.сheckDistrictId()
            }
        },

        beforeMount() {
            this.сheckName()
            this.сheckCityId()
            this.сheckDistrictId()

            // Устанавливаем значения в режиме редактирования
            if (this.streetId) {
                this.$store.dispatch('streets/getOneStreetById', this.streetId)
                    .then(res => {
                        this.id = res.id
                        this.name = res.name
                        this.city_id = res.city_id
                        this.district_id = res.district_id
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

            // Показываем модально окно
            this.$refs['newStreetModal'].show()
        }
    }
</script>
