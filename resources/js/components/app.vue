<template>
    <div class="container p-2">

        <div class="d-flex justify-content-between">
            <div><input type="date" class="form-control"></div>
            <div class="btn-link">Добавить</div>
        </div>

        <div class="row bg-light m-1">
            <div class="col-1 p-2 border d-flex align-items-center justify-content-center">
                <input type="checkbox" class="d-inline" style="width: 25px; height: 25px; align-items: center">
            </div>
            <div class="col-11 border">
                <div class="text-right position-relative p-1 pr-3">
                    <small class="position-absolute btn-link">Edit</small>
                </div>
                <div class="py-2">
                    <h4>Название дела</h4>
                    <p>Текст с описанием этого дела прямо тут на этом месте без всякого пафоса и так далее.</p>
                    <small class="font-italic">10:00 12.12.2020г.</small>
                </div>
            </div>
        </div>

        <ImageModal />

    </div>
</template>


<script>


import ImageModal from './case_planners/image-modal'

export default {
    components: {
        ImageModal
    }
}


</script>
