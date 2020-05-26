<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadenasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cadenas', function (Blueprint $table) {
			$table->id();
			$table->string('cadena');
			$table->integer('id_maquina');
			$table->boolean('status');
			$table->integer('tapas');
			$table->integer('puntos');
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
		Schema::dropIfExists('cadenas');
	}
}