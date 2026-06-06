<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateVendorsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_vendors', function(Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->string('name')->nullable();
        $table->string('contactperson')->nullable();
        $table->string('contactnumber')->nullable();
        $table->string('contacttel')->nullable();
        $table->string('contactemail')->nullable();
        $table->string('address')->nullable();
        $table->string('address2')->nullable();
        $table->string('city')->nullable();
        $table->string('country')->nullable();
        $table->string('notes')->nullable();
        $table->integer('welike')->default(1);
        $table->integer('vendor_type_id')->nullable();
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_vendors');
    }
}
