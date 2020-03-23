<template>
    <div>
        <b-modal ref="newActModal" size="xl" hide-footer hide-header>

            <b-row>
                <b-col class="text-left pb-1">
                    <span class="h5 p-0 m-0 text-muted font-weight-normal">
                        {{ dataModal.id ? 'Редактирование' : 'Новый акт' }}
                    </span>
                </b-col>
                <b-col class="text-right justify-content-top">
                    <button @click="hideActModal" class="btn btn-white text-muted font-weight-normal">
                        <i class="fa fa-close"></i>
                    </button>
                </b-col>
            </b-row>

            <div class="d-block text-center bg-light py-3">
                <b-row class="px-3 justify-content-center text-center">
                    <b-col xl="4" lg="12" md="12" class="justify-content-center">
                        <Date :data='dataDateMethod' />
                    </b-col>
                    <b-col xl="4" lg="6" md="12" class="">
                        <SaleNumbers :data='dataSaleNumbersMethod' />
                        <TimeDelivery :data='dataTimeDeliveryMethod' />
                        <CityDelivery :data='dataCityDeliveryMethod' />
                        <CostDelivery :data='dataCostDeliveryMethod' />
                    </b-col>
                    <b-col xl="4" lg="6" md="12" class="">
                        <AddressClient :data='dataAddressClientMethod' :district="main.dataCityDelivery" />
                        <ContactClient :data='dataContactClientMethod' />
                        <CommentClient :data='dataCommentClientMethod' />
                    </b-col>
                </b-row>



                <br>
                <div class="form-group">
                    <b-select size="md"
                              style="max-width: 200px"
                              v-model="seller"

                    >
                        <b-select-option
                            v-for="seller in allSellersCity"
                            :value="seller.id"
                            :key="seller.id"
                        >
                            {{ seller.name }}
                        </b-select-option>
                    </b-select>

                    <b-button v-if="dataModal.id" v-model="buttonSave" @click="submitFormAct" variant="warning" :disabled="buttonSave">
                        <b-spinner small type="grow" v-if="buttonSave"></b-spinner>
                        Изменить акт
                    </b-button>

                    <b-button v-else v-model="buttonSave" @click="submitFormAct" variant="success" :disabled="buttonSave">
                        <b-spinner small type="grow" v-if="buttonSave"></b-spinner>
                        Добавить акт
                    </b-button>
                 </div>
            </div>
        </b-modal>
    </div>
</template>

<script>
import Date from './items/Date'
import SaleNumbers from './items/SaleNumbers'
import TimeDelivery from './items/TimeDelivery'
import CostDelivery from './items/CostDelivery'
import CityDelivery from './items/CityDelivery'
import AddressClient from './items/AddressClient'
import CommentClient from './items/CommentClient'
import ContactClient from './items/ContactClient'
import {mapActions, mapGetters} from "vuex";

export default {
    components: {
        Date,
        SaleNumbers,
        TimeDelivery,
        CostDelivery,
        CityDelivery,
        AddressClient,
        CommentClient,
        ContactClient,
    },

    data: () => ({
         id: false,
         buttonSave: false,
         seller: false,
         main: {
            dataDate: '',
            dataSaleNumbers: '',
            dataTimeDelivery: '',
            dataCityDelivery: '',
            dataCostDelivery: '',
            dataAddressClient: '',
            dataContactClient: '',
            dataCommentClient: '',
            dataNewUserModal: {
                name: ''
            },
        },
    }),

    methods: {
        ...mapActions({
            getAuthUser: 'users/getAuthUser',
            showNotify: 'notifications/showNotify',
            setPicketDay: 'acts/setPickedDay',
            setDataModal: 'others/setDataModal',
            setActs: 'acts/getActs',
            setListActs: 'acts/setListActs',
            getAllSellersCity: 'sellers/getAllSellersCity',
        }),

        // Проверяем и отправляем данные
        submitFormAct() {
            this.buttonSave = true

            // Валидация
            if (!this.main.dataSaleNumbers.isValidate ||
                !this.main.dataCityDelivery.isValidate ||
                !this.main.dataCostDelivery.isValidate ||
                !this.main.dataAddressClient.isValidate ||
                !this.main.dataContactClient.isValidate ||
                !this.main.dataDate.date ||
                !this.main.dataTimeDelivery.time ||
                !this.main.dataSaleNumbers.salesNumber1 ||
                !this.main.dataCityDelivery.city ||
                !this.main.dataAddressClient.street ||
                !this.main.dataAddressClient.home ||
                !this.seller
            ) {
                this.isValidate = false;
             } else {
                this.isValidate = true;
            }

            if (this.isValidate) {
                // Устанавливаем данные
                let actData = {
                    date: this.main.dataDate.date,
                    time: this.main.dataTimeDelivery.time,
                    number_sales_1: this.main.dataSaleNumbers.salesNumber1,
                    number_sales_2: this.main.dataSaleNumbers.salesNumber2 ?? 0,
                    number_sales_3: this.main.dataSaleNumbers.salesNumber3 ?? 0,
                    city: this.main.dataCityDelivery.city,
                    city_id: this.main.dataCityDelivery.cityId ?? 0,
                    district_id: this.main.dataCityDelivery.districtId ?? 0,
                    cost: this.main.dataCostDelivery.cost ?? 0,
                    is_to_bring: this.main.dataCostDelivery.toBring ?? 0,
                    is_exchange: this.main.dataCostDelivery.exchange ?? 0,
                    street: this.main.dataAddressClient.street,
                    home: this.main.dataAddressClient.home,
                    apartment: this.main.dataAddressClient.apartment,
                    porch: this.main.dataAddressClient.porch,
                    last_name: this.main.dataContactClient.lastName,
                    phone_1: this.main.dataContactClient.phone,
                    phone_2: this.main.dataContactClient.phoneSpare,
                    phone_3: this.main.dataContactClient.phoneHome,
                    is_dialing: this.main.dataCommentClient.dialing ?? 0,
                    time_dialing: this.main.dataCommentClient.dialingTime ?? 0,
                    is_lift_up: this.main.dataCommentClient.liftUp ?? 0,
                    is_questionable: this.main.dataCommentClient.questionable ?? 0,
                    is_elevator: this.main.dataCommentClient.elevator ?? 0,
                    comment: this.main.dataCommentClient.comment,
                    floor: this.main.dataCommentClient.floor ?? 0,
                    seller_id: this.seller, /// ИСПРАВИТЬ
                    driver_id: 0,
                }

                if (!this.dataModal.id) {
                    // режим создания
                    this.$store.dispatch('acts/addNewAct', actData)
                        .then(res => {
                            this.hideActModal()
                            this.showNotify({ message: res, variant: 'success' })
                            this.setPicketDay(this.main.dataDate.date)

                            if (this.seller !== this.authUser.seller_id) {
                                window.location.reload()
                            }
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
                    actData.id = this.dataModal.id

                    this.$store.dispatch('acts/updateAct', actData)
                        .then(res => {
                            this.hideActModal()
                            this.showNotify({ message: res, variant: 'success' })
                            this.updateLustActs()

                            if (this.seller !== this.authUser.seller_id) {
                                window.location.reload()
                            }
                            // this.setPicketDay(this.main.dataDate.date)
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
                this.showNotify({message: 'Некоректные данные', variant: 'danger'})
            }

            this.buttonSave = false
        },

        dataDateMethod(data) {
            this.main.dataDate = data
        },
        dataSaleNumbersMethod(data) {
            this.main.dataSaleNumbers = data
        },
        dataTimeDeliveryMethod(data) {
            this.main.dataTimeDelivery = data
        },
        dataCityDeliveryMethod(data) {
            this.main.dataCityDelivery = data
        },
        dataCostDeliveryMethod(data) {
            this.main.dataCostDelivery = data
        },
        dataAddressClientMethod(data) {
            this.main.dataAddressClient = data
        },
        dataContactClientMethod(data) {
            this.main.dataContactClient = data
        },
        dataCommentClientMethod(data) {
            this.main.dataCommentClient = data
        },

        showActModal() {
            this.$refs['newActModal'].show()
        },

        hideActModal() {
            this.$refs.newActModal.hide()
            this.setDataModal({
                id: 0,
                show: false,
            })
        },

        updateLustActs() {

            this.setActs(this.dateFromState)
                .then(res => {
                    this.setListActs(res.acts)
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
                        console.log(errors)
                    }
                )
        },

        updateDataActs(id) {
            this.$store.dispatch('acts/getOneActById', id)
                .then(res => {
                    this.setDataModal({
                        id: id,
                        show: true,
                        act: res
                    })
                })
                .catch(err => console.error(err))
        }
    },

    computed: {
        ...mapGetters({
            dataModal: 'others/dataModal',
            dateFromState: 'acts/pickedDay',
            allSellersCity: 'sellers/allSellersCity',
            authUser: 'users/authUser',
        })
    },

    mounted() {
        // Показываем модально окно
        this.$refs['newActModal'].show()

        this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
            if (bvEvent.trigger === 'backdrop') bvEvent.preventDefault()
        })
    },

    beforeMount() {
        // Устанавливаем значения в режиме редактирования
        if (this.dataModal.id) {
            this.updateDataActs(this.dataModal.id)
        }

        if (this.allSellersCity) {
            this.getAllSellersCity(this.authUser.city_id)
        }

        this.seller = this.authUser.seller_id
    },

    watch: {
        main: function (val) {
            this.validate();
            this.dataCommon()
        },

        dataModal: function (val) {
            if (this.dataModal.show) {
                this.$refs['newActModal'].show()
            } else {
                this.$refs['newActModal'].hide()
            }
        },
    }
}
</script>
