<?php namespace Bt\JSEData\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_jsedata_companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('ticker')->nullable();
            $table->string('altticker')->nullable();
            $table->integer('industry_id')->unsigned()->nullable()->index();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_jsedata_companies', function (Blueprint $table) {
            $table->integer('isspecial')->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_jsedata_companies');
    }
}
