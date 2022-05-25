<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_variation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('box_id')->unsigned()->index();
            $table->json('name');
            $table->date('date');
            $table->dateTime('datetime');
            $table->string('image')->nullable();
            $table->json('images_list')->default('[]');
            $table->bigInteger('sort_index')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('box_variation');
    }
};
