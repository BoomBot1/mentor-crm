<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainees', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mail')->unique();
            $table->smallInteger('capabilities')->default(0);
            $table->string('group_after')->nullable();
            $table->boolean('is_office')->default(false);
            $table->boolean('is_active')->default(true);
            $table->uuid('group_id')->nullable();
            $table->uuid('last_report_id')->nullable();
            $table->datetime('study_start_at')->nullable();
            $table->datetime('study_end_at')->nullable();
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
