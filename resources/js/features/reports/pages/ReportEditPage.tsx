import { AlertCircle, FileText } from 'lucide-react';
import { useNavigate, useParams } from 'react-router-dom';

import { PageContainer } from '@/components/layout/PageContainer';
import { AiReportActionPanel } from '@/features/ai/components';
import { Alert, EmptyState, Skeleton } from '@/components/ui';
import { useToast } from '@/providers/ToastProvider';
import { useAuthStore } from '@/stores/auth.store';

import { ReportForm } from '../components/ReportForm';
import { useReportQuery, useUpdateReportMutation } from '../hooks/useReports';
import { getEmployeeName, getReportCapabilities, getReportFormDefaults, getReportTitle, hasReportPermission } from '../utils/report-utils';

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'The report could not be saved.');

function ReportEditSkeleton() {
    return (
        <PageContainer description="Loading editable report data from the Reports API." eyebrow="Reports" title="Edit report">
            <div className="grid gap-6">
                <Skeleton className="h-16" />
                <Skeleton className="h-[42rem]" />
            </div>
        </PageContainer>
    );
}

export function ReportEditPage() {
    const navigate = useNavigate();
    const { id } = useParams();
    const reportId = Number(id);
    const user = useAuthStore((state) => state.user);
    const { notify } = useToast();
    const reportQuery = useReportQuery(Number.isFinite(reportId) ? reportId : 0);
    const updateReport = useUpdateReportMutation();

    if (!Number.isFinite(reportId) || reportId <= 0) {
        return (
            <PageContainer description="The requested report identifier is invalid." eyebrow="Reports" title="Edit report">
                <EmptyState action={{ label: 'Back to reports', onClick: () => navigate('/reports') }} icon={<FileText aria-hidden="true" className="size-10" />} title="Invalid report" description="Open an existing report from the reports list before editing." />
            </PageContainer>
        );
    }

    if (!hasReportPermission(user, 'reports.update')) {
        return (
            <PageContainer description="Your account does not currently expose report update permission." eyebrow="Reports" title="Edit report">
                <EmptyState action={{ label: 'Back to reports', onClick: () => navigate('/reports') }} icon={<AlertCircle aria-hidden="true" className="size-10" />} title="Permission required" description="Editing reports requires reports.update permission." />
            </PageContainer>
        );
    }

    if (reportQuery.isLoading) {
        return <ReportEditSkeleton />;
    }

    if (reportQuery.isError) {
        return (
            <PageContainer description="The Reports API returned an error." eyebrow="Reports" title="Edit report">
                <Alert intent="danger" title="Unable to load report" description={getErrorMessage(reportQuery.error)} />
                <EmptyState action={{ label: 'Back to reports', onClick: () => navigate('/reports') }} title="Report unavailable" description="Try again later or open another report from the list." />
            </PageContainer>
        );
    }

    const report = reportQuery.data?.data;

    if (!report) {
        return (
            <PageContainer description="No report was returned by the Reports API." eyebrow="Reports" title="Edit report">
                <EmptyState action={{ label: 'Back to reports', onClick: () => navigate('/reports') }} icon={<FileText aria-hidden="true" className="size-10" />} title="Report not found" description="The report may have been deleted or is no longer available." />
            </PageContainer>
        );
    }

    const capabilities = getReportCapabilities(report, user);

    if (!capabilities.canEdit) {
        return (
            <PageContainer description={`${report.department} · ${report.week} · ${getEmployeeName(report)}`} eyebrow="Reports" title="Editing unavailable">
                <Alert intent="warning" title="Workflow prevents editing" description="The backend workflow only allows editing while a report is draft or rejected." />
                <EmptyState action={{ label: 'View report', onClick: () => navigate(`/reports/${report.id}`) }} title="Report cannot be edited" description="Use the available workflow actions on the report details page." />
            </PageContainer>
        );
    }

    return (
        <PageContainer description={`${report.department} · ${report.week} · ${getEmployeeName(report)}`} eyebrow="Reports" title={`Edit ${getReportTitle(report)}`}>
            <div className="grid gap-6">
                <ReportForm
                    defaultValues={getReportFormDefaults(report)}
                    disabled={updateReport.isPending}
                    onCancel={() => navigate(`/reports/${report.id}`)}
                    onSubmit={async (payload) => {
                        await updateReport.mutateAsync({ id: report.id, payload });
                        notify({ intent: 'success', title: 'Report updated', description: 'The report was saved successfully.' });
                        navigate(`/reports/${report.id}`);
                    }}
                    submitLabel="Save report"
                />
                <AiReportActionPanel
                    report={report}
                    title="AI Report Assistant"
                    description="Generate suggestions while editing. Apply any useful result manually before saving the report."
                />
            </div>
        </PageContainer>
    );
}