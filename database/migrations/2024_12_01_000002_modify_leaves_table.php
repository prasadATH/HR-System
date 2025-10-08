<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            // Modify existing columns
            $table->decimal('duration', 8, 2)->change(); // Allow half days (0.5)
            
            // Add new columns
            $table->enum('leave_category', ['full_day', 'half_day', 'short_leave'])->after('leave_type');
            $table->enum('half_day_type', ['morning', 'evening'])->nullable()->after('leave_category');
            $table->enum('short_leave_type', ['morning', 'evening'])->nullable()->after('half_day_type');
            $table->time('start_time')->nullable()->after('start_date');
            $table->time('end_time')->nullable()->after('end_date');
            $table->boolean('is_no_pay')->default(false)->after('status');
            $table->decimal('no_pay_amount', 8, 2)->default(0)->after('is_no_pay');
        });
    }

    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->integer('duration')->change();
            $table->dropColumn([
                'leave_category',
                'half_day_type',
                'short_leave_type',
                'start_time',
                'end_time',
                'is_no_pay',
                'no_pay_amount'
            ]);
        });
    }
};