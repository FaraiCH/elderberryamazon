<?php namespace Bt\Suppliers\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMaterialsuppliersTable Migration
 */
class CreateMaterialsuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('bt_suppliers_materialsuppliers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('beestatus')->nullable();
            $table->string('name_of_accreditation')->nullable();
            $table->string('accreditation_body')->nullable();
            $table->integer('department_id')->nullable();
            $table->dateTime('expiry_date_of_bee_cert')->nullable();
            $table->integer('is_blacklisted')->nullable();
            $table->integer('is_quality_accreditations')->nullable();
            $table->string('details_of_accreditation')->nullable();
            $table->text('blacklisted_notes')->nullable();
            $table->text('audits')->nullable();
            $table->text('extra_contacts')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('physical_code')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('vatno')->nullable();
            $table->string('vendorno')->nullable();
            $table->string('coreg')->nullable();
            $table->integer('cat_id')->unsigned()->nullable()->index();
            $table->string('website')->nullable();
            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->string('notes')->nullable();
            $table->integer('welike')->default(1);
            $table->integer('vendor_type_id')->nullable();
            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();
            $table->integer('risklevel_id')->unsigned()->nullable()->index();

            $table->timestamps();
        });

        Schema::table('bt_suppliers_materialsuppliers', function (Blueprint $table){
            $table->integer('category_id')->nullable()->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_suppliers_materialsuppliers');
    }
}
