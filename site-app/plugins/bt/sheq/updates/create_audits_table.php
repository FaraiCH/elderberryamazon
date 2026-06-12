<?php namespace Bt\SHEQ\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAuditsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_audits', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('auditdate')->nullable();
            $table->string('company')->nullable();
            $table->text('notes')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_audits');
    }
}
