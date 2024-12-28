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
        Schema::table('bottling_details', function (Blueprint $table) {
            $table->string('closure_description')->nullable()->after('closure_type');
            $table->string('apply_capsule')->nullable()->after('closure_description');
            $table->string('capsule_description')->nullable()->after('apply_capsule');
            $table->string('packaging_description')->nullable()->after('capsule_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bottling_details', function (Blueprint $table) {
            $table->dropColumn('closure_description');
            $table->dropColumn('apply_capsule');
            $table->dropColumn('capsule_description');
            $table->dropColumn('packaging_description');
        });
    }
};
