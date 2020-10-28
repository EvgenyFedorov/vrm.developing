<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {

            $table->bigIncrements('id'); // ID задачи
            $table->unsignedBigInteger('program_id')->nullable(); // ID Приложения
            $table->unsignedBigInteger('user_id')->nullable(); // ID Приложения
            $table->integer('code_id')->nullable(); // Числовой код

            $table->integer('status')->default(0); // Статус задачи
            $table->integer('enable')->default(1); // Вкл/Выкл

            $table->timestamp('created_at')->nullable(); // Дата создания
            $table->timestamp('updated_at')->nullable(); // Дата изменения
            $table->timestamp('deleted_at')->nullable(); // Дата удаления

            $table->foreign('program_id')->references('id')->on('programs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
