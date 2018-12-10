<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',32)->default('')->comment('昵称');
            $table->string('realname',32)->default('')->comment('真实姓名');
            $table->string('headimg')->default('')->comment('头像');
            $table->string('username')->unique()->comment('账户名');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('phone',15)->default('')->comment('电话号码');
            $table->string('wx',64)->default('')->comment('微信号');
            $table->smallInteger('qq')->default(0)->comment('qq号');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('token')->default('')->comment('token');
            $table->string('motto')->default('')->comment('个性签名');
            $table->smallInteger('status')->default(0)->comment('状态:0默认，');
            $table->smallInteger('type')->default(0)->comment('类型:0默认，1学生，2教师...');
            $table->integer('zan')->default(0)->comment('点赞次数');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
