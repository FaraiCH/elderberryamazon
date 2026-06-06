<?php namespace Bt\JSEData\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateShareDataAVGsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_jsedata_share_data_a_v_gs', function (Blueprint $table) {
            $table->integer('company_id')->unsigned()->nullable()->index();
            $table->integer('property_id')->unsigned()->nullable()->index();
            $table->date('datea')->nullable();
            $table->date('dateb')->nullable();

            $table->string('cur')->nullable();
            $table->index(['cur', 'datea']);
            

        #  $table->unique(array('company_id','property_id','datea','value'));
            $table->decimal('value', 15, 2)->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_jsedata_share_data_a_v_gs');
    }
}
