<?php namespace Bt\QC\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQMSSTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_q_m_s_s', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('document_name')->nullable();
            $table->string('rev')->nullable();
            $table->string('iso_ref')->nullable();
            $table->string('document_type')->nullable();
            $table->string('area')->nullable();
            $table->string('allocated_number')->nullable();
            $table->string('document_number')->nullable();
            $table->date('revised_effective_date')->nullable();
            $table->date('first_issue_date')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_q_m_s_s');
    }
}
