<?php

namespace App\Plugins\Biubiubiu\src\database;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiubiubiuCiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('biubiubiu_ci')) {
            Schema::create('biubiubiu_ci', function (Blueprint $table) {
                $table->increments('id');
                $table->string('order')->comment('指令');
                $table->longText('content')->comment('回复内容');
                $table->string('type')->comment('类型');
                $table->string('class')->comment('分类');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biubiubiu_ci');
    }
}
