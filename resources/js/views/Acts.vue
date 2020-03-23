<template>
    <div>
        <div v-if="authUser">
            <ModalAct v-if="dataModal.show" />
            <div class="px-3 py-2 my-1 bg-white rounded shadow-sm">
                <b-row>
                    <b-col xl="3" lg="4" md="6" sm="12" class="text-center text-xl-left text-lg-left text-md-left text-sm-center order-2 order-md-1">
                         <CalendarPanel />
                    </b-col>
                    <b-col xl="9" lg="8" md="6" sm="12" class="order-1 order-md-2">
                        <InformationPanel />
                    </b-col>
                </b-row>
            </div>

            <FilterPanel />

            <ActsList />

        </div>
        <div v-else>
            <Page401 />
        </div>
    </div>
</template>

<script>
import ModalAct from '../components/forms/Act'
import Page401 from './401'
import { mapActions, mapGetters } from "vuex";
import Street from "../components/forms/Street";
import InformationPanel from "../components/acts/InformationPanel";
import FilterPanel from "../components/acts/FilterPanel";
import CalendarPanel from "../components/acts/CalendarPanel";
import ActsList from "../components/acts/ActsList";

export default {
    components: {
        Street,
        ModalAct,
        Page401,
        InformationPanel,
        FilterPanel,
        CalendarPanel,
        ActsList
    },

    data() {
        return {
            content: false,
            panelActEdit: false,
            loadingDistrictsCity: false,
            loadingSellersCity: false,
        }
    },

    methods: {
        ...mapActions({
            setActs: 'acts/getActs',
            showNotify: 'notifications/showNotify',
            setPicketDay: 'acts/setPickedDay',
            getAuthUser: 'users/getAuthUser',
            setPickedDay: 'acts/setPickedDay',
            getAllDistrictsCity: 'districts/getAllDistrictsCity',
            getAllSellersCity: 'sellers/getAllSellersCity',
            setListActs: 'acts/setListActs',
            setDataModal: 'others/setDataModal'
        }),

        // Получаем акты на текущий день
        getActs(date) {
            this.content = false

            this.setActs(date)
                .then(res => {
                    this.setListActs(res.acts)
                    this.content = true
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
        }
    },

    computed: {
        ...mapGetters({
            dateFromState: 'acts/pickedDay',
            authUser: 'users/authUser',
            pickedDay: 'acts/pickedDay',
            allDistrictsCity: 'districts/allDistrictsCity',
            allSellersCity: 'sellers/allSellersCity',
            dataModal: 'others/dataModal'
        })
    },

    beforeMount() {
        this.$store.dispatch('users/getAuthUser')
        this.setPickedDay(this.pickedDay)

        // получаем всех пользователей
        if (!this.allUsers) {
            this.$store.dispatch('users/getAllUsers')
        }
    },

    beforeUpdate() {
        this.getAuthUser;
        this.setPickedDay(this.pickedDay)
        // получаем районы текущего города
        if (!this.allDistrictsCity.length) {
            if (!this.loadingDistrictsCity) {
                this.loadingDistrictsCity = true
                this.getAllDistrictsCity(this.authUser.city_id);
            }
        }

        // получаем продавцов текущего города
        if (!this.allSellersCity.length) {
            if (!this.loadingSellersCity) {
                this.loadingSellersCity = true
                this.getAllSellersCity(this.authUser.city_id);
            }
        }
    },

    watch: {
        // Наблюдаем за изменениями даты в store
        dateFromState(val) {
            if (this.dateFromState) {
                this.getActs(this.dateFromState)
            }
        }
    }
 }
</script>
