<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateWhistleBlowersTable Migration
 */
class CreateWhistleBlowersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_whistle_blowers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->string('who')->nullable();
            $table->string('where')->nullable();
            $table->text('what')->nullable();
            $table->text('how')->nullable();
            $table->timestamps();
        });
        
        Schema::table('bt_sheq_whistle_blowers', function (Blueprint $table) {
            $table->boolean('reported')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_whistle_blowers');
    }
}
