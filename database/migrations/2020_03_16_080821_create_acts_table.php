<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index()->comment('Дата');
            $table->time('time')->index()->comment('Время');
            $table->integer('number_sales_1')->index()->comment('Номер продажи 1');
            $table->integer('number_sales_2')->default(0)->index()->comment('Номер продажи 2');
            $table->integer('number_sales_3')->default(0)->index()->comment('Номер продажи 3');
            $table->string('city', 100)->comment('Город');
            $table->integer('city_id')->default(0)->comment('ID города');
            $table->integer('district_id')->default(0)->comment('ID района');

            $table->boolean('is_to_bring')->default(false)->comment('Довоз');
            $table->boolean('is_exchange')->default(false)->comment('Обмен');
            $table->integer('cost')->comment('Стоимость');

            $table->string('street', 100)->comment('Улица');

            $table->string('home', 100)->nullable()->comment('Дом');
            $table->string('apartment', 100)->nullable()->comment('Квартира/офис');
            $table->string('porch', 100)->nullable()->comment('Подъезд');

            $table->string('last_name', 100)->nullable()->comment('Имя клиента');
            $table->string('phone_1', 20)->nullable()->index()->comment('Телефон 1');
            $table->string('phone_2', 20)->nullable()->index()->comment('Телефон 2');
            $table->string('phone_3', 20)->nullable()->index()->comment('Телефон 3');

            $table->boolean('is_dialing')->default(false)->comment('Дозвон');
            $table->integer('time_dialing')->default(0)->comment('Дозвон через');

            $table->boolean('is_lift_up')->default(false)->comment('Подъем');
            $table->boolean('is_questionable')->default(false)->comment('Возможен');
            $table->boolean('is_elevator')->default(false)->comment('Лифт');
            $table->integer('floor')->default(0)->comment('Этаж');
            $table->string('comment')->nullable()->comment('Комментарий');

            $table->integer('user_id')->comment('ID Пользователя');
            $table->integer('seller_id')->comment('ID Продавца');
            $table->integer('driver_id')->default(0)->comment('ID Продавца');
            $table->integer('act_city_id')->default(0)->comment('ID Города');
            $table->boolean('is_hidden')->default(0)->comment('Скрыто');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acts');
    }
}
