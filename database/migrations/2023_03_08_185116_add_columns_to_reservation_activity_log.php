<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToReservationActivityLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservation_activity_log', function (Blueprint $table) {
            $table->decimal('amount')->nullable();
            $table->string('reservation_period')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('reservation_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservation_activity_log', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('reservation_period');
            $table->dropColumn('vehicle_model');
            $table->dropColumn('reservation_status');
        });
    }
}
