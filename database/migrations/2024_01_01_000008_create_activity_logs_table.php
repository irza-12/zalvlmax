<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('loggable_type')->nullable()->comment('Polymorphic relation type');
            $table->unsignedBigInteger('loggable_id')->nullable()->comment('Polymorphic relation id');
            $table->string('action', 50)->comment('create, update, delete, login, logout, etc');
            $table->text('description')->nullable();
            $table->json('properties')->nullable()->comment('Data perubahan');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index(['loggable_type', 'loggable_id'], 'idx_loggable');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
