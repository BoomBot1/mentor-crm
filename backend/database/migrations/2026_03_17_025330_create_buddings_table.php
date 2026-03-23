<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('buddings', static function (Blueprint $table) {
            $table->uuid('mentor_id')->nullable();
            $table->uuid('trainee_id')->nullable();
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->timestamps();
            $table->foreign('trainee_id')
                ->references('id')
                ->on('trainees');
            $table->foreign('mentor_id')
                ->references('id')
                ->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buddings');
    }
};
