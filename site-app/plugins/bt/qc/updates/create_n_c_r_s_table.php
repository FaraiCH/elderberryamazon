<?php namespace Bt\QC\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateNCRSTable extends Migration
{
    public function up()
    {
        Schema::create('bt_qc_n_c_r_s', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('customer_name')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('quote_id')->nullable()->unsigned();
            $table->text('comments_customer');
            $table->text('comments_bt');
            $table->integer('isresolved')->nullable()->default(0);
            $table->integer('department_id')->unsigned()->nullable()->index();
            $table->text('comments_risk');
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->timestamps();
        });
        Schema::table('bt_qc_n_c_r_s', function(Blueprint $table) {
            $table->integer('type_id')->unsigned()->nullable()->index();
            $table->date('closing_date')->nullable();
            $table->text('follow_up');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_qc_n_c_r_s');
    }
}
