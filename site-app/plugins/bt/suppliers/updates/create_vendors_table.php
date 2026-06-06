<?php namespace Bt\Suppliers\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateVendorsTable Migration
 */
class CreateVendorsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_suppliers_vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_suppliers_vendors');
    }
}
