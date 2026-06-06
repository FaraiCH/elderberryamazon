<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateProdailiesTable Migration
 */
class CreateProdailiesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('bt_production_prodailies');
        Schema::create('bt_production_prodailies', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_prodailies');
    }
}
