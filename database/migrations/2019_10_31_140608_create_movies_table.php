<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
         Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('key')->unique();
            $table->string('image');
            $table->string('title');
            $table->string('description');
            $table->double('rate', 3, 1);
            $table->integer('vote');
            $table->integer('user_id');
            $table->rememberToken();
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
        Schema::dropIfExists('movies');
    }
}
