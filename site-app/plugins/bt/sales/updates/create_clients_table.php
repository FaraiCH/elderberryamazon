<?php namespace Bt\Sales\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateClientsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bt_sales_clients')) {
            Schema::create('bt_sales_clients', function(Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('company_name')->nullable();
                $table->string('contact_name')->nullable();
                $table->string('contact_email')->nullable();
                $table->string('contact_number')->nullable();
                $table->string('physical_address')->nullable();
                $table->string('physical_code')->nullable();
                $table->string('postal_address')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('vatno')->nullable();
                $table->string('vendorno')->nullable();
                $table->string('coreg')->nullable();
                $table->decimal('limit', 15, 2)->nullable()->default(0);
                $table->integer('is_cod')->nullable()->default(0);
                $table->integer('user_id')->nullable()->index();
                $table->integer('client_category_id')->nullable()->index();
                $table->string('finance_contact_name')->nullable();
                $table->string('finance_contact_email')->nullable();
                $table->string('finance_contact_number')->nullable();
                $table->integer('created_by')->unsigned()->nullable()->index();
                $table->integer('updated_by')->unsigned()->nullable()->index();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bt_sales_clients');
    }
}
