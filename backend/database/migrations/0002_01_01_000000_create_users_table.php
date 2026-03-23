<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->json('contact')->nullable();
            $table->string('job_title')->nullable();
            $table->boolean('remote')->default(true);
            $table->boolean('is_active')->default(true);
            $table->uuid('group_id')->nullable();
            $table->datetime('vacation_until')->nullable();
            $table->datetime('last_login_at')->nullable();
            $table->datetime('last_action_at')->nullable();
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
