<?php namespace Bt\Qc\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateReqcertificatesTable extends Migration
{
    public function up()
    {
       Schema::create('bt_qc_reqcertificates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quote_id')->nullable()->index();
            $table->integer('pipe_id')->nullable()->index();
            $table->integer('coc')->nullable();
            $table->integer('coa')->nullable();
            $table->integer('created_by')->nullable()->index();
            $table->integer('updated_by')->nullable()->index();
            $table->integer('completed')->nullable();

            $table->text('items')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
       });

    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_reqcertificates');
    }
}
