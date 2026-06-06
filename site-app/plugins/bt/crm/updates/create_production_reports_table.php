<?php namespace Bt\CRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductionReportsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_crm_production_reports', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quote_id')->nullable()->unsigned();
            $table->integer('client_id')->nullable()->unsigned();
            $table->date('report_date')->nullable(); 
            $table->integer('signature_id')->unsigned()->nullable()->index();
            $table->string('keypass')->nullable()->unique();
            $table->text('notes')->nullable(); 
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_crm_production_reports');
    }
}
