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
            //$table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->boolean('featured')->nullable();
            $table->float('amount')->nullable();
            $table->longText('image')->nullable();
            $table->text('body')->nullable();
            $table->enum('post_type', ['sell', 'rent'])->nullable();
            $table->enum('type', ['new', 'resale'])->nullable();
            $table->char('country', 2)->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('sub_category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('uploads')->nullable();
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
