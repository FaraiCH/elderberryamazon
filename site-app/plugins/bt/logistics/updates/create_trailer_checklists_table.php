<?php namespace Bt\Logistics\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateTrailerChecklistsTable Migration
 */
class CreateTrailerChecklistsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_logistics_trailer_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('is_hazards_ok')->nullable()->default(0);
            $table->integer('is_brakes_ok')->nullable()->default(0);
            $table->integer('is_tires_ok')->nullable()->default(0);
            $table->integer('is_lights_ok')->nullable()->default(0);
            $table->integer('is_lefttires_ok')->nullable()->default(0);
        
            $table->string('brakes_comments')->nullable();
            $table->string('leftlights_comments')->nullable();
            $table->string('lights_comments')->nullable();
            $table->string('hazards_comments')->nullable();
            $table->string('tires_comments')->nullable();
            $table->integer('trailer_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_logistics_trailer_checklists');
    }
}
