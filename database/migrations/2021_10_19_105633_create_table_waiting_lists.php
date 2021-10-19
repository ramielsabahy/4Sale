<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWaitingLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');

            //indexes
            $table->index('customer_id');
            // Foreign Keys
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
        Schema::dropIfExists('waiting_lists');
    }
}
