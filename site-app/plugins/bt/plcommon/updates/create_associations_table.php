<?php namespace Bt\PLCommon\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateAssociationsTable Migration
 */
class CreateAssociationsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_association', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('association__id')->unsigned()->nullable(); ### Task Id
            $table->string('tbl_association_type')->nullable(); ###Model Post
            $table->integer('tbl_association__id')->unsigned()->nullable(); ###Post Post

            $table->string('association__entity_a_table_name')->nullable(); ###Model Post
            $table->string('association__entity_b_table__id')->nullable();
            $table->integer('association__entity_b_record__id')->unsigned()->nullable();
            $table->integer('association__association_type_lookup__id')->unsigned()->nullable();

            $table->boolean('association__record_active')->default(true);
            $table->dateTime('association__datetime_to')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('association__id', 'assoc_id_idx');
            $table->index('tbl_association__id', 'tbl_assoc_id_idx');
            $table->index('association__entity_b_record__id', 'assoc_b_rec_idx');
            $table->index('association__association_type_lookup__id', 'assoc_type_idx');
        });
        Schema::dropIfExists('tbl_user_association');
         Schema::create('tbl_user_association', function (Blueprint $table) {
             $table->engine = 'InnoDB';
             $table->increments('id');

             $table->integer('association__id')->unsigned()->nullable(); ### Task Id
             $table->string('tbl_association_type')->nullable(); ###Model Post
             $table->integer('tbl_association__id')->unsigned()->nullable(); ###Post Post

            $table->string('association__entity_a_table_name')->nullable(); ###Model Post
            $table->string('association__entity_b_table__id')->nullable();
            $table->integer('association__entity_b_record__id')->unsigned()->nullable();
            $table->integer('association__association_type_lookup__id')->unsigned()->nullable();

             $table->boolean('association__record_active')->default(true);
             $table->dateTime('association__datetime_to')->nullable();
             $table->integer('user_rights')->nullable()->default(0);
             $table->timestamps();
             $table->softDeletes();

             $table->index('association__id', 'u_assoc_id_idx');
             $table->index('tbl_association__id', 'u_tbl_assoc_id_idx');
             $table->index('association__entity_b_record__id', 'u_assoc_b_rec_idx');
             $table->index('association__association_type_lookup__id', 'u_assoc_type_idx');
         });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_association');
    }
}
