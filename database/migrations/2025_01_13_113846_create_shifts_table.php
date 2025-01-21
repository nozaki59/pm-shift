<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();  // 主キー
            $table->unsignedBigInteger('employee_id');  // 社員ID
            $table->date('shift_date');  // 日付
            $table->integer('shift_type');  // 勤務形態
            $table->time('start_time');  // 勤務開始時間
            $table->time('end_time');  // 勤務終了時間
            $table->timestamps();  // 作成日時と更新日時
        });
    }

    public function down()
    {
        Schema::dropIfExists('shifts');
    }
}
