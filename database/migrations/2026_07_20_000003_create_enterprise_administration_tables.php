<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('group')->default('general')->index();
            $table->string('label');
            $table->string('type')->default('text');
            $table->json('value')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        Schema::create('enterprise_departments', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('enterprise_teams', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')->constrained('enterprise_departments')->cascadeOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->foreignId('lead_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['department_id', 'name'], 'admin_team_department_name_unique');
        });

        Schema::create('enterprise_positions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('enterprise_departments')->nullOnDelete();
            $table->string('title');
            $table->string('code')->unique();
            $table->string('level')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('reporting_calendars', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('frequency')->default('weekly');
            $table->unsignedTinyInteger('reporting_day')->default(5);
            $table->unsignedTinyInteger('due_day')->default(1);
            $table->json('reminder_days')->nullable();
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('workflow_configurations', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('version')->default(1);
            $table->json('stages');
            $table->json('transitions');
            $table->json('applies_to')->nullable();
            $table->boolean('active')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('enterprise_notification_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->boolean('enabled')->default(true)->index();
            $table->json('channels');
            $table->string('frequency')->default('instant');
            $table->json('recipients')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('enterprise_ai_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('provider')->default('openai');
            $table->string('model')->nullable();
            $table->boolean('enabled')->default(true)->index();
            $table->boolean('fallback_enabled')->default(true);
            $table->json('options')->nullable();
            $table->timestamps();
        });

        Schema::create('feature_flags', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(false)->index();
            $table->string('scope')->default('global');
            $table->unsignedTinyInteger('rollout_percentage')->default(100);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_flags');
        Schema::dropIfExists('enterprise_ai_settings');
        Schema::dropIfExists('enterprise_notification_settings');
        Schema::dropIfExists('workflow_configurations');
        Schema::dropIfExists('reporting_calendars');
        Schema::dropIfExists('enterprise_positions');
        Schema::dropIfExists('enterprise_teams');
        Schema::dropIfExists('enterprise_departments');
        Schema::dropIfExists('company_settings');
    }
};
