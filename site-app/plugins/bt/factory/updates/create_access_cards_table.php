<?php namespace Bt\Factory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAccessCardsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_factory_access_cards', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable()->index(); ## Index this field
            $table->string('card')->unique();
            $table->date('issue_date')->nullable();
            $table->date('lost_date')->nullable();
            $table->text('reason_lost')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_factory_access_cards');
    }
}
