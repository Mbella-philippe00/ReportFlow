<h2>Rapport rejeté</h2>

<p>Bonjour,</p>

<p>
Votre rapport de la semaine
<strong>{{ $report->week }}</strong>
a été rejeté.
</p>

<p>
<strong>Motif :</strong><br>
{{ $report->rejection_reason }}
</p>

<p>
Veuillez corriger le rapport puis le soumettre à nouveau.
</p>

<p>
Cordialement,<br>
ReportFlow
</p>