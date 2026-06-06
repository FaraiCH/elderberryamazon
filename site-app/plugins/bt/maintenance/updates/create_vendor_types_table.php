<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVendorTypesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_vendor_types', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_vendor_types');
    }
}
