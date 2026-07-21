<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('weekly_report_id')->constrained('weekly_reports')->cascadeOnDelete();
            $table->foreignId('uploaded_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('current_version_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->default('general')->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['weekly_report_id', 'category']);
        });

        Schema::create('report_document_versions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('report_document_id')->constrained('report_documents')->cascadeOnDelete();
            $table->foreignId('uploaded_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('version_number');
            $table->string('disk')->default('public');
            $table->string('path');
            $table->string('original_filename');
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->string('checksum', 64)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['report_document_id', 'version_number'], 'rdv_document_version_unique');
        });

        Schema::table('report_documents', function (Blueprint $table): void {
            $table->foreign('current_version_id')
                ->references('id')
                ->on('report_document_versions')
                ->nullOnDelete();
        });

        Schema::create('document_comments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('report_document_id')->constrained('report_documents')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('document_comments')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('body');
            $table->json('mentions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['report_document_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_comments');

        Schema::table('report_documents', function (Blueprint $table): void {
            $table->dropForeign(['current_version_id']);
        });

        Schema::dropIfExists('report_document_versions');
        Schema::dropIfExists('report_documents');
    }
};
