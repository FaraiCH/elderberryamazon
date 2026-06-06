<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_products', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('product_code')->nullable();
            $table->integer('active')->nullable()->default(0);
            $table->integer('pn_ratings_id')->nullable()->unsigned();
            $table->decimal('value', 15, 3)->nullable();
            $table->integer('diameter_id')->nullable()->unsigned();
            $table->integer('unitlength_id')->nullable()->unsigned();
            $table->decimal('od_min', 15, 1)->nullable();
            $table->decimal('old_mass', 15, 1)->nullable();
            $table->decimal('new_mass', 15, 1)->nullable();
            $table->decimal('od_max', 15, 1)->nullable();
            $table->decimal('ovality_max', 15, 1)->nullable();
            $table->decimal('coil', 15, 1)->nullable();
            $table->decimal('wt_min', 15, 2)->nullable();
            $table->decimal('wt_max', 15, 2)->nullable();
            $table->decimal('wt_ave', 15, 2)->nullable();
            $table->decimal('pipe_id', 15, 1)->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_products');
    }
}
