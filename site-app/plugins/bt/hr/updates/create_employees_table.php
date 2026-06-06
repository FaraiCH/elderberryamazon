<?php namespace Bt\HR\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('bt_hr_employees', function(Blueprint $table) {
            $table->integer('company_id')->unsigned()->nullable()->index();
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->text('biography')->nullable();

            $table->date('employment_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->string('termination_reason')->nullable();

            $table->integer('disabled_id')->unsigned()->nullable()->index();

            $table->integer('employmenttype_id')->unsigned()->nullable()->index();
            $table->integer('department_id')->unsigned()->nullable()->index();
            $table->integer('designation_id')->unsigned()->nullable()->index();

            $table->integer('created_by')->unsigned()->nullable()->index();
            $table->integer('updated_by')->unsigned()->nullable()->index();

            $table->timestamps();
        });

         Schema::table('bt_hr_employees', function (Blueprint $table){
            $table->integer('ethnicity_id')->nullable()->index()->unsigned();
            $table->integer('jobdescription_id')->nullable()->index()->unsigned();
            $table->integer("pay_roll")->nullable()->default(1);
            $table->dropColumn('disabled_id');
            $table->integer("is_user_active")->nullable()->default(1);
            $table->integer("gender")->nullable();
            $table->integer("is_emergency")->nullable()->default(0);
            $table->decimal('rate', 15, 2)->nullable()->default(0);
            $table->integer('pay_roll_type')->default(0);
            $table->integer('shifthours')->nullable()->default(0);
         });
    }

    public function down()
    {
        Schema::dropIfExists('bt_hr_employees');
    }
}
