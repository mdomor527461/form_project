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
        Schema::create('customer_information', function (Blueprint $table) {
            $table->id();
            $table->string('winery');
            $table->date('bottling_date');
            $table->string('bottling_address');
            $table->string('city');
            $table->string('zip');
            $table->string('contact_person');
            $table->string('contact_phone');
            $table->string('email');
            $table->string('power');
            $table->text('special_requirements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_information');
    }
};
