<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->boolean('featured');
            $table->float('amount');
            $table->longText('image');
            $table->text('body');
            $table->enum('post_type', ['sell', 'rent']);
            $table->enum('type', ['new', 'resale']);
            $table->char('country', 2);
            $table->string('city');
            $table->string('area');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('ads');
    }
}
