<?php

namespace App\Mail;

use App\Models\WeeklyReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyReportValidatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public WeeklyReport $report;

    public function __construct(WeeklyReport $report)
    {
        $this->report = $report;
    }

    public function build(): self
    {
        return $this
            ->subject('Rapport hebdomadaire validé')
            ->view('emails.report-validated');
    }
}
