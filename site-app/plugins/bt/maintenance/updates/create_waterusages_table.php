<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateWaterusagesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_waterusages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('readingdate')->nullable();
            $table->decimal('pro_meter', 15, 2)->nullable();
            $table->decimal('cooling_meter', 15, 2)->nullable();
            $table->decimal('admin_meter', 15, 2)->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_waterusages');
    }
}
