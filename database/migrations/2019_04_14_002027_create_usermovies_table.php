<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usermovies', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('nombre');
			$table->unsignedBigInteger('creador_id'); 
			$table->boolean('public')->default(false);
            $table->timestamps();
        });
		
		   Schema::table('usermovies', function (Blueprint $table) {
           
			$table->foreign('creador_id')->references('id')->on('users');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
		Schema::drop('usermovies');
		Schema::enableForeignKeyConstraints();

    }
}
