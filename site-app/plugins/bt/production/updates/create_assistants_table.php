<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateAssistantsTable Migration
 *
 * @link https:docs.octobercms.com/3.x/extend/database/structure.html
 */
class CreateAssistantsTable extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('bt_production_assistants', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->nullable()->index();
            $table->dateTime('start_shift') ->nullable();
            $table->dateTime('end_shift')->nullable();
            $table->integer('controlsheet_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('bt_production_assistants');
    }
}
