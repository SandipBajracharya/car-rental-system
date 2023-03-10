<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_infos', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('street');
            $table->string('postal_code');
            $table->date('dob');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->string('document_image');
            $table->enum('document_type', ['Citizenship', 'Driving license', 'Voters card']);
            $table->string('document_number');
            $table->string('document_country');
            $table->date('document_expire')->nullable();
            $table->mediumText('notes')->nullable();
            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('guest_infos');
    }
}
