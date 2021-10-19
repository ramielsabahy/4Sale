<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('waiter_id');
            $table->double('total')->default(0);
            $table->boolean('paid')->default(0);
            $table->timestamp('date');

            //indexes
            $table->index('table_id');
            $table->index('customer_id');
            $table->index('reservation_id');
            $table->index('waiter_id');

            //foreign keys
            $table->foreign('table_id')->references('id')
                ->on('tables')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')
                ->on('customers')->onDelete('cascade');
            $table->foreign('reservation_id')->references('id')
                ->on('reservations')->onDelete('cascade');
            $table->foreign('waiter_id')->references('id')
                ->on('waiters')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
