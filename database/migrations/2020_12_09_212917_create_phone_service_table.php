<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_service', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('phone_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->index()->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['phone_id', 'service_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_service');
    }
}
