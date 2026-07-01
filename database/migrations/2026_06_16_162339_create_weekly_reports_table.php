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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();

            $table->string('employee_name');
            $table->string('week');

            $table->longText('activities')->nullable();
            $table->longText('achievements')->nullable();
            $table->longText('difficulties')->nullable();
            $table->longText('next_actions')->nullable();

            $table->string('pptx_file')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
