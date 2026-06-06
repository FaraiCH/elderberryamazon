<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePpesTable extends Migration
{
    public function up()
    {

        Schema::create('bt_sheq_ppes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('crew')->nullable();
            $table->string('shoe_cover')->nullable();
            $table->string('mop_caps')->nullable();
            $table->string('beard_cover')->nullable();
            $table->string('boats')->nullable();
            $table->string('overall')->nullable();
            $table->string('gloves')->nullable();
            $table->timestamps();
        });
        Schema::table('bt_sheq_ppes', function (Blueprint $table){
            $table->string('thermal')->nullable();
            $table->string('jackets')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('side')->nullable();
            $table->integer('bootsqty')->nullable();
            $table->integer('overallqty')->nullable();
            $table->integer('glovesqty')->nullable();
            $table->integer('jacketsqty')->nullable();
            $table->integer('thermalqty')->nullable();
            $table->date('bootsdate')->nullable();
            $table->date('overalldate')->nullable();
            $table->date('glovesdate')->nullable();
            $table->date('jacketsdate')->nullable();
            $table->date('thermaldate')->nullable();
            $table->integer('ppetype_id')->nullable()->index();
            $table->integer('employee_id')->index()->nullable();
            $table->string('safety_shoes')->nullable();
            $table->integer('safety_shoes_qty')->nullable();
            $table->date('safety_shoes_date')->nullable();
            $table->string('safety_glasses')->nullable();
            $table->integer('safety_glasses_qty')->nullable();
            $table->date('safety_glasses_date')->nullable();
            $table->string('ear_plugs')->nullable();
            $table->integer('ear_plugs_qty')->nullable();
            $table->date('ear_plugs_date')->nullable();
            $table->string('protective_vest')->nullable();
            $table->integer('protective_vest_qty')->nullable();
            $table->date('protective_vest_date')->nullable();
            $table->string('hard_hat')->nullable();
            $table->integer('hard_hat_qty')->nullable();
            $table->date('hard_hat_date')->nullable();
            $table->string('tshirt')->nullable();
            $table->integer('tshirt_qty')->nullable();
            $table->date('tshirt_date')->nullable();


        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_ppes');
    }
}
