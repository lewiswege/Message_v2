<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('conversation_id')->constrained()->cascadeOnDelete();
            $table->string('direction');
            $table->string('channel');
            $table->string('provider');
            $table->string('channel_message_id')->nullable();
            $table->foreignUlid('reply_to_message_id')->nullable()->constrained('messages')->nullOnDelete();
            $table->string('content_type');
            $table->longText('content')->nullable();
            $table->json('metadata')->nullable();
            $table->string('status');
            $table->timestamp('status_updated_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->foreignId('sent_by_agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index('channel');
            $table->index('provider');
            $table->index('status');
            $table->index('created_at');
            $table->index('channel_message_id');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
