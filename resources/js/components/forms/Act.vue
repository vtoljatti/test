<template>
    <div>
        <b-row class="p-3 justify-content-center text-center bg-light">
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
        <TestData :main="main" />
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
            TestData
        },
        data() {
            return {
                main: {
                    dataDate: '',
                    dataSaleNumbers: '',
                    dataTimeDelivery: '',
                    dataCityDelivery: '',
                    dataCostDelivery: '',
                    dataAddressClient: '',
                    dataContactClient: '',
                    dataCommentClient: ''
                },
            }
        },
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
            }
        },
        watch: {

        }
    }
</script>

<!--
TODO
. 1 секунда если выбрано "после"
. Сохранить данные с форм при закрытии модального окна
. В Date будет прилетать дата
. this в методе
. При выборе района, подгрузить улицы
. selected v-model name
. переход на другую страницу с метода
-->

<style>
    .block-item {

    }
</style>
