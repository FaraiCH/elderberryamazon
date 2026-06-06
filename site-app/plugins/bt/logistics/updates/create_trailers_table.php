<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTrailersTable Migration
 */
class CreateTrailersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_trailers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('num_plate')->nullable();
            $table->date('next_exp_license_disc')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_trailers');
    }
}
