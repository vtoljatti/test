<template>
    <div>
        <div class="text-center p-3" v-if="!content">
            <b-spinner type="grow" />
        </div>

        <div class="p-4 pt-3 my-2 rounded shadow-sm"
             :class="[panelActEdit === act.id ? 'bg-light' : 'bg-white']"
             v-for="act in outputAct"
             @mouseover="panelActEdit = act.id"
             @mouseleave="panelActEdit = false"
        >
            <b-row>
                <b-col lg="6" md="12">
                    <div>
                        Дата и время:&nbsp;
                        <span v-if="act.date">
                            {{ act.date }}г.&nbsp;
                        </span>
                        <strong v-if="act.time">
                            <span v-if="act.before_after == 0">до</span>
                            <span v-else>после</span>
                            {{ act.time }}&nbsp;
                        </strong>
                    </div>
                    <div>Пункт доставки: <strong>{{ act.city }}</strong> <small v-if="districtName(act.district_id)">( {{ districtName(act.district_id) }} )</small></div>
                    <div>Стоимость доставки:
                        <strong v-if="act.cost !== 0"> {{ act.cost }} руб.</strong>
                        <strong class="text-danger" v-if="act.cost === 0"> Бесплатно </strong>
                        <strong class="text-danger" v-if="act.is_to_bring === 1"> Довоз </strong>
                        <strong class="text-danger" v-if="act.is_exchange === 1"> Обмен </strong>
                    </div>
                    <div>Водитель: Гера</div>
                </b-col>
                <b-col lg="6" md="12">
                    <div>Акт добавил: {{ userName(act.user_id) }}</div>
                    <div class="small">Продавец: {{ sellerName(act.seller_id) }} | {{ act.created_at }}</div>
                    <div>Адрес:
                        <strong>{{ act.street }}
                            <span v-if="act.home"> {{ act.home }}</span>
                            <span v-if="act.apartment">- {{ act.apartment }} </span>
                            <span v-if="act.porch">п.{{ act.porch }} </span>
                        </strong>
                    </div>
                    <div>Телефон:&nbsp;
                        <strong v-if="act.phone_1">{{ act.phone_1 }}, </strong>
                        <strong v-if="act.phone_2">{{ act.phone_2 }}, </strong>
                        <strong v-if="act.phone_3">{{ act.phone_3 }}, </strong>
                        <span v-if="act.last_name">({{ act.last_name }})</span>
                    </div>
                </b-col>
            </b-row>

            <div class="py-2">
                <div class="text-danger font-weight-bold">Товар отсутствует...</div>
            </div>

            <b-row class="d-flex align-items-end">
                <b-col md="6" sm="12" class="py-2">
                    <div v-if="act.is_dialing == 1">Дозвон: <span class="text-success font-weight-bold"> за {{ act.time_dialing }} минут</span></div>
                    <div v-if="act.is_lift_up == 1">
                        Подъем:
                        <span class="text-success" v-if="act.is_questionable == 1">???</span>
                        <span class="text-success font-weight-bold" v-if="act.is_elevator == 1"> Лифт </span>
                        <span class="text-success font-weight-bold"> {{ act.floor }} этаж</span></div>
                    <div v-if="act.comment">Комментарий: <span class="text-success">{{ act.comment }}</span></div>

                    <div>№ док. продажи:
                        <strong v-if="act.number_sales_1" class="text-primary"> {{ act.number_sales_1 }}</strong>
                        <strong v-if="act.number_sales_2" class="text-secondary"> | {{ act.number_sales_2 }}</strong>
                        <strong v-if="act.number_sales_3" class="text-secondary"> | {{ act.number_sales_3 }}</strong>
                    </div>
                </b-col>
                <b-col md="6" sm="12" class="text-center text-md-right">
                    <div v-if="panelActEdit === act.id && authUser.id === act.user_id ||
                               panelActEdit === act.id && authUser.role === 'admin' ||
                               panelActEdit === act.id && authUser.role === 'chief_driver' ||
                               panelActEdit === act.id && authUser.role === 'warehouse'">
                        <b-button size="sm"variant="outline-secondary">
                            <small><i class="fa fa-history fa-2x"></i></small>
                        </b-button>
                        <b-button size="sm" variant="outline-warning">
                            <small><i class="fa fa-shopping-cart fa-2x"></i></small>
                        </b-button>
                        <b-button size="sm" variant="outline-primary" @click="openModal(act.id)">
                            <small><i class="fa fa-pencil fa-2x"></i></small>
                        </b-button>
                        <b-button size="sm" variant="outline-danger">
                            <small><i class="fa fa-trash fa-2x"></i></small>
                        </b-button>
                    </div>

                </b-col>
            </b-row>
        </div>

        <div v-if="!outputAct.length" class="p-4 pt-3 my-2 bg-white rounded shadow-sm">Акты отсутствуют...</div>

    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    props: ['data'],

    data() {
        return {
            panelActEdit: false,
            content: false,
        }
    },

    methods: {
        ...mapActions({
            setPicketDay: 'acts/setPickedDay',
            setListActs: 'acts/setListActs',
            setFilterActs: 'acts/setFilterActs',
            setDataModal: 'others/setDataModal'
        }),

        openModal(id = 0) {
            this.setDataModal({
                id: id,
                show: true,
                act: []
            })
        },

        // Имя продавца по id
        sellerName(sellerId) {
            if (sellerId) {
                let seller = this.allSellersCity ? this.allSellersCity.find(seller => seller.id === sellerId) : null
                return seller != null ? seller.name : 'Неизвестный'
            }
        },

        // Имя Пользователя
        userName(userId) {
            if (userId) {
                let user = this.allUsers ? this.allUsers.find(user => user.id === userId) : null
                return user != null ? user.name : 'Неизвестный'
            }
        },

        // Название района по id
        districtName(districtId) {
            if (districtId) {
                let district = this.allDistrictsCity ? this.allDistrictsCity.find(district => district.id === districtId) : null
                return district != null ? district.name : ''
            }
        }
    },

    computed: {
        ...mapGetters({
            dateFromState: 'acts/pickedDay',
            listActs: 'acts/listActs',
            filterActs: 'acts/filterActs',
            allUsers: 'users/allUsers',
            authUser: 'users/authUser',
        }),

        outputAct() {
            this.content = false
            let [...acts] = this.listActs

            acts = acts.filter(act => act.is_hidden !== 1)
            acts = this.filterActs.driverId ? acts.filter(act => act.driver_id === this.filterActs.driverId) : acts
            acts = this.filterActs.districtId ? acts.filter(act => act.district_id === this.filterActs.districtId) : acts
            acts = this.filterActs.shopId ? acts.filter(act => act.user_id === this.filterActs.shopId) : acts

            if (this.filterActs.sort) {
                switch(this.filterActs.sort) {
                    case 1 : {
                        acts.sort((a, b) => {
                            return a.time > b.time ? 1 : -1
                        })
                        break
                    }
                    case 2 : {
                        acts.sort((a, b) => {
                            return a.created_at > b.created_at ? 1 : -1
                        })
                        break
                    }
                    case 3 : {
                        acts.sort((a, b) => {
                            return a.district_id > b.district_id ? 1 : -1
                        })
                        break
                    }
                    case 4 : {
                        acts.sort((a, b) => {
                            return a.user_id > b.user_id ? 1 : -1
                        })
                        break
                    }
                }
            }

            this.content = true
            return acts ?? []
        },

        allSellersCity() {
            return this.$store.getters['sellers/allSellersCity'] || []
        },

        allDistrictsCity() {
            return this.$store.getters['districts/allDistrictsCity'] || []
        },
    },

    watch: {
        dateFromState(val) {
            this.outputAct
        },

        listActs(val) {
            this.outputAct
        }
    }
}
</script>
