<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateCasePlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_planners', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time')->comment('Дата и время');
            $table->string('name')->comment('Наименование');
            $table->text('description')->comment('Описание');
            $table->boolean('is_done')->comment('Выполнено');
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
        Schema::drop('case_planners');
    }
}
