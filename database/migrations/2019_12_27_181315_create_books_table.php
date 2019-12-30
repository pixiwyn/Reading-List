<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('google_id');
            $table->string('title');
            $table->integer('order');
            $table->text('description');
            $table->text('short_description');
            $table->text('authors');
            $table->string('published_date');
            $table->string('buy_link');
            $table->double('average_rating');
            $table->integer('ratings_count');
            $table->text('cover_img_url');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('books');
    }
}
