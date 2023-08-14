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
            $table->boolean('centry')->nullable()->default(0); // 1 Entro a tiempo| 0 entro tarde

            $table->time('lunch_time')->nullable(); //ALMUERZO
            $table->time('back_lunch')->nullable(); //REGRESO DEL LUNCH Y BREAK

            $table->boolean('break')->default(0); //DESCANSO DE 15 MINUTOS
            $table->boolean('break_two')->default(0); //DESCANSO DE 15 MINUTOS

            $table->time('break_time')->nullable(); //TIME DEL BREAK
            $table->time('time_break_two')->nullable(); //TIME DEL SEGUNDO BREAK

            $table->time('back_break')->nullable(); //REGRESO DEL LUNCH Y BREAK
            $table->time('back_break_two')->nullable(); //REGRESO DEL LUNCH Y BREAK

            $table->datetime('out')->nullable(); //FIN DE LA JORNADA LABORAL
            $table->boolean('cout')->nullable()->default(0); // 1 Salio a tiempo | 0 salio tarde
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
