<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTukarbarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tukarbarangs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_collection');
            $table->integer('id_users');
            $table->text('alasan_tukar_barang');
            $table->string('buktiPhoto');
            $table->string('status');
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
        Schema::dropIfExists('tukarbarangs');
    }
}
