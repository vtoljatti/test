<template>

    <div class="modal">

        <div class="">
            <input
                class="form-control m-1"
                type="text"
                v-model="name"
                placeholder="Название"
            />
            <input
                class="form-control m-1"
                v-model="date"
                type="datetime-local"
            />
            <textarea
                class="form-control m-1"
                v-model="description"
                placeholder="Описание"
            />

            <button
                class="form-control m-1 btn-success"
                @click="addTask"
            >
                Сохранить
            </button>
        </div>

    </div>
</template>

<script>
export default {
    data: () => ({
        name: '',
        date: '',
        description: '',
    }),

    methods: {
        addTask() {
            let formData = new FormData()
            formData.append('name', this.name)
            formData.append('date', this.date)
            formData.append('description', this.description)
            fetch('/case_planners/store', {
                method: 'POST',
                headers: {
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(res => console.log(res))
            .catch(err => console.log(err))
        }
    },

    created() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content
    },
}

</script>

<style>
.modal {
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0,0,0, .5);
    position: fixed;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
}
</style>
