<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFabricationItemsTable Migration
 */
class CreateFabricationItemsTable extends Migration
{
    public function up()
    {

        Schema::create('bt_sales_fabrication_items', function (Blueprint $table) {
            $table->increments('id');
$table->integer('fabrication_id')->nullable()->unsigned();
$table->integer('pipe_id')->unsigned()->nullable()->index();
//
$table->string('description')->nullable();
$table->integer('units')->unsigned();
$table->string('unitdescription')->nullable();
$table->integer('created_by')->unsigned()->nullable()->index();
$table->integer('updated_by')->unsigned()->nullable()->index();

$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_fabrication_items');
    }
}
