<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weekly_reports', function (Blueprint $table): void {
            $table->index(['status', 'submitted_at'], 'weekly_reports_status_submitted_idx');
            $table->index(['employee_id', 'status'], 'weekly_reports_employee_status_idx');
            $table->index(['department', 'status'], 'weekly_reports_department_status_idx');
            $table->index(['week', 'status'], 'weekly_reports_week_status_idx');
            $table->index(['created_at'], 'weekly_reports_created_idx');
        });

        Schema::table('report_documents', function (Blueprint $table): void {
            $table->index(['weekly_report_id', 'deleted_at'], 'report_documents_report_deleted_idx');
            $table->index(['uploaded_by_id', 'created_at'], 'report_documents_uploader_created_idx');
            $table->index(['category', 'created_at'], 'report_documents_category_created_idx');
            $table->index(['current_version_id'], 'report_documents_current_version_idx');
        });

        Schema::table('report_document_versions', function (Blueprint $table): void {
            $table->index(['uploaded_by_id', 'created_at'], 'rdv_uploader_created_idx');
            $table->index(['mime_type'], 'rdv_mime_type_idx');
            $table->index(['extension'], 'rdv_extension_idx');
            $table->index(['created_at'], 'rdv_created_idx');
        });

        Schema::table('document_comments', function (Blueprint $table): void {
            $table->index(['user_id', 'created_at'], 'document_comments_user_created_idx');
            $table->index(['report_document_id', 'created_at'], 'document_comments_document_created_idx');
        });

        Schema::table('notifications', function (Blueprint $table): void {
            $table->index(['notifiable_type', 'notifiable_id', 'read_at'], 'notifications_notifiable_read_idx');
            $table->index(['notifiable_type', 'notifiable_id', 'archived_at'], 'notifications_notifiable_archived_idx');
            $table->index(['created_at'], 'notifications_created_idx');
        });

        Schema::table('activity_log', function (Blueprint $table): void {
            $table->index(['log_name', 'created_at'], 'activity_log_name_created_idx');
            $table->index(['subject_type', 'subject_id', 'created_at'], 'activity_log_subject_created_idx');
            $table->index(['causer_type', 'causer_id', 'created_at'], 'activity_log_causer_created_idx');
            $table->index(['event', 'created_at'], 'activity_log_event_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table): void {
            $table->dropIndex('activity_log_name_created_idx');
            $table->dropIndex('activity_log_subject_created_idx');
            $table->dropIndex('activity_log_causer_created_idx');
            $table->dropIndex('activity_log_event_created_idx');
        });

        Schema::table('notifications', function (Blueprint $table): void {
            $table->dropIndex('notifications_notifiable_read_idx');
            $table->dropIndex('notifications_notifiable_archived_idx');
            $table->dropIndex('notifications_created_idx');
        });

        Schema::table('document_comments', function (Blueprint $table): void {
            $table->dropIndex('document_comments_user_created_idx');
            $table->dropIndex('document_comments_document_created_idx');
        });

        Schema::table('report_document_versions', function (Blueprint $table): void {
            $table->dropIndex('rdv_uploader_created_idx');
            $table->dropIndex('rdv_mime_type_idx');
            $table->dropIndex('rdv_extension_idx');
            $table->dropIndex('rdv_created_idx');
        });

        Schema::table('report_documents', function (Blueprint $table): void {
            $table->dropIndex('report_documents_report_deleted_idx');
            $table->dropIndex('report_documents_uploader_created_idx');
            $table->dropIndex('report_documents_category_created_idx');
            $table->dropIndex('report_documents_current_version_idx');
        });

        Schema::table('weekly_reports', function (Blueprint $table): void {
            $table->dropIndex('weekly_reports_status_submitted_idx');
            $table->dropIndex('weekly_reports_employee_status_idx');
            $table->dropIndex('weekly_reports_department_status_idx');
            $table->dropIndex('weekly_reports_week_status_idx');
            $table->dropIndex('weekly_reports_created_idx');
        });
    }
};
