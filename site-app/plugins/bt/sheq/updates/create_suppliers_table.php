<?php namespace Bt\Sheq\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sheq_suppliers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->string('company_description')->nullable();
            $table->string('items')->nullable();
            $table->string('nationality')->nullable();
            $table->string('person')->nullable();
            $table->string('email')->nullable();
            $table->integer('number')->nullable();
            $table->string('tax')->nullable();
            $table->string('bbbee')->nullable();
            $table->string('account')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sheq_suppliers');
    }
}
