<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemenanglelangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemenanglelangs', function (Blueprint $table) {
            $table->id();

            $table->integer('users_id');
            $table->integer('collection_id');
            $table->integer('lelangdetail_id');
            $table->string('pembayaranPath');
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
        Schema::dropIfExists('pemenanglelangs');
    }
}
