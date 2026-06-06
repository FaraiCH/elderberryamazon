<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRequestUnapproveSrnsTable Migration
 */
class CreateRequestUnapproveSrnsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bt_sales_request_unapprove_srns')) {
            Schema::create('bt_sales_request_unapprove_srns', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('srn_id')->nullable()->unsigned();
                $table->boolean('is_used')->default(false);
                $table->string('reason')->nullable();
                $table->integer('created_by')->unsigned()->nullable()->index();
                $table->integer('updated_by')->unsigned()->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_request_unapprove_srns');
    }
}
