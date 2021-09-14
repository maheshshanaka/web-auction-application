<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_logs', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, 2)->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->boolean('is_auto_bid')->default(false);
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
        Schema::dropIfExists('bid_logs');
    }
}
