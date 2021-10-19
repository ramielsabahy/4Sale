<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('date');
            $table->time('from_time');
            $table->time('to_time');

            //indexes
            $table->index('table_id');
            $table->index('customer_id');

            //foreign keys
            $table->foreign('table_id')->references('id')
                ->on('tables')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')
                ->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
