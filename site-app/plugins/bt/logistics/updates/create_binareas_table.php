<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBinareasTable Migration
 */
class CreateBinareasTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_binareas', function (Blueprint $table) {
            $table->increments('id');

            $table->string('area')->nullable();
            $table->integer('max_pipe')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->string('num_plate')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();


        });

        Schema::table('bt_logistics_binareas', function (Blueprint $table){
            $table->string('sub_location')->nullable();
            $table->integer('area_length')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_binareas');
    }
}
