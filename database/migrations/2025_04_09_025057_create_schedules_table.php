<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 先に関連テーブルを作成
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('opponents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 例: 小学6年, 中学1年, 高校3年
            $table->timestamps();
        });

        // schedules テーブル
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->onDelete('cascade');
            $table->foreignId('place_id')->constrained()->onDelete('cascade');
            $table->string('game'); // 試合形式
            $table->date('date'); // 日程
            $table->time('start_time'); // 開始時刻
            $table->time('end_time')->nullable(); // 終了時刻
            $table->integer('time'); // 試合時間
            $table->integer('interval'); // 試合間隔
            $table->integer('preliminary_group')->nullable(); // 予選グループ数
            $table->integer('qualifying_interval')->nullable(); // 予選試合間隔
            $table->integer('semi_final_interval')->nullable(); // 準決勝準備時間
            $table->integer('final_interval')->nullable(); // 決勝準備時間
            $table->integer('number_of_matches')->nullable(); // 試合数
            $table->integer('people'); // 試合人数
            $table->boolean('half_time_check')->default(false); // ハーフタイム判定
            $table->integer('half_time')->nullable(); // ハーフタイム時間
            $table->timestamps(); // 作成日時と更新日時
        });

        // 中間テーブル
        Schema::create('schedule_opponent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('opponent_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('schedule_school_year', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_school_year');
        Schema::dropIfExists('school_years');
        Schema::dropIfExists('schedule_opponent');
        Schema::dropIfExists('opponents');
        Schema::dropIfExists('places');
        Schema::dropIfExists('tournaments');
        Schema::dropIfExists('schedules');
    }
};
