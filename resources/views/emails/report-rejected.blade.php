<div style='font-family: Inter, Arial, sans-serif; color: #0F172A; line-height: 1.6; max-width: 640px; margin: 0 auto; padding: 32px;'>
    <div style='margin-bottom: 28px;'>
        <img src='{{ asset('branding/reportflow-logo.png') }}' alt='ReportFlow' style='height: 44px; width: auto;'>
    </div>

    <div style='border: 1px solid #FEE2E2; border-radius: 24px; padding: 28px; background: #FFFFFF; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);'>
        <p style='margin: 0 0 8px; color: #EF4444; font-size: 12px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;'>Rejected</p>
        <h2 style='margin: 0 0 20px; font-size: 28px; letter-spacing: -0.04em;'>Rapport rejeté</h2>
        <p>Bonjour,</p>
        <p>Votre rapport de la semaine <strong>{{ $report->week }}</strong> a été rejeté.</p>
        <p><strong>Motif :</strong><br>{{ $report->rejection_reason }}</p>
        <p>Veuillez corriger le rapport puis le soumettre à nouveau.</p>
    </div>

    <p style='margin-top: 24px; color: #64748B; font-size: 14px;'>Cordialement,<br>ReportFlow</p>
</div>
