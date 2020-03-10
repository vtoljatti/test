<template>
    <div>
        <b-modal ref="newUserModal" size="xl" hide-footer :title="nameNewUserModal">
            <div class="d-block text-center">
                <form @submit.prevent="createNewUserModal">
                    <FormAct />
                    <br>
                    <div class="form-group">
                        <button @click="hideNewUserModal" class="btn btn-light">
                            Отмена
                        </button>
                        <button type="submit" class="btn btn-success">
                            Добавить
                        </button>
                    </div>
                </form>
            </div>
        </b-modal>


        <b-button id="show-btn" @click="showNewUserModal">
            <i class="fa fa-plus"></i>
            Добавить акт
        </b-button>
    </div>
</template>

<script>
import FormAct from '../components/forms/Act'

export default {
    components: {
        FormAct
    },
    data: () => ({
        nameNewUserModal: 'Новый Акт',
        dataNewUserModal: {
            name: ''
        },
    }),
    methods: {
        showNewUserModal() {
            this.$refs['newUserModal'].show()
        },
        hideNewUserModal() {
            this.$refs.newUserModal.hide()
        },
        createNewUserModal() {
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
