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
        Schema::create('bottling_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer_information')->onDelete('cascade');
            $table->string('service');
            $table->string('brand_name')->nullable();
            $table->integer('year')->nullable();
            $table->string('variety')->nullable();
            $table->integer('volume')->nullable();
            $table->string('tank')->nullable();
            $table->string('pre_bottling_filtration')->nullable();
            $table->string('filtration_bottling')->nullable();
            $table->string('gas_protection')->nullable();
            $table->string('bottle_type')->nullable();
            $table->string('manufacturer_code')->nullable();
            $table->string('bottle_color')->nullable();
            $table->string('bottle_size')->nullable();
            $table->string('closure_type')->nullable();
            $table->string('labelling')->nullable();
            $table->integer('label_height')->nullable();
            $table->boolean('sample_bottle')->nullable();
            $table->string('packing_requirements')->nullable();
            $table->string('cartoon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bottling_details');
    }
};
