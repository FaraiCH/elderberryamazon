<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateSrnPaymentsTable Migration
 */
class CreateSrnPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('bt_sales_srn_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('invoice_date')->nullable();
            $table->string('logistic_company_name')->nullable();
            $table->decimal('supplier_amount', 15, 2)->nullable();
            $table->string('logistic_invoice_number')->nullable();
            $table->string('bt_customer_name')->nullable();
            $table->string('area')->nullable();
            $table->string('reason')->nullable();
            $table->decimal('bt_delivery_charged', 15, 2)->nullable();
            $table->integer('srn_id')->nullable()->unsigned();

            $table->decimal('r_per_kg', 15, 2)->nullable();
            $table->decimal('delivery_weight', 15, 2)->nullable();
            $table->decimal('invoiced_value_inc_vat', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_srn_payments');
    }
}
