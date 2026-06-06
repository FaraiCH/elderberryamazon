<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDispatchesTable Migration
 */
class CreateDispatchesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('srn_id')->index();
            $table->string('company_name');
            $table->string('transport_type');
            $table->string('vehicle_registration');
            $table->string('driver_full_names');
            $table->string('trailers_registration')->nullable();
            $table->string('entry_weight')->nullable();
            $table->string('entry_weight_timestamp')->nullable();
            $table->string('exit_weight')->nullable();
            $table->string('exit_weight_timestamp')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_dispatches');
    }
}
