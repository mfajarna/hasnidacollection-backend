<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('price')->nullable();
            $table->double('rate')->nullable();
            $table->string('types')->nullable();
            $table->string('category')->nullable();
            $table->string('picturePath')->nullable();
            $table->string('url_barcode')->nullable();
            $table->string('photoBarcode')->nullable();

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
        Schema::dropIfExists('collections');
    }
}
