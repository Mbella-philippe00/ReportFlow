import { AlertCircle, FileText, MoveLeft } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useNavigate, useParams } from 'react-router-dom';

import { NoPermission } from '@/components/business/common/NoPermission';
import { ReportStatusBadge } from '@/components/business/reports/ReportStatusBadge';
import { ReportSummaryCard } from '@/components/business/reports/ReportSummaryCard';
import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Skeleton } from '@/components/ui';
import { useReportQuery } from '@/features/reports/hooks/useReports';
import { formatReportDate, getEmployeeName, getReportTitle, hasReportPermission } from '@/features/reports/utils/report-utils';
import { useAuthStore } from '@/stores/auth.store';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';

import { RejectionDialog } from '../components/RejectionDialog';
import { WorkflowActionButtons } from '../components/WorkflowActionButtons';
import { WorkflowConfirmDialog } from '../components/WorkflowConfirmDialog';
import { WorkflowStepperPanel } from '../components/WorkflowStepperPanel';
import { WorkflowTimelinePanel } from '../components/WorkflowTimelinePanel';
import { useWorkflowActionRunner } from '../hooks/useWorkflowActionRunner';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'The approval report could not be loaded.');

type ConfirmActionState = {
    action: Exclude<ReportWorkflowAction, 'reject'>;
    report: WeeklyReport;
};

function ApprovalPageSkeleton() {
    return (
        <PageContainer description="Loading approval details from the Reports API." eyebrow="Workflow" title="Approval">
            <Skeleton className="h-32" />
            <div className="grid gap-6 lg:grid-cols-[minmax(0,1fr)_24rem]">
                <Skeleton className="h-96" />
                <Skeleton className="h-96" />
            </div>
        </PageContainer>
    );
}

function ContentSection({ title, value }: { title: string; value: string | null }) {
    return (
        <section className="rounded-2xl border bg-background p-4">
            <h3 className="text-sm font-semibold text-foreground">{title}</h3>
            <p className="mt-3 whitespace-pre-line text-sm leading-7 text-muted-foreground">{value || 'Not provided'}</p>
        </section>
    );
}

export function WorkflowApprovalPage() {
    const navigate = useNavigate();
    const { id } = useParams();
    const reportId = Number(id);
    const user = useAuthStore((state) => state.user);
    const [confirmAction, setConfirmAction] = useState<ConfirmActionState | null>(null);
    const [rejectionReport, setRejectionReport] = useState<WeeklyReport | null>(null);
    const reportQuery = useReportQuery(Number.isFinite(reportId) ? reportId : undefined);
    const { isPending, pendingAction, runWorkflowAction } = useWorkflowActionRunner();

    useEffect(() => {
        document.title = 'Approval - ReportFlow';
    }, []);

    const requestWorkflowAction = (action: ReportWorkflowAction, report: WeeklyReport) => {
        if (action === 'reject') {
            setRejectionReport(report);
            return;
        }

        setConfirmAction({ action, report });
    };

    if (!Number.isFinite(reportId) || reportId <= 0) {
        return (
            <PageContainer description="The requested report identifier is invalid." eyebrow="Workflow" title="Approval not found">
                <EmptyState action={{ label: 'Back to workflow', onClick: () => navigate('/workflow') }} icon={<FileText aria-hidden="true" className="size-10" />} title="Invalid approval" description="Open an approval item from the Workflow page." />
            </PageContainer>
        );
    }

    if (!hasReportPermission(user, 'reports.view')) {
        return (
            <PageContainer description="Viewing approval details requires report visibility." eyebrow="Workflow" title="Approval restricted">
                <NoPermission action={{ label: 'Back to workflow', onClick: () => navigate('/workflow') }} description="Your account does not expose reports.view permission." title="Approval access restricted" />
            </PageContainer>
        );
    }

    if (reportQuery.isLoading) {
        return <ApprovalPageSkeleton />;
    }

    if (reportQuery.isError) {
        return (
            <PageContainer description="The Reports API returned an error." eyebrow="Workflow" title="Approval">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load approval" description={getErrorMessage(reportQuery.error)} />
            </PageContainer>
        );
    }

    const report = reportQuery.data?.data;

    if (!report) {
        return (
            <PageContainer description="No report was returned by the Reports API." eyebrow="Workflow" title="Approval not found">
                <EmptyState action={{ label: 'Back to workflow', onClick: () => navigate('/workflow') }} icon={<FileText aria-hidden="true" className="size-10" />} title="Approval not found" description="The report may have been deleted or is no longer available." />
            </PageContainer>
        );
    }

    return (
        <PageContainer
            actions={
                <div className="flex flex-wrap items-center gap-2">
                    <Button leftIcon={<MoveLeft aria-hidden="true" className="size-4" />} onClick={() => navigate('/workflow')} variant="outline">
                        Workflow
                    </Button>
                    <WorkflowActionButtons
                        onAction={requestWorkflowAction}
                        pendingAction={pendingAction?.reportId === report.id ? pendingAction.action : null}
                        report={report}
                        user={user}
                    />
                </div>
            }
            description={`${report.department} · ${report.week} · ${getEmployeeName(report)}`}
            eyebrow="Workflow"
            title={getReportTitle(report)}
        >
            <ReportSummaryCard
                title="Approval summary"
                items={[
                    { label: 'Status', value: <ReportStatusBadge label={report.status.label} status={report.status.value} /> },
                    { label: 'Department', value: report.department },
                    { label: 'Week', value: report.week },
                    { label: 'Author', value: getEmployeeName(report) },
                ]}
            />

            <div className="grid gap-6 xl:grid-cols-[minmax(0,1fr)_28rem]">
                <div className="grid gap-6">
                    <WorkflowStepperPanel report={report} />
                    <Card>
                        <CardHeader>
                            <CardTitle>Report content for approval</CardTitle>
                            <CardDescription>Read-only report data returned by the Reports API.</CardDescription>
                        </CardHeader>
                        <CardContent className="grid gap-4">
                            <ContentSection title="Executive summary" value={report.executive_summary} />
                            <ContentSection title="Objectives" value={report.objectives} />
                            <ContentSection title="Activities" value={report.activities} />
                            <ContentSection title="Achievements" value={report.achievements} />
                            <ContentSection title="Difficulties" value={report.difficulties} />
                            <ContentSection title="Next actions" value={report.next_actions} />
                        </CardContent>
                    </Card>
                </div>

                <aside className="grid content-start gap-6">
                    <WorkflowTimelinePanel report={report} />
                    <Card>
                        <CardHeader>
                            <CardTitle>Workflow metadata</CardTitle>
                            <CardDescription>Timestamps and responsible users exposed by the API.</CardDescription>
                        </CardHeader>
                        <CardContent>
                            <dl className="grid gap-3 text-sm">
                                <div className="rounded-xl bg-muted/60 p-3">
                                    <dt className="text-xs font-medium uppercase tracking-wide text-muted-foreground">Created</dt>
                                    <dd className="mt-1 font-medium text-foreground">{formatReportDate(report.created_at)}</dd>
                                </div>
                                <div className="rounded-xl bg-muted/60 p-3">
                                    <dt className="text-xs font-medium uppercase tracking-wide text-muted-foreground">Submitted</dt>
                                    <dd className="mt-1 font-medium text-foreground">{formatReportDate(report.submitted_at)}</dd>
                                </div>
                                <div className="rounded-xl bg-muted/60 p-3">
                                    <dt className="text-xs font-medium uppercase tracking-wide text-muted-foreground">Validated by</dt>
                                    <dd className="mt-1 font-medium text-foreground">{report.validator ?? 'Not available'}</dd>
                                </div>
                                <div className="rounded-xl bg-muted/60 p-3">
                                    <dt className="text-xs font-medium uppercase tracking-wide text-muted-foreground">Validated at</dt>
                                    <dd className="mt-1 font-medium text-foreground">{formatReportDate(report.validated_at)}</dd>
                                </div>
                                <div className="rounded-xl bg-muted/60 p-3">
                                    <dt className="text-xs font-medium uppercase tracking-wide text-muted-foreground">Generated</dt>
                                    <dd className="mt-1 font-medium text-foreground">{formatReportDate(report.generated_at)}</dd>
                                </div>
                                {report.rejected_at && (
                                    <div className="rounded-xl bg-danger/10 p-3 text-danger">
                                        <dt className="text-xs font-medium uppercase tracking-wide">Rejected by {report.rejector ?? 'Reviewer'}</dt>
                                        <dd className="mt-1 font-medium">{formatReportDate(report.rejected_at)}</dd>
                                        {report.rejection_reason && <dd className="mt-2 text-sm leading-relaxed">{report.rejection_reason}</dd>}
                                    </div>
                                )}
                            </dl>
                        </CardContent>
                    </Card>
                </aside>
            </div>

            <WorkflowConfirmDialog
                action={confirmAction?.action ?? null}
                isPending={isPending}
                onConfirm={() => {
                    if (!confirmAction) {
                        return;
                    }

                    void runWorkflowAction({
                        action: confirmAction.action,
                        onSuccess: () => setConfirmAction(null),
                        report: confirmAction.report,
                    });
                }}
                onOpenChange={(open) => {
                    if (!open && !isPending) {
                        setConfirmAction(null);
                    }
                }}
                open={Boolean(confirmAction)}
                report={confirmAction?.report ?? null}
            />

            <RejectionDialog
                isPending={isPending}
                onConfirm={(reason) => {
                    if (!rejectionReport) {
                        return;
                    }

                    void runWorkflowAction({
                        action: 'reject',
                        onSuccess: () => setRejectionReport(null),
                        reason,
                        report: rejectionReport,
                    });
                }}
                onOpenChange={(open) => {
                    if (!open && !isPending) {
                        setRejectionReport(null);
                    }
                }}
                open={Boolean(rejectionReport)}
                report={rejectionReport}
            />
        </PageContainer>
    );
}