<?php

namespace App\Services\AI;

use App\Models\User;
use App\Models\WeeklyReport;

class ReportAiAssistantService
{
    public function __construct(
        protected WeeklyReportAiService $weeklyReportAi,
        protected AiPromptCatalog $prompts,
        protected AiHistoryService $history,
    ) {}

    public function generate(
        User $user,
        WeeklyReport $report,
        string $action,
        array $context = [],
    ): array {
        $persist = (bool) ($context['persist'] ?? false);
        $content = $action === AiPromptCatalog::ACTION_EXECUTIVE_SUMMARY
            ? $this->weeklyReportAi->generateExecutiveSummary($report)
            : $this->weeklyReportAi->generateFromPrompt(
                $this->prompts->reportAction($action, $report, $context),
            );

        if ($persist && $action === AiPromptCatalog::ACTION_EXECUTIVE_SUMMARY) {
            $report->update([
                'executive_summary' => $content,
            ]);
        }

        $activity = $this->history->logGeneration(
            user: $user,
            report: $report,
            action: $action,
            content: $content,
            metadata: [
                'provider' => $this->weeklyReportAi->lastProviderName(),
                'model' => $this->weeklyReportAi->lastModelName(),
                'section' => $context['section'] ?? null,
                'persisted' => $persist && $action === AiPromptCatalog::ACTION_EXECUTIVE_SUMMARY,
            ],
        );

        return [
            'action' => $action,
            'content' => $content,
            'provider' => $this->weeklyReportAi->lastProviderName(),
            'model' => $this->weeklyReportAi->lastModelName(),
            'report' => $report->fresh(),
            'history_id' => $activity->id,
            'metadata' => [
                'section' => $context['section'] ?? null,
                'persisted' => $persist && $action === AiPromptCatalog::ACTION_EXECUTIVE_SUMMARY,
            ],
            'created_at' => $activity->created_at,
        ];
    }
}