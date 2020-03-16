<template>
    <div>
        <ModalUser v-if="showCreateUserModal" @closeForm="closeModalUser" :user-id="editableUserId" />

        <b-navbar toggleable="lg" type="light" variant="light">
<!--            <b-navbar-brand to="/" exact>Главная</b-navbar-brand>-->

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown text="Акты" right>
                        <b-dropdown-item to="/acts">Акты</b-dropdown-item>
                        <b-dropdown-item href="#">Добавить акт</b-dropdown-item>
                        <b-dropdown-item to="acts-search">Поиск актов</b-dropdown-item>
                        <b-dropdown-item to="acts-history">История</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Города" right v-if="authUser.role === 'admin'
                                                || authUser.role === 'warehouse'
                                                || authUser.role === 'chief_driver'">
                        <b-dropdown-item to="cities" v-if="authUser.id === 1">Города</b-dropdown-item>
                        <b-dropdown-item to="districts">Районы</b-dropdown-item>
                        <b-dropdown-item to="streets">Улицы</b-dropdown-item>
                        <b-dropdown-item to="villages">Населенные пункты</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Водители" right v-if="authUser.role === 'admin'
                                                || authUser.role === 'warehouse'
                                                || authUser.role === 'driver'
                                                || authUser.role === 'chief_driver'">
                        <b-dropdown-item to="/drivers-statistics">Статистика</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Пользователи" right>
                        <b-dropdown-item  v-if="authUser.role === 'admin' || authUser.role === 'warehouse'" to="/users">
                            Пользователи
                        </b-dropdown-item>
                        <b-dropdown-item to="/sellers">Продавцы</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>
                        <template v-slot:button-content>
                            <strong>{{ authUser.name }}</strong>
                        </template>
                        <b-dropdown-item @click="openModalUser(authUser.id)">
                            Настройки
                        </b-dropdown-item>
                        <b-dropdown-item @click="logout">Выйти</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    import ModalUser from "./forms/User";

    export default {
        components: {
            ModalUser,
        },

        data() {
            return {
                showCreateUserModal: false,
                editableUserId: 0
            }
        },

        computed: {
            authUser() {
                return this.$store.getters['users/authUser'] || []
            }
        },

        methods: {
            // Выход
            logout() {
                this.$store.dispatch('users/logout');
                window.location.reload()
             },

            // Добавляем данные при открытии модального окна
            openModalUser(id = null) {
                this.editableUserId = id
                this.showCreateUserModal = true
            },

            // Очищаем данные после закрытия модального окна
            closeModalUser() {
                this.showCreateUserModal = false
                this.editableUserId = null
            },
        }
    }
</script>
