<template>
    <div class="text-left">
        <hr>
        <b-row class="small">
            <b-col>
                <div>
                    Дата и время:&nbsp;
                    <span v-if="main.dataDate.date">
                        {{ main.dataDate.date }}г.&nbsp;
                    </span>
                    <strong v-if="main.dataTimeDelivery.time">
                        <span v-if="main.dataTimeDelivery.beforeAfter == 0">до</span>
                        <span v-else>после</span>
                        {{ main.dataTimeDelivery.time }}&nbsp;
                    </strong>
                </div>
                <div>Пункт доставки: <strong>{{ main.dataCityDelivery.city }}</strong></div>
                <div>Стоимость доставки:
                    <strong v-if="main.dataCostDelivery.cost"> {{ main.dataCostDelivery.cost }} руб.</strong>
                    <strong class="text-danger" v-if="main.dataCostDelivery.isFree === '1'"> Бесплатно </strong>
                    <strong class="text-danger" v-if="main.dataCostDelivery.toBring === '1'"> Довоз </strong>
                    <strong class="text-danger" v-if="main.dataCostDelivery.exchange === '1'"> Обмен </strong>
                </div>
            </b-col>
            <b-col>
                <div>Акт добавил: Людмила</div>
                <div class="small">Продавец: Киндеева А. | 07.03.2020 в 15:43</div>
                <div>Адрес:
                    <strong>{{ main.dataAddressClient.street }}
                        <span v-if="main.dataAddressClient.home">д.{{ main.dataAddressClient.home }} </span>
                        <span v-if="main.dataAddressClient.apartment">кв.{{ main.dataAddressClient.apartment }} </span>
                        <span v-if="main.dataAddressClient.porch">п.{{ main.dataAddressClient.porch }} </span>
                    </strong>
                </div>
                <div>Телефон:&nbsp;
                    <strong v-if="main.dataContactClient.phone">{{ main.dataContactClient.phone }}, </strong>
                    <strong v-if="main.dataContactClient.phoneSpare">{{ main.dataContactClient.phoneSpare }}, </strong>
                    <strong v-if="main.dataContactClient.phoneHome">{{ main.dataContactClient.phoneHome }}, </strong>
                    <span v-if="main.dataContactClient.lastName">({{ main.dataContactClient.lastName }})</span>
                </div>
            </b-col>
        </b-row>

        <b-row class="small">
            <b-col>
                <div v-if="main.dataCommentClient.dialing == 1">Дозвон: <span class="text-success"> за {{ main.dataCommentClient.dialingTime }} минут</span></div>
                <div v-if="main.dataCommentClient.liftUp == 1">Подъем: <span v-if="main.dataCommentClient.elevator == 1"> Лифт </span> <span class="text-success"> {{ main.dataCommentClient.floor }} этаж</span></div>
                <div>Комментарий: <span class="text-success">{{ main.dataCommentClient.comment }}</span></div>


                "dialing": "1", "dialingTime": 60, "liftUp": "1", "elevator": "0", "floor": 1


                <div>№ док. продажи:
                    <strong v-if="main.dataSaleNumbers.salesNumber1" class="text-primary"> {{ main.dataSaleNumbers.salesNumber1 }}</strong>
                    <strong v-if="main.dataSaleNumbers.salesNumber2" class="text-secondary"> | {{ main.dataSaleNumbers.salesNumber2 }}</strong>
                    <strong v-if="main.dataSaleNumbers.salesNumber3" class="text-secondary"> | {{ main.dataSaleNumbers.salesNumber3 }}</strong>
                </div>
            </b-col>
        </b-row>
        <hr>


            <div class="small border p-3 m-1">
                Дата доставки:<br>
                <code>
                    {{ main.dataDate }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Номер документа продажи:<br>
                <code>
                    {{ main.dataSaleNumbers }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Время доставки:<br>
                <code>
                    {{ main.dataTimeDelivery }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Пункт доставки:<br>
                <code>
                    {{ main.dataCityDelivery }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Стоимость доставки:<br>
                <code>
                    {{ main.dataCostDelivery }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Адрес доставки:<br>
                <code>
                    {{ main.dataAddressClient }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Имя клиента:<br>
                <code>
                    {{ main.dataContactClient }}
                </code>
            </div>

            <div md="auto" class="small border p-3 m-1">
                Комментарий:<br>
                <code>
                    {{ main.dataCommentClient }}
                </code>
            </div>


    </div>
</template>

<script>
    export default {
        props: ['main'],
        data: () => ({

        })
    }
</script>
