<?php namespace Bt\Maintenance\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateToolsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_maintenance_tools', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('name')->nullable();
            $table->string('suppliername')->nullable();
            $table->string('modelnumber')->nullable();
            $table->string('serialnumber')->nullable();
            $table->integer('vendor_id')->unsigned()->nullable()->index();
            $table->integer('quantity')->default(1);
            $table->integer('equipment_type_id')->unsigned()->nullable()->index();
            $table->date('puchased_date')->nullable();
            $table->date('caliberation_date')->nullable();
            $table->date('caliberation_expiery_date')->nullable();
            $table->integer('fileaway')->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('bt_maintenance_tools', function(Blueprint $table) {
            $table->string('make')->nullable();
        $table->string('partcode')->nullable();
        $table->integer('unittype_id')->nullable()->default(0);
        $table->string('tempimage')->nullable();
        });

        Schema::table('bt_maintenance_tools', function (Blueprint $table){
            $table->integer('is_diesel')->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_maintenance_tools');
    }
}
