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
             Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['duration', 'interest_rate']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
 
        Schema::table('loans', function (Blueprint $table) {
            $table->integer('duration');
            $table->decimal('interest_rate', 5, 2)->nullable()->comment('Annual interest rate in percentage');
        });
    }
};
