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
        Schema::create('failed_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_request_id')
                ->index()
                ->constrained('api_requests')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->json('messages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_validations');
    }
};
