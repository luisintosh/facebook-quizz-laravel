<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_quizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('quiz_id');
            $table->unsignedInteger('user_id');
            $table->string('imageUrl');
            $table->integer('imageSize');
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_quizzes');
    }
}
