<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('approved_person')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('leaves', function (Blueprint $table) {
            $table->string('approved_person')->nullable(false)->change();
        });
    }
};