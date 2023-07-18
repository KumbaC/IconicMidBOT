<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('working_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->datetime('entry_date'); //FECHA DE ENTRADA
            $table->boolean('break')->default(0); //DESCANSO DE 15 MINUTOS
            $table->time('lunch_time')->nullable(); //DESCANSO DE 15 MINUTOS
            $table->boolean('back')->nullable(); //REGRESO DEL LUNCH Y BREAK
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
        Schema::dropIfExists('working_times');
    }
}
