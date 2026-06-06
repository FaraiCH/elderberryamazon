<?php namespace Bt\Hr\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePoliciesTable Migration
 */
class CreatePoliciesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_policies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('is_visible')->nullable()->default(0);
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });

        Schema::table('bt_hr_policies', function (Blueprint $table){
            $table->integer('rev')->nullable();
            $table->dateTime('date')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_policies');
    }
}
