<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bt_sales_categories')) {
            Schema::create('bt_sales_categories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name')->nullable();
                $table->decimal('straight', 15, 2)->nullable()->default(0);
                $table->decimal('coil', 15, 2)->nullable()->default(0);
                $table->timestamps();
            });
        }

        // Handle the misspelled version if it exists or create it for compatibility
        if (!Schema::hasTable('bt_sales_catergories')) {
            Schema::create('bt_sales_catergories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_categories');
        Schema::dropIfExists('bt_sales_catergories');
    }
}
