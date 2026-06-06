<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQuoteLoadsTable Migration
 */
class CreateQuoteLoadsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_quote_loads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quote_id')->nullable()->index();
            $table->integer('vehicle_type_id')->nullable()->index();
            $table->integer('unit')->nullable();
            $table->decimal('vihicle_load_weight', 15, 2)->nullable();
            $table->decimal('vehicle_load_min_lenth', 15, 2)->nullable();
            $table->decimal('vehicle_load_max_length', 15, 2)->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->integer('danages_required')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('bt_sales_quote_loads', function (Blueprint $table) {

        });

    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_quote_loads');
    }
}
