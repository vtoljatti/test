<template>
    <div>
        <b-modal ref="newCityModal" size="lg" hide-footer hide-header>

            <b-row>
                <b-col class="text-left pb-1">
                    <span class="h5 p-0 m-0 text-muted font-weight-normal">
                        {{ id ? 'Редактирование' : 'Новый город' }}
                    </span>
                </b-col>
                <b-col class="text-right justify-content-top">
                    <button @click="hideCityModal" class="btn btn-white text-muted font-weight-normal">
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
                            @click="submitFormCity"
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
        cityId: {
            type: Number,
            default: 0,
            required: true
        }
    },

    data: () => ({
        id: null,
        name: '',
        city_id: 0,
        is_hidden: 0,
        isEditMode: false,
        isValidate: false,
        validateName: false,
        validateNameMessage: false,
        validateCity: false,
        validateCityMessage: false,
        messageRequiredField: 'Поле обязательно для заполнения'
    }),

    computed: {
        authUser() {
            return this.$store.getters['users/authUser'] || []
        }
    },

    methods: {
        ...mapActions({
            showNotify: 'notifications/showNotify'
        }),

        // Проверяем и отправляем данные
        submitFormCity() {

            // Валидируем данные
            if (!this.validateName && !this.validateCity) {
                this.isValidate = true
            } else {
                this.isValidate = false
                this.showNotify({message: 'Некоректные данные', variant: 'danger'})
            }

            if (this.isValidate) {

                // Устанавливаем данные
                let cityData = {
                    name: this.name.trim(),
                    is_hidden: this.is_hidden,
                }

                if (!this.cityId) {

                    // режим создания
                    this.$store.dispatch('cities/addNewCity', cityData)
                        .then(res => {
                            this.hideCityModal()
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
                    cityData.id = this.id

                    this.$store.dispatch('cities/updateCity', cityData)
                        .then(res => {
                            this.hideCityModal()
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
        hideCityModal() {
            this.$refs.newCityModal.hide()
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

    },

    watch: {
        name: function (val) {
            this.сheckName()
        }
    },

    beforeMount() {
        this.сheckName()

        // Устанавливаем значения в режиме редактирования
        if (this.cityId) {
            this.$store.dispatch('cities/getOneCityById', this.cityId)
                .then(res => {
                    this.id = res.id
                    this.name = res.name
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

        // Показываем модально окно
        this.$refs['newCityModal'].show()
    }
}
</script>
