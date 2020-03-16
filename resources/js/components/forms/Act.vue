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
                            <AddressClient :data='dataAddressClientMethod' :district="main.dataCityDelivery" />
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

<!--$table->date('date')->index()->comment('Дата');-->
<!--$table->time('time')->index()->comment('Время');-->
<!--$table->integer('number_sales_1')->index()->comment('Номер продажи 1');-->
<!--$table->integer('number_sales_2')->default(0)->index()->comment('Номер продажи 2');-->
<!--$table->integer('number_sales_3')->default(0)->index()->comment('Номер продажи 3');-->
<!--$table->string('city', 100)->comment('Город');-->
<!--$table->integer('city_id')->default(0)->comment('ID города');-->
<!--$table->integer('district_id')->default(0)->comment('ID района');-->

<!--$table->boolean('is_to_bring')->default(false)->comment('Довоз');-->
<!--$table->boolean('is_exchange')->default(false)->comment('Обмен');-->

<!--$table->string('street', 100)->comment('Улица');-->
<!--$table->integer('street_id')->default(0)->comment('ID улицы');-->

<!--$table->string('home', 100)->nullable()->comment('Дом');-->
<!--$table->string('apartment', 100)->nullable()->comment('Квартира/офис');-->
<!--$table->string('porch', 100)->nullable()->comment('Подъезд');-->

<!--$table->string('last_name', 100)->nullable()->comment('Имя клиента');-->
<!--$table->string('phone_1', 20)->nullable()->index()->comment('Телефон 1');-->
<!--$table->string('phone_2', 20)->nullable()->index()->comment('Телефон 2');-->
<!--$table->string('phone_3', 20)->nullable()->index()->comment('Телефон 3');-->

<!--$table->boolean('is_dialing')->default(false)->comment('Дозвон');-->
<!--$table->integer('time_dialing')->default(0)->comment('Дозвон через');-->

<!--$table->boolean('is_lift_up')->default(false)->comment('Подъем');-->
<!--$table->boolean('is_questionable')->default(false)->comment('Возможен');-->
<!--$table->boolean('is_elevator')->default(false)->comment('Лифт');-->
<!--$table->integer('floor')->default(0)->comment('Этаж');-->
<!--$table->string('comment')->nullable()->comment('Комментарий');-->

<!--$table->integer('seller_id')->comment('ID Продавца');-->
<!--$table->integer('driver_id')->default(0)->comment('ID Продавца');-->
