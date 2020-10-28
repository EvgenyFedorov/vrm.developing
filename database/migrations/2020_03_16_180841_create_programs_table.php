<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {

            $table->bigIncrements('id'); // ID программы
            $table->string('name'); // Название программы
            $table->string('bot_name'); // Название программы
            //$table->jsonb('roles')->nullable(); // Роли которым будет видна программа
            $table->integer('enable')->default(1); // Активация программы

            $table->timestamp('created_at')->nullable(); // Дата создания
            $table->timestamp('updated_at')->nullable(); // Дата изменения
            $table->timestamp('deleted_at')->nullable(); // Дата удаления

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
