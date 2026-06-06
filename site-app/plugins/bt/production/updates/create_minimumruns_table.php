<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMinimumrunsTable Migration
 */
class CreateMinimumrunsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_minimumruns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('diameter_id')->nullable()->index();
            $table->decimal('startup_scrap')->nullable();
            $table->decimal('end_scrap')->nullable();
            $table->decimal('workmanship')->nullable();
            $table->decimal('other')->nullable();
            $table->decimal('minimum_run', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::table('bt_production_minimumruns', function (Blueprint $table) {
            $table->decimal('target_scrap', 15, 2)->nullable();
            $table->decimal('factor', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_minimumruns');
    }
}
