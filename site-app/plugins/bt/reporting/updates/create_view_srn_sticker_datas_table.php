<?php namespace Bt\Reporting\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateViewSrnStickerDatasTable Migration
 */
class CreateViewSrnStickerDatasTable extends Migration
{
    public function up()
    {
        Schema::create('bt_reporting_view_srn_sticker_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bt_reporting_view_srn_sticker_datas');
    }
}
