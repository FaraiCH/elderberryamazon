<?php namespace Bt\Production\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePipestickeritemsTable Migration
 */
class CreatePipestickeritemsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_production_pipestickeritems', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('controlsheet_id')->unsigned()->nullable()->index();

            $table->integer('sticker_id')->unsigned()->nullable()->index();

            $table->integer('binarea_id')->unsigned()->nullable()->index();
            $table->integer('qcstatus_id')->unsigned()->nullable()->index();
            $table->boolean('is_extra')->default(false);
            $table->datetime('qcdate')->nullable();


            $table->decimal('weight', 15, 1)->nullable()->default(0);
            $table->integer('counter')->nullable();

            $table->unique(['sticker_id', 'counter']);
            $table->timestamps();
        });
        Schema::table('bt_production_pipestickeritems', function (Blueprint $table){
            $table->integer('reason_id')->nullable()->index();
            $table->datetime('production_date')->nullable();
            $table->dateTime('bin_date')->nullable();
            $table->integer('pickslip_id')->nullable()->index();
            $table->dateTime('dispatch_date')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->integer('srn_id')->nullable()->index();
            $table->dateTime('srn_date')->nullable();
            $table->integer('product_id')->nullable()->index();
            $table->decimal('unit_length', 15, 2)->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->decimal('rand_per_kg', 15, 2)->nullable();
            $table->integer('is_scrap')->nullable()->default(0);
            $table->integer('prod_updated_by_id')->nullable()->index();
            $table->integer('qc_updated_by_id')->nullable()->index();
            $table->datetime('sticker_scanned_date')->nullable();
            $table->integer('is_active')->nullable()->default(1);
            $table->integer('wall_thickness_min')->nullable();
            $table->integer('wall_thickness_max')->nullable();
            $table->unsignedBigInteger('quote_item_id')->unsigned()->nullable()->index();
            $table->integer('batch_id')->unsigned()->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_production_pipestickeritems');
    }
}
