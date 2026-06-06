<?php namespace Bt\Qc\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateQcreasonsTable Migration
 */
class CreateQcreasonsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_qcreasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reason');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_qcreasons');
    }
}
