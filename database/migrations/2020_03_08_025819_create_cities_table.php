<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('Название');
            $table->integer('is_hidden')->default(0)->comment('Скрытый');
            $table->timestamps();
        });

        Schema::create('cities_districts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('Название');
            $table->integer('city_id')->index()->comment('ID города');
            $table->integer('is_hidden')->default(0)->comment('Скрытый');
            $table->timestamps();
        });

        Schema::create('cities_streets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index()->comment('Название');
            $table->integer('district_id')->index()->comment('ID района');
            $table->integer('city_id')->index()->comment('ID города');
            $table->integer('is_hidden')->default(0)->comment('Скрытый');
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
        Schema::dropIfExists('cities');
        Schema::dropIfExists('cities_districts');
        Schema::dropIfExists('cities_streets');
    }
}
