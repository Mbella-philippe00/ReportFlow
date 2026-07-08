import { AlertCircle } from 'lucide-react';
import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { PageContainer } from '@/components/layout/PageContainer';
import { Alert, EmptyState } from '@/components/ui';
import { appConfig } from '@/config/app';
import { ReportForm } from '@/features/reports/components/ReportForm';
import { useCreateReportMutation } from '@/features/reports/hooks/useReports';
import { getReportFormDefaults, hasReportPermission } from '@/features/reports/utils/report-utils';
import { useToast } from '@/providers/ToastProvider';
import { useAuthStore } from '@/stores/auth.store';
import type { ReportPayload } from '@/types';

export function ReportCreatePage() {
    const navigate = useNavigate();
    const { notify } = useToast();
    const user = useAuthStore((state) => state.user);
    const createReportMutation = useCreateReportMutation();
    const canCreateReports = hasReportPermission(user, 'reports.create');
    const defaultValues = getReportFormDefaults(undefined, user?.employee?.id ?? null);

    useEffect(() => {
        document.title = `Create report - ${appConfig.name}`;
    }, []);

    const createReport = async (payload: ReportPayload) => {
        const response = await createReportMutation.mutateAsync(payload);
        notify({ intent: 'success', title: 'Report created' });
        navigate(`/reports/${response.data.id}`);
    };

    if (!canCreateReports) {
        return (
            <PageContainer description="You do not have permission to create weekly reports." eyebrow="Reports" title="Create report">
                <EmptyState description="Ask an administrator for reports.create permission." title="Create access required" />
            </PageContainer>
        );
    }

    return (
        <PageContainer description="Create a new weekly report using the existing Reports API." eyebrow="Reports" title="Create report">
            {!user?.employee?.id && (
                <Alert
                    description="The existing Reports API requires an employee ID. Enter a valid employee ID before submitting."
                    icon={<AlertCircle aria-hidden="true" className="size-5" />}
                    intent="warning"
                    title="Employee ID required"
                />
            )}
            <ReportForm defaultValues={defaultValues} onCancel={() => navigate('/reports')} onSubmit={createReport} submitLabel="Create report" />
        </PageContainer>
    );
}