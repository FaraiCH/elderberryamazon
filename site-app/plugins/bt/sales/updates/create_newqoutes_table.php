<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateNewquoteTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_newquote', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('quote_status_id')->unsigned();

            $table->string('billing_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('vat_number')->nullable();

            $table->string('physical_address')->nullable();
            $table->string('physical_code')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('postal_code')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('notes')->nullable();
            $table->decimal('vat', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->decimal('totalvat', 15, 2)->nullable();
            $table->decimal('totalincvat', 15, 2)->nullable();

            $table->timestamps();
        });

          Schema::table('bt_sales_newquote', function(Blueprint $table) {
            $table->string('agency')->nullable();
            $table->integer('active')->nullable()->default(1);
            $table->integer('reason_for_quote_id')->nullable()->default(1);
            $table->integer('received_non_received_order_id')->nullable()->default(1);
            $table->date('closing_date')->nullable();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->string('quote_ref')->nullable();
            $table->integer('deliverytype_id')->nullable()->index();
            $table->index(['id', 'user_id', 'billing_name','company_name']);
            $table->integer('deliveryrequest')->nullable()->default(0);
            $table->dateTime('accept_date')->nullable();
            $table->string('key_pass')->nullable();
            $table->integer('invited')->nullable();
            $table->decimal('cash_rate')->nullable();
            $table->decimal('upfront_cash_payment')->nullable();
              $table->integer('show_cash_payment')->default(1);
         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_newquote');
    }
}
