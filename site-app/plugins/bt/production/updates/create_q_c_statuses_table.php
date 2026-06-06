<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQCStatusesTable Migration
 */
class CreateQCStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_q_c_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('bt_production_q_c_statuses', function (Blueprint $table){
            $table->integer('reason_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_q_c_statuses');
    }
}
