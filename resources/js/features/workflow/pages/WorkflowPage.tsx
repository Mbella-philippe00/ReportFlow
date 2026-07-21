import { AlertCircle, CheckCircle2, Clock3, FileCheck2, GitPullRequest, XCircle } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business/common/NoPermission';
import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Skeleton } from '@/components/ui';
import { useAuthStore } from '@/stores/auth.store';
import type { ReportWorkflowAction, WeeklyReport } from '@/types';

import { PendingApprovalsList } from '../components/PendingApprovalsList';
import { RejectionDialog } from '../components/RejectionDialog';
import { WorkflowConfirmDialog } from '../components/WorkflowConfirmDialog';
import { WorkflowHistory } from '../components/WorkflowHistory';
import { useWorkflowActionRunner } from '../hooks/useWorkflowActionRunner';
import { useWorkflowQueueQuery } from '../hooks/useWorkflow';
import { getWorkflowCapabilities, hasAnyWorkflowPermission, isPendingApprovalStatus } from '../utils/workflow-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'Workflow data could not be loaded.');

type ConfirmActionState = {
    action: Exclude<ReportWorkflowAction, 'reject'>;
    report: WeeklyReport;
};

function WorkflowPageSkeleton() {
    return (
        <PageContainer description="Loading your workflow queue from the backend." eyebrow="Workflow" title="Workflow">
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
    const [confirmAction, setConfirmAction] = useState<ConfirmActionState | null>(null);
    const [rejectionReport, setRejectionReport] = useState<WeeklyReport | null>(null);
    const queueQuery = useWorkflowQueueQuery();
    const { isPending, pendingAction, runWorkflowAction } = useWorkflowActionRunner();

    useEffect(() => {
        document.title = 'Workflow - ReportFlow';
    }, []);

    const reports = queueQuery.data?.data ?? [];

    const pendingApprovals = useMemo(() => reports.filter((report) => isPendingApprovalStatus(report.status.value)), [reports]);
    const myPendingActions = useMemo(
        () => reports.filter((report) => getWorkflowCapabilities(report, user).allowedActions.length > 0),
        [reports, user],
    );
    const rejectedReports = useMemo(() => reports.filter((report) => report.status.value === 'rejected'), [reports]);
    const approvedReports = useMemo(() => reports.filter((report) => report.status.value === 'approved'), [reports]);

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
                    description="Your account does not expose submit, review, approve, or reject workflow permissions."
                    title="Workflow access restricted"
                />
            </PageContainer>
        );
    }

    if (queueQuery.isLoading) {
        return <WorkflowPageSkeleton />;
    }

    if (queueQuery.isError) {
        return (
            <PageContainer description="The Workflow Queue API could not provide workflow data." eyebrow="Workflow" title="Workflow">
                <Alert intent="danger" icon={<AlertCircle aria-hidden="true" className="size-5" />} title="Unable to load workflow" description={getErrorMessage(queueQuery.error)} />
            </PageContainer>
        );
    }

    return (
        <PageContainer description="Review reports moving through Draft, Submitted, Under Review, Approved, and Rejected." eyebrow="Workflow" title="Workflow">
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <MetricCard description="Submitted or under-review reports in your backend queue." icon={Clock3} title="Pending workflow" value={pendingApprovals.length} />
                <MetricCard description="Reports where your current permissions expose at least one action." icon={GitPullRequest} title="My pending actions" value={myPendingActions.length} />
                <MetricCard description="Reports that reached final approval and are read-only." icon={CheckCircle2} title="Approved" value={approvedReports.length} />
                <MetricCard description="Reports returned to their author for correction." icon={XCircle} title="Rejected" value={rejectedReports.length} />
            </div>

            {reports.length === 0 ? (
                <EmptyState
                    description="Your workflow queue is empty. Submitted reports will appear here when they need your attention."
                    icon={<FileCheck2 aria-hidden="true" className="size-10" />}
                    title="No workflow reports"
                />
            ) : (
                <>
                    <PendingApprovalsList
                        description="Reports currently waiting for manager review, final approval, or rejection."
                        emptyDescription="There are no submitted or under-review reports in your queue."
                        onAction={requestWorkflowAction}
                        onOpen={openApproval}
                        pendingAction={pendingButtonAction}
                        pendingReportId={pendingReportId}
                        reports={pendingApprovals}
                        title="Manager queue"
                        user={user}
                    />

                    <PendingApprovalsList
                        description="Reports where your current permissions and backend state allow an action."
                        emptyDescription="No reports currently require your action."
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

            <WorkflowConfirmDialog
                action={confirmAction?.action ?? null}
                isPending={isPending}
                onConfirm={(comment) => {
                    if (!confirmAction) {
                        return;
                    }

                    void runWorkflowAction({
                        action: confirmAction.action,
                        comment,
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
