<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDieselsTable Migration
 */
class CreateDieselsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_diesels', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('type_id')->nullable()->index();
            $table->string('serial_number')->nullable();
            $table->decimal('speed', 15, 1)->nullable();
            $table->decimal('intake', 15, 1)->nullable()->index();
            $table->timestamps();
        });

        Schema::table('bt_maintenance_diesels', function (Blueprint $table){
            $table->integer('operator_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_diesels');
    }
}
