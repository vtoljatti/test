<template>
    <div class="p-1">
        <div class="p-2 bg-white rounded block-item">
            <div class="px-2 pb-2 text-muted small text-left border-bottom border-light">
                <small>
                    <i class="fa fa-caret-down"></i> &nbsp; Комментарий
                </small>
            </div>
            <div class="p-1 small text-left">

                <b-row class="justify-content-center align-items-center border-bottom border-light p-2">
                    <b-col class="text-left">
                        <b-form-checkbox
                            v-model="dialing"
                            name="is_dialing"
                            value="1"
                            unchecked-value="0"
                            switch
                        >
                            Дозвон
                        </b-form-checkbox>
                    </b-col>
                    <b-col>
                        <b-input-group v-if="dialing == 1">
                            <b-input-group size="sm" append="минут">
                                <b-form-input
                                    class="text-center"
                                    type="number"
                                    v-model="dialingTime"
                                    placeholder="минут"
                                    size="sm"
                                />
                            </b-input-group>
                        </b-input-group>
                    </b-col>
                </b-row>

                <b-row class="justify-content-center align-items-center border-bottom border-light p-2">
                    <b-col>
                        <b-form-checkbox
                            v-model="liftUp"
                            name="is_lift_up"
                            value="1"
                            unchecked-value="0"
                            switch
                        >
                            Подъем
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-if="liftUp == 1"
                            name="is_elevator"
                            value="1"
                            unchecked-value="0"
                        >
                            ???
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-if="liftUp == 1"
                            v-model="elevator"
                            name="is_elevator"
                            value="1"
                            unchecked-value="0"
                        >
                            Лифт
                        </b-form-checkbox>
                    </b-col>
                    <b-col>
                        <b-input-group v-if="liftUp == 1">
                            <b-input-group size="sm" append="этаж">
                                <b-form-input
                                    class="text-center"
                                    type="number"
                                    v-model="floor"
                                    placeholder="этаж"
                                    size="sm"
                                />
                            </b-input-group>
                        </b-input-group>
                    </b-col>
                </b-row>

                <b-form-input
                    class="text-center mb-1 mt-3"
                    type="text"
                    v-model="comment"
                    placeholder="Комментарий"
                    size="sm"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data() {
        return {
            comment: null,
            dialing: 0,
            dialingTime: 60,
            liftUp: null,
            elevator: null,
            floor: 1
        }
    },
    methods: {
        dataCommon() {
            this.data({
                comment: this.comment,
                dialing: this.dialing,
                dialingTime: this.dialingTime,
                liftUp: this.liftUp,
                elevator: this.elevator,
                floor: this.floor
            })
        }
    },
    watch: {
        comment: function (val) {
            this.dataCommon()
        },
        dialing: function (val) {
            this.dataCommon()
        },
        dialingTime: function (val) {
            this.dataCommon()
        },
        liftUp: function (val) {
            this.dataCommon()
        },
        elevator: function (val) {
            this.dataCommon()
        },
        floor: function (val) {
            this.dataCommon()
        }
    },
    created() {
        this.dataCommon()
    }
}
</script>
