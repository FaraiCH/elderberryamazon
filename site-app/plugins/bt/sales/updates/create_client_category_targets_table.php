<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateClientCategoryTargetsTable Migration
 */
class CreateClientCategoryTargetsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_client_category_targets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->nullable()->unsigned();
            $table->date('run_date')->nullable();
            $table->decimal('straight', 15, 2)->nullable(); 
            $table->decimal('coil', 15, 2)->nullable(); 
            $table->integer('target')->unsigned();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_client_category_targets');
    }
}
