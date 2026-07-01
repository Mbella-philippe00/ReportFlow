<?php

namespace App\Services;

use App\Models\WeeklyReport;
use App\Services\AI\WeeklyReportAiService;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Style\Alignment;

class PowerPointGenerator
{
    public function generate(WeeklyReport $report): string
    {
        $employee = $report->employee;

        $ppt = new PhpPresentation;

        /*
        |--------------------------------------------------------------------------
        | Slide 1 - Couverture
        |--------------------------------------------------------------------------
        */

        $slide = $ppt->getActiveSlide();

        $shape = $slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(700)
            ->setOffsetX(50)
            ->setOffsetY(80);

        $shape->getActiveParagraph()->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $shape->createTextRun("REPORTING DES ACTIVITÉS HEBDOMADAIRES\n\n")
            ->getFont()
            ->setBold(true)
            ->setSize(24);

        $shape->createTextRun("Semaine : {$report->week}\n\n");
        $shape->createTextRun("Département : {$report->department}\n\n");
        $shape->createTextRun($employee->full_name);

        /*
        |--------------------------------------------------------------------------
        | Slide 2 - Objectifs
        |--------------------------------------------------------------------------
        */

        $slide = $ppt->createSlide();

        $slide->createRichTextShape()
            ->setHeight(400)
            ->setWidth(700)
            ->setOffsetX(40)
            ->setOffsetY(40)
            ->createTextRun(
                "OBJECTIFS\n\n".
                ($report->objectives ?? 'Aucun objectif')
            );

        /*
        |--------------------------------------------------------------------------
        | Slide 3 - Activités
        |--------------------------------------------------------------------------
        */

        $slide = $ppt->createSlide();

        $slide->createRichTextShape()
            ->setHeight(400)
            ->setWidth(700)
            ->setOffsetX(40)
            ->setOffsetY(40)
            ->createTextRun(
                "ACTIVITÉS RÉALISÉES\n\n".
                ($report->activities ?? 'Aucune activité')
            );

        /*
        |--------------------------------------------------------------------------
        | Slide 4 - Difficultés
        |--------------------------------------------------------------------------
        */

        $slide = $ppt->createSlide();

        $slide->createRichTextShape()
            ->setHeight(400)
            ->setWidth(700)
            ->setOffsetX(40)
            ->setOffsetY(40)
            ->createTextRun(
                "DIFFICULTÉS RENCONTRÉES\n\n".
                ($report->difficulties ?? 'Aucune difficulté')
            );

        /*
        |--------------------------------------------------------------------------
        | Slide 5 - Résumé exécutif
        |--------------------------------------------------------------------------
        */
        $report->executive_summary = $report->executive_summary ?? app(
            WeeklyReportAiService::class
        )->generateExecutiveSummary($report);

        /*
        |--------------------------------------------------------------------------
        | Slide 5 - Priorités
        |--------------------------------------------------------------------------
        */

        $slide = $ppt->createSlide();

        $slide->createRichTextShape()
            ->setHeight(400)
            ->setWidth(700)
            ->setOffsetX(40)
            ->setOffsetY(40)
            ->createTextRun(
                "PRIORITÉS DE LA SEMAINE PROCHAINE\n\n".
                ($report->next_actions ?? 'Aucune priorité')
            );

        /*
        |--------------------------------------------------------------------------
        | Slide 6 - Fin
        |--------------------------------------------------------------------------
        */

        $slide = $ppt->createSlide();

        $slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(700)
            ->setOffsetX(50)
            ->setOffsetY(120)
            ->createTextRun('Merci');

        /*
        |--------------------------------------------------------------------------
        | Sauvegarde
        |--------------------------------------------------------------------------
        */
        $filename = sprintf(
            'KBSAP_%s_%s.pptx',
            str_replace(' ', '_', $employee->full_name),
            str_replace(' ', '_', $report->week)
        );

        $relativePath = 'reports/'.$filename;

        $absolutePath = storage_path('app/public/'.$relativePath);

        if (! is_dir(dirname($absolutePath))) {
            mkdir(dirname($absolutePath), 0777, true);
        }

        $writer = IOFactory::createWriter($ppt, 'PowerPoint2007');
        $writer->save($absolutePath);

        return $relativePath;
    }
}
