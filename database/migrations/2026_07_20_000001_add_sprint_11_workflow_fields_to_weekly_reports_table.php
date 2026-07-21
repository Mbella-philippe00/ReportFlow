<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->timestamp('under_review_at')->nullable()->after('submitted_at');

            $table->timestamp('approved_at')->nullable()->after('validated_by');

            $table->foreignId('approved_by')
                ->nullable()
                ->after('approved_at')
                ->constrained('users')
                ->nullOnDelete();

            $table->text('manager_comment')->nullable()->after('approved_by');
        });

        DB::table('weekly_reports')
            ->where('status', 'manager_approved')
            ->update([
                'status' => 'under_review',
                'under_review_at' => DB::raw('validated_at'),
            ]);

        DB::table('weekly_reports')
            ->where('status', 'generated')
            ->update([
                'status' => 'approved',
                'under_review_at' => DB::raw('validated_at'),
                'approved_at' => DB::raw('generated_at'),
                'approved_by' => DB::raw('validated_by'),
            ]);
    }

    public function down(): void
    {
        DB::table('weekly_reports')
            ->where('status', 'under_review')
            ->update(['status' => 'manager_approved']);

        DB::table('weekly_reports')
            ->where('status', 'approved')
            ->update(['status' => 'generated']);

        Schema::table('weekly_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn([
                'under_review_at',
                'approved_at',
                'manager_comment',
            ]);
        });
    }
};
