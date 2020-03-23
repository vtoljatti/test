<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_hidden')->default(0)->after('email')->comment('Скрытый');
            $table->integer('seller_id')->nullable()->after('email')->comment('ID продавца');
            $table->integer('district_id')->index()->after('email')->comment('ID района');
            $table->integer('city_id')->index()->after('email')->comment('ID города');
            $table->string('city')->after('email')->comment('Город');
            $table->string('address')->nullable()->after('email')->comment('Адрес');
            $table->string('phone')->nullable()->after('email')->comment('Телефон');
            $table->string('short_name')->after('email')->comment('Короткое имя');
            $table->string('role', 15)->index()->default('guest')->after('email')->comment('Роль');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
            $table->dropColumn('seller_id');
            $table->dropColumn('district_id');
            $table->dropColumn('city_id');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('short_name');
            $table->dropColumn('role');
        });
    }
}
