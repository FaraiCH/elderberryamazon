<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFabricationsTable Migration
 */
class CreateFabricationsTable extends Migration
{
    public function up()
    {

        Schema::create('bt_sales_fabrications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('quote_id')->nullable()->unsigned();
            $table->integer('type_id')->unsigned()->nullable()->index();
            $table->integer('pickslip_id')->nullable()->unsigned();
            $table->integer('linkschedule_id')->nullable()->unsigned();
            $table->integer('invoice_id')->nullable()->unsigned();
            $table->string('notes_fabrication')->nullable();
            $table->string('notes_delivery')->nullable();
            $table->date('schedule_date')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_sales_fabrications', function (Blueprint $table){
            $table->integer('srn_id')->nullable()->index();
            $table->dateTime('back_date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_fabrications');
    }
}
