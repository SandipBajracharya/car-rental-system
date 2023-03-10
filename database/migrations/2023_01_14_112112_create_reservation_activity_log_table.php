<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('action')->nullable();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['auto', 'manual']);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->tinyInteger('has_read')->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('guest_id')->references('id')->on('guest_infos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('reservation_activity_log');
    }
}
