<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table) {

            $table->timestamp('submitted_at')->nullable();

            $table->timestamp('validated_at')->nullable();

            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('rejected_at')->nullable();

            $table->foreignId('rejected_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('rejection_reason')->nullable();

            $table->timestamp('generated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table) {

            $table->dropConstrainedForeignId('validated_by');
            $table->dropConstrainedForeignId('rejected_by');

            $table->dropColumn([
                'submitted_at',
                'validated_at',
                'rejected_at',
                'rejection_reason',
                'generated_at',
            ]);
        });
    }
};
