<?php

namespace App\Services\AI;

use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Http;

class WeeklyReportAiService
{
    public function generateExecutiveSummary(
        WeeklyReport $report
    ): string {

        $prompt = "
Tu es un assistant spécialisé dans les rapports d'activité professionnels.

Génère un résumé exécutif professionnel de 5 à 8 lignes maximum à partir des informations suivantes.

Semaine : {$report->week}

Objectifs :
{$report->objectives}

Activités :
{$report->activities}

Réalisations :
{$report->achievements}

Difficultés :
{$report->difficulties}

Actions prévues :
{$report->next_actions}

Le résumé doit :
- être rédigé en français professionnel ;
- être concis ;
- mettre en avant les réalisations ;
- mentionner les difficultés importantes ;
- annoncer les prochaines actions.
";

        $response = Http::post(
            'https://generativelanguage.googleapis.com/v1beta/models/'.
            env('GEMINI_MODEL', 'gemini-2.5-flash').
            ':generateContent?key='.
            env('GEMINI_API_KEY'),
            [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]
        );

        if (! $response->successful()) {
            throw new \Exception(
                'Gemini Error: '.$response->body()
            );
        }

        return trim(
            $response->json(
                'candidates.0.content.parts.0.text'
            )
        );
    }
}
