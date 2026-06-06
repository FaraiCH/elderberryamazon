<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStaffTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_staff', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('priority')->nullable()->default(0);
            $table->string('cell')->nullable();
            $table->integer('is_supervisor')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_staff');
    }
}
