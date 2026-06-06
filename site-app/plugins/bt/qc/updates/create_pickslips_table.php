<?php namespace Bt\Qc\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePickslipsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_pickslips', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('srn_id')->nullable();
            $table->integer('quote_id')->nullable();
            $table->integer('items')->nullable();
            $table->timestamps();
        });

        Schema::table('bt_qc_pickslips', function(Blueprint $table){
            $table->dropColumn('items');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_pickslips');
    }
}
