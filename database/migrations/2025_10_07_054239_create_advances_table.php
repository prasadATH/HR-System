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
        Schema::create('advances', function (Blueprint $table) {
            $table->id();
            $table->string('employment_ID');
            $table->decimal('advance_amount', 10, 2);
            $table->date('advance_date');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->text('description')->nullable();
            $table->json('advance_documents')->nullable();
            $table->timestamps();
            
            // Add index for better performance (optional but recommended)
            $table->index('employment_ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advances');
    }
};