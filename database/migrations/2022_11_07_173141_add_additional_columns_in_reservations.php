<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsInReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('reservation_code');
            $table->tinyInteger('is_reserved')->default(0);
            $table->decimal('amount');
            $table->string('pickup_location')->nullable();
            $table->string('drop_off_location')->nullable();
            $table->tinyInteger('is_guest')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('reservation_code');
            $table->dropColumn('is_reserved');
            $table->dropColumn('amount');
            $table->dropColumn('pickup_location');
            $table->dropColumn('drop_off_location');
        });
    }
}
