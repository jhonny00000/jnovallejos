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
        Schema::table('users', function (Blueprint $table) {
            $table->string('a_paterno')->nullable()->after('name');
            $table->string('a_materno')->nullable()->after('a_paterno');
            $table->string('ci')->nullable()->after('a_materno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['a_paterno', 'a_materno', 'ci']);
        });
    }
};
