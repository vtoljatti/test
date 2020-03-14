<template>
    <div>
        <b-navbar toggleable="lg" type="light" variant="light">
<!--            <b-navbar-brand to="/" exact>Главная</b-navbar-brand>-->

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav class="ml-auto">

                    <b-nav-item-dropdown text="Акты" right>
                        <b-dropdown-item to="/acts">Акты</b-dropdown-item>
                        <b-dropdown-item href="#">Добавить акт</b-dropdown-item>
                        <b-dropdown-item href="#">Поиск актов</b-dropdown-item>
                        <b-dropdown-item href="#">Удаленные акты</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Города" right>
                        <b-dropdown-item href="#">Города</b-dropdown-item>
                        <b-dropdown-item href="#">Районы</b-dropdown-item>
                        <b-dropdown-item href="#">Улицы</b-dropdown-item>
                        <b-dropdown-item href="#">Населенные пункты</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Водители" right>
                        <b-dropdown-item href="#">Статистика</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown text="Пользователи" right>
                        <b-dropdown-item to="/users">Пользователи</b-dropdown-item>
                        <b-dropdown-item href="#">Продавцы</b-dropdown-item>
                        <b-dropdown-item href="#">Роли</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>
                        <template v-slot:button-content>
                            <em>User</em>
                        </template>
                        <b-dropdown-item href="#">Настройки</b-dropdown-item>
                        <b-dropdown-item href="#">Выйти</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    export default {

    }
</script>
