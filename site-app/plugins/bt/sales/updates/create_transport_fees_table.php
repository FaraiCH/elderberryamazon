<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTransportFeesTable Migration
 */
class CreateTransportFeesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_transport_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->decimal('ton', 15, 2)->nullable();
            $table->decimal('ton_trailer', 15, 2)->nullable();
            $table->decimal('ton_trailer_min_6m', 15, 2)->nullable();
            $table->decimal('ton_min_6m_bed', 15, 2)->nullable();
            $table->decimal('trailer_18m', 15, 2)->nullable();
            $table->decimal('trailer_12m', 15, 2)->nullable();
            $table->decimal('curtain_side_link', 15, 2)->nullable();
            $table->integer('transportratesdestination_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });

         Schema::table('bt_sales_transport_fees', function (Blueprint $table) {
            $table->decimal('4_ton_trailer', 15, 2)->nullable();
            $table->decimal('four_ton_trailer', 15, 2)->nullable();
            $table->integer('active')->nullable()->default(0);
             $table->decimal('bt_ton', 15, 2)->nullable();
             $table->decimal('bt_ton_trailer', 15, 2)->nullable();
             $table->decimal('bt_four_ton_trailer', 15, 2)->nullable();
             $table->decimal('bt_ton_min_6m_bed', 15, 2)->nullable();
             $table->decimal('bt_ton_trailer_min_6m', 15, 2)->nullable();
             $table->decimal('bt_trailer_12m', 15, 2)->nullable();
             $table->decimal('bt_trailer_18m', 15, 2)->nullable();
             $table->decimal('ten_ton_12m_trailer', 15, 2)->nullable();
             $table->decimal('bt_ten_ton_12m_trailer', 15, 2)->nullable();
             $table->decimal('eight_ton', 15, 2)->nullable();
             $table->decimal('bt_eight_ton', 15, 2)->nullable();
         });

    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_transport_fees');
    }
}
