<template>
    <div>
        <b-modal ref="newUserModal" size="xl" hide-footer hide-header>

            <b-row>
                <b-col class="text-left pb-1">
                    <span class="h5 p-0 m-0 text-muted">Новый акт</span>
                </b-col>
                <b-col class="text-right justify-content-top">
                    <button @click="hideNewUserModal" class="btn btn-white text-muted font-weight-normal p-0">
                        <i class="fa fa-close"></i>
                    </button>
                </b-col>
            </b-row>

            <div class="d-block text-center bg-light py-3">
                <form @submit.prevent="createNewActModal">

                    <b-row class="px-3 justify-content-center text-center">
                        <b-col xl="4" lg="12" md="12" class="justify-content-center">
                            <Date :data='dataDateMethod' />
                        </b-col>
                        <b-col xl="4" lg="6" md="6" class="">
                            <SaleNumbers :data='dataSaleNumbersMethod' />
                            <TimeDelivery :data='dataTimeDeliveryMethod' />
                            <CityDelivery :data='dataCityDeliveryMethod' />
                            <CostDelivery :data='dataCostDeliveryMethod' />
                        </b-col>
                        <b-col xl="4" lg="6" md="6" class="">
                            <AddressClient :data='dataAddressClientMethod' />
                            <ContactClient :data='dataContactClientMethod' />
                            <CommentClient :data='dataCommentClientMethod' />
                        </b-col>
                    </b-row>

                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">
                            Добавить акт
                        </button>
                    </div>
                </form>

                <TestData :main="main" />
            </div>
        </b-modal>

        <b-button id="show-btn" @click="showNewUserModal">
            <i class="fa fa-plus"></i>
            Добавить акт
        </b-button>
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
    import TestData from '../TestData'

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
            TestData,
        },

        data: () => ({
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

            showNewUserModal() {
                this.$refs['newUserModal'].show()
            },
            hideNewUserModal() {
                this.$refs.newUserModal.hide()
            },
            createNewActModal() {
                console.log('Форма отправлена')
            }
        },
        mounted() {
            this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
                if (bvEvent.trigger === 'backdrop') bvEvent.preventDefault()
            })
        }
    }
</script>
