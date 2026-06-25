<?php

namespace App\Services;

use App\Models\WeeklyReport;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Services\ExcelReportGenerator;

class ExcelReportGenerator
{
    public function generate(): string
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Employé');
        $sheet->setCellValue('B1', 'Département');
        $sheet->setCellValue('C1', 'Semaine');
        $sheet->setCellValue('D1', 'Statut');

        $row = 2;

        foreach (
            WeeklyReport::with('employee')
                ->orderByDesc('created_at')
                ->get() as $report
        ) {

            $sheet->setCellValue(
                'A'.$row,
                $report->employee?->full_name
            );

            $sheet->setCellValue(
                'B'.$row,
                $report->department
            );

            $sheet->setCellValue(
                'C'.$row,
                $report->week
            );

            $sheet->setCellValue(
                'D'.$row,
                $report->status
            );
            $report->executive_summary
                ? $sheet->setCellValue(
                    'E'.$row,
                    $report->executive_summary
                )
                : $sheet->setCellValue(
                    'E'.$row,
                    'Résumé IA non généré'
                );

            $row++;
        }

        $fileName =
            'reports_'.now()->format('Ymd_His').'.xlsx';

        $path =
            storage_path('app/public/'.$fileName);

        (new Xlsx($spreadsheet))->save($path);

        return 'public/'.$fileName;
    }
}