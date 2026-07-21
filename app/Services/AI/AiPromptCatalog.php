<?php

namespace App\Services\AI;

use App\Models\WeeklyReport;

class AiPromptCatalog
{
    public const ACTION_EXECUTIVE_SUMMARY = 'executive_summary';
    public const ACTION_WRITING_IMPROVEMENT = 'writing_improvement';
    public const ACTION_WRITING_SUGGESTIONS = 'writing_suggestions';
    public const ACTION_GRAMMAR_TONE = 'grammar_tone';
    public const ACTION_ACTION_ITEMS = 'action_items';
    public const ACTION_RISK_ANALYSIS = 'risk_analysis';
    public const ACTION_PRIORITY_DETECTION = 'priority_detection';
    public const ACTION_MISSING_INFORMATION = 'missing_information';
    public const ACTION_QUALITY_SCORE = 'quality_score';
    public const ACTION_WORKFLOW_RECOMMENDATION = 'workflow_recommendation';
    public const ACTION_POWERPOINT_SUMMARY = 'powerpoint_summary';
    public const ACTION_REWRITE_PROFESSIONALLY = 'rewrite_professionally';
    public const ACTION_SUMMARIZE_REPORT = 'summarize_report';
    public const ACTION_EXPAND_REPORT = 'expand_report';
    public const ACTION_SUGGEST_NEXT_ACTIONS = 'suggest_next_actions';
    public const ACTION_SUGGEST_OBJECTIVES = 'suggest_objectives';
    public const ACTION_HIGHLIGHT_MISSING_SECTIONS = 'highlight_missing_sections';

    public const REPORT_ASSISTANT_ACTIONS = [
        self::ACTION_WRITING_IMPROVEMENT,
        self::ACTION_WRITING_SUGGESTIONS,
        self::ACTION_GRAMMAR_TONE,
        self::ACTION_ACTION_ITEMS,
        self::ACTION_RISK_ANALYSIS,
        self::ACTION_PRIORITY_DETECTION,
        self::ACTION_MISSING_INFORMATION,
        self::ACTION_QUALITY_SCORE,
        self::ACTION_POWERPOINT_SUMMARY,
        self::ACTION_REWRITE_PROFESSIONALLY,
        self::ACTION_SUMMARIZE_REPORT,
        self::ACTION_EXPAND_REPORT,
        self::ACTION_SUGGEST_NEXT_ACTIONS,
        self::ACTION_SUGGEST_OBJECTIVES,
        self::ACTION_HIGHLIGHT_MISSING_SECTIONS,
    ];

    public const ALL_ACTIONS = [
        self::ACTION_EXECUTIVE_SUMMARY,
        self::ACTION_WRITING_IMPROVEMENT,
        self::ACTION_WRITING_SUGGESTIONS,
        self::ACTION_GRAMMAR_TONE,
        self::ACTION_ACTION_ITEMS,
        self::ACTION_RISK_ANALYSIS,
        self::ACTION_PRIORITY_DETECTION,
        self::ACTION_MISSING_INFORMATION,
        self::ACTION_QUALITY_SCORE,
        self::ACTION_WORKFLOW_RECOMMENDATION,
        self::ACTION_POWERPOINT_SUMMARY,
        self::ACTION_REWRITE_PROFESSIONALLY,
        self::ACTION_SUMMARIZE_REPORT,
        self::ACTION_EXPAND_REPORT,
        self::ACTION_SUGGEST_NEXT_ACTIONS,
        self::ACTION_SUGGEST_OBJECTIVES,
        self::ACTION_HIGHLIGHT_MISSING_SECTIONS,
    ];

    public function executiveSummary(WeeklyReport $report): string
    {
        return <<<PROMPT
Tu es un assistant sp?cialis? dans les rapports d'activit? professionnels.

G?n?re un r?sum? ex?cutif professionnel de 5 ? 8 lignes maximum ? partir des informations suivantes.

Semaine : {$report->week}

Objectifs :
{$report->objectives}

Activit?s :
{$report->activities}

R?alisations :
{$report->achievements}

Difficult?s :
{$report->difficulties}

Actions pr?vues :
{$report->next_actions}

Le r?sum? doit :
- ?tre r?dig? en fran?ais professionnel ;
- ?tre concis ;
- mettre en avant les r?alisations ;
- mentionner les difficult?s importantes ;
- annoncer les prochaines actions.
PROMPT;
    }

    public function reportAction(string $action, WeeklyReport $report, array $context = []): string
    {
        $reportContext = $this->reportContext($report, $context);
        $instructions = $this->instructions($action);
        $extraInstructions = trim((string) ($context['instructions'] ?? ''));

        return <<<PROMPT
Tu es l'assistant IA de ReportFlow, sp?cialis? dans les rapports hebdomadaires d'entreprise.

Objectif de la demande : {$instructions}

Contexte du rapport :
{$reportContext}

Instructions suppl?mentaires utilisateur :
{$extraInstructions}

R?ponds en fran?ais professionnel. Sois structur?, actionnable, concis, et n'invente pas de faits absents du rapport.
PROMPT;
    }

    private function reportContext(WeeklyReport $report, array $context): string
    {
        $selectedText = trim((string) ($context['text'] ?? ''));
        $section = trim((string) ($context['section'] ?? ''));

        return <<<TEXT
Rapport #{$report->id}
Semaine : {$report->week}
D?partement : {$report->department}
Statut : {$report->status->value}
Section cibl?e : {$section}
Texte fourni par l'utilisateur :
{$selectedText}

Objectifs :
{$report->objectives}

Activit?s :
{$report->activities}

R?alisations :
{$report->achievements}

Difficult?s :
{$report->difficulties}

Actions pr?vues :
{$report->next_actions}

R?sum? ex?cutif existant :
{$report->executive_summary}
TEXT;
    }

    private function instructions(string $action): string
    {
        return match ($action) {
            self::ACTION_WRITING_IMPROVEMENT => 'Am?liore la clart?, la structure et la pr?cision du texte du rapport.',
            self::ACTION_WRITING_SUGGESTIONS => 'Fournis des suggestions concr?tes pour am?liorer la r?daction du rapport.',
            self::ACTION_GRAMMAR_TONE => 'Corrige la grammaire, harmonise le ton, et rends le texte plus professionnel.',
            self::ACTION_ACTION_ITEMS => 'Extrais les actions ? mener, responsables probables, ?ch?ances implicites et d?pendances.',
            self::ACTION_RISK_ANALYSIS => 'Identifie les risques, blocages, signaux faibles et impacts potentiels.',
            self::ACTION_PRIORITY_DETECTION => 'D?duis les priorit?s principales ? partir des objectifs, difficult?s et prochaines actions.',
            self::ACTION_MISSING_INFORMATION => 'D?tecte les informations manquantes ou insuffisamment pr?cises dans le rapport.',
            self::ACTION_QUALITY_SCORE => '?value la qualit? du rapport sur 100 avec justification et axes d?am?lioration.',
            self::ACTION_WORKFLOW_RECOMMENDATION => 'Recommande une d?cision de workflow: approuver, demander des pr?cisions, ou rejeter avec justification.',
            self::ACTION_POWERPOINT_SUMMARY => 'Pr?pare une synth?se concise adapt?e ? une pr?sentation PowerPoint ex?cutive.',
            self::ACTION_REWRITE_PROFESSIONALLY => 'R??cris le contenu dans un style professionnel, clair et orient? management.',
            self::ACTION_SUMMARIZE_REPORT => 'R?sume le rapport en mettant en avant r?alisations, difficult?s et prochaines ?tapes.',
            self::ACTION_EXPAND_REPORT => 'D?veloppe le contenu existant sans inventer de faits et en conservant le sens m?tier.',
            self::ACTION_SUGGEST_NEXT_ACTIONS => 'Propose des prochaines actions r?alistes ? partir du contenu du rapport.',
            self::ACTION_SUGGEST_OBJECTIVES => 'Propose des objectifs pr?cis et mesurables pour la prochaine p?riode.',
            self::ACTION_HIGHLIGHT_MISSING_SECTIONS => 'Liste les sections faibles, vides ou manquantes et explique quoi ajouter.',
            default => 'Analyse le rapport et fournis une r?ponse utile et professionnelle.',
        };
    }
}
