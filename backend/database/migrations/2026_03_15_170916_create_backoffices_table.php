<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backoffices', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('contact')->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('group_id')->nullable();
            $table->datetime('last_action_at')->nullable();
            $table->datetime('vacation_until')->nullable();
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backoffices');
    }
};
