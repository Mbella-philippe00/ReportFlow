import { AlertCircle, CheckCircle2, Clock3, FileCheck2, GitPullRequest, XCircle } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business/common/NoPermission';
import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Pagination, Skeleton } from '@/components/ui';
import { useReportsQuery } from '@/features/reports/hooks/useReports';
import { useAuthStore } from '@/stores/auth.store';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';

import { PendingApprovalsList } from '../components/PendingApprovalsList';
import { RejectionDialog } from '../components/RejectionDialog';
import { WorkflowConfirmDialog } from '../components/WorkflowConfirmDialog';
import { WorkflowHistory } from '../components/WorkflowHistory';
import { useWorkflowActionRunner } from '../hooks/useWorkflowActionRunner';
import { getWorkflowCapabilities, hasAnyWorkflowPermission, isPendingApprovalStatus } from '../utils/workflow-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'Workflow data could not be loaded.');

type ConfirmActionState = {
    action: Exclude<ReportWorkflowAction, 'reject'>;
    report: WeeklyReport;
};

function WorkflowPageSkeleton() {
    return (
        <PageContainer description="Loading workflow reports from the backend." eyebrow="Workflow" title="Workflow">
            <div className="grid gap-4 md:grid-cols-4">
                <Skeleton className="h-32" />
                <Skeleton className="h-32" />
                <Skeleton className="h-32" />
                <Skeleton className="h-32" />
            </div>
            <Skeleton className="h-96" />
            <Skeleton className="h-80" />
        </PageContainer>
    );
}

function MetricCard({ description, icon: Icon, title, value }: { description: string; icon: typeof Clock3; title: string; value: number }) {
    return (
        <Card>
            <CardHeader className="flex-row items-start justify-between gap-3">
                <div>
                    <CardDescription>{title}</CardDescription>
                    <CardTitle className="mt-2 text-3xl">{value}</CardTitle>
                </div>
                <span className="rounded-2xl bg-primary/10 p-3 text-primary">
                    <Icon aria-hidden="true" className="size-5" />
                </span>
            </CardHeader>
            <CardContent>
                <p className="text-sm text-muted-foreground">{description}</p>
            </CardContent>
        </Card>
    );
}

export function WorkflowPage() {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);
    const [page, setPage] = useState(1);
    const [confirmAction, setConfirmAction] = useState<ConfirmActionState | null>(null);
    const [rejectionReport, setRejectionReport] = useState<WeeklyReport | null>(null);
    const reportsQuery = useReportsQuery({ page });
    const { isPending, pendingAction, runWorkflowAction } = useWorkflowActionRunner();

    useEffect(() => {
        document.title = 'Workflow - ReportFlow';
    }, []);

    const reports = reportsQuery.data?.data ?? [];
    const meta = reportsQuery.data?.meta;

    const pendingApprovals = useMemo(() => reports.filter((report) => isPendingApprovalStatus(report.status.value)), [reports]);
    const myPendingActions = useMemo(
        () => reports.filter((report) => getWorkflowCapabilities(report, user).allowedActions.length > 0),
        [reports, user],
    );
    const rejectedReports = useMemo(() => reports.filter((report) => report.status.value === 'rejected'), [reports]);
    const completedReports = useMemo(() => reports.filter((report) => report.status.value === 'generated'), [reports]);

    const openApproval = (report: WeeklyReport) => navigate(`/workflow/approvals/${report.id}`);

    const requestWorkflowAction = (action: ReportWorkflowAction, report: WeeklyReport) => {
        if (action === 'reject') {
            setRejectionReport(report);
            return;
        }

        setConfirmAction({ action, report });
    };

    const pendingButtonAction = pendingAction?.action ?? null;
    const pendingReportId = pendingAction?.reportId ?? null;

    if (!hasAnyWorkflowPermission(user)) {
        return (
            <PageContainer description="Workflow actions require report workflow permissions." eyebrow="Workflow" title="Workflow">
                <NoPermission
                    action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }}
                    description="Your account does not expose submit, approve, final-approve, or reject workflow permissions."
                    title="Workflow access restricted"
                />
            </PageContainer>
        );
    }

    if (reportsQuery.isLoading) {
        return <WorkflowPageSkeleton />;
    }

    if (reportsQuery.isError) {
        return (
            <PageContainer description="The Reports API could not provide workflow data." eyebrow="Workflow" title="Workflow">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load workflow" description={getErrorMessage(reportsQuery.error)} />
            </PageContainer>
        );
    }

    return (
        <PageContainer description="Review reports moving through submission, manager approval, final approval, and rejection." eyebrow="Workflow" title="Workflow">
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <MetricCard description="Submitted or manager-approved reports on this API page." icon={Clock3} title="Pending approvals" value={pendingApprovals.length} />
                <MetricCard description="Reports where your permissions expose at least one action." icon={GitPullRequest} title="My pending actions" value={myPendingActions.length} />
                <MetricCard description="Reports that reached final approval and generation." icon={CheckCircle2} title="Final approved" value={completedReports.length} />
                <MetricCard description="Reports returned to their author for correction." icon={XCircle} title="Rejected" value={rejectedReports.length} />
            </div>

            {reports.length === 0 ? (
                <EmptyState
                    description="The Reports API did not return any reports for this page. Workflow queues will populate when reports are created and submitted."
                    icon={<FileCheck2 aria-hidden="true" className="size-10" />}
                    title="No workflow reports"
                />
            ) : (
                <>
                    <PendingApprovalsList
                        description="Reports currently waiting for manager approval, final approval, or rejection."
                        emptyDescription="There are no submitted or manager-approved reports on this API page."
                        onAction={requestWorkflowAction}
                        onOpen={openApproval}
                        pendingAction={pendingButtonAction}
                        pendingReportId={pendingReportId}
                        reports={pendingApprovals}
                        title="Pending approvals list"
                        user={user}
                    />

                    <PendingApprovalsList
                        description="Reports where your current permissions and backend state allow an action."
                        emptyDescription="No reports on this API page currently require your action."
                        onAction={requestWorkflowAction}
                        onOpen={openApproval}
                        pendingAction={pendingButtonAction}
                        pendingReportId={pendingReportId}
                        reports={myPendingActions}
                        title="My pending actions"
                        user={user}
                    />

                    <WorkflowHistory onOpen={openApproval} reports={reports} />
                </>
            )}

            {meta && meta.last_page > 1 && (
                <Pagination className="justify-center" onPageChange={setPage} page={meta.current_page} pageCount={meta.last_page} />
            )}

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