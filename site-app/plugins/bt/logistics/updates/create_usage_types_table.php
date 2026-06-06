<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUsageTypesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_usage_types', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_usage_types');
    }
}
