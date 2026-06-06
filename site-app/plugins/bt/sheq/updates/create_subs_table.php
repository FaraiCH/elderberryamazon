<?php namespace Bt\SHEQ\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSubsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_subs', function(Blueprint $table) {
$table->engine = 'InnoDB';
$table->increments('id');
$table->string('name')->nullable();
$table->integer('category_id')->unsigned()->nullable()->index();
$table->integer('created_by')->unsigned()->nullable()->index();
$table->integer('updated_by')->unsigned()->nullable()->index();
$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_subs');
    }
}
