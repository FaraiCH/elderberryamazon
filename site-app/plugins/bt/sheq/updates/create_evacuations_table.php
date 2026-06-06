<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateEvacuationsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_evacuations', function (Blueprint $table) {
$table->engine = 'InnoDB';
$table->increments('id');
$table->date('date');
$table->text('comment');
$table->integer('created_by')->unsigned()->nullable()->index();
$table->integer('updated_by')->unsigned()->nullable()->index();
$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_evacuations');
    }
}
