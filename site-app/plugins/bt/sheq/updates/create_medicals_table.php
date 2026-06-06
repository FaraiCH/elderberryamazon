<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateMedicalsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_medicals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->integer('is_medical')->nullable()->default(0);
            $table->integer('flue')->nullable()->default(0);
            $table->string('idnumber')->nullable();
            $table->text('flue_dates')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_medicals');
    }
}
