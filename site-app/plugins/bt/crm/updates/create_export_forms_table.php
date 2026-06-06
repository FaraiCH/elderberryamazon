<?php namespace Bt\CRM\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateExportFormsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_crm_export_forms', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('formtitle')->nullable();
            $table->date('form_date')->nullable(); 
            $table->string('customsno')->nullable();
            $table->string('toname')->nullable();
            $table->string('towhom')->nullable();
            $table->text('declaration')->nullable();
            $table->text('listgoods')->nullable(); 
            $table->integer('signature_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_crm_export_forms');
    }
}
