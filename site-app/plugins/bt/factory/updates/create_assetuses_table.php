<?php namespace Bt\Factory\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAssetusesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_factory_assetuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('employee_id')->nullable()->index();
            $table->string('assettype_id')->nullable()->index();
            $table->string('serialnum')->nullable();
            $table->integer('pre-damage')->nullable();
            $table->integer('post-damage')->nullable();
            $table->integer('theft')->nullable();
            $table->date('dateissue')->nullable();
            $table->date('date-return')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_factory_assetuses');
    }
}