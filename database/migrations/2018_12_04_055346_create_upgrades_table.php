<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->string('desc')->default('')->comment('描述');
            $table->string('version')->default('')->comment('版本号');
            $table->string('download_url')->default('')->comment('下载链接');
            $table->string('client_type')->default('')->comment('客户端类型:mac,windows,ipad,ios,aos');
            $table->tinyInteger('is_force')->default(0)->comment('是否强制:0 不强制，1 强制');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upgrades');
    }
}
