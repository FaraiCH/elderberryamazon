<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateScrapCodesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_scrap_codes', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_scrap_codes');
    }
}
