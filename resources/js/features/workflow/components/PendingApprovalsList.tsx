import { FileCheck2 } from 'lucide-react';

import { SectionHeader } from '@/components/business/common/SectionHeader';
import { ReportCard } from '@/components/business/reports/ReportCard';
import { EmptyState } from '@/components/ui';
import { getEmployeeName, getReportProgress } from '@/features/reports/utils/report-utils';
import type { AuthUser, ReportWorkflowAction, WeeklyReport } from '@/types';

import { WorkflowActionButtons } from './WorkflowActionButtons';

export type PendingApprovalsListProps = {
    description: string;
    emptyDescription: string;
    onAction: (action: ReportWorkflowAction, report: WeeklyReport) => void;
    onOpen: (report: WeeklyReport) => void;
    pendingAction?: ReportWorkflowAction | null;
    pendingReportId?: number | null;
    reports: readonly WeeklyReport[];
    title: string;
    user: AuthUser | null;
};

export function PendingApprovalsList({ description, emptyDescription, onAction, onOpen, pendingAction = null, pendingReportId = null, reports, title, user }: PendingApprovalsListProps) {
    return (
        <section className="grid gap-4">
            <SectionHeader description={description} title={title} />
            {reports.length === 0 ? (
                <EmptyState description={emptyDescription} icon={<FileCheck2 aria-hidden="true" className="size-10" />} title="Nothing pending" />
            ) : (
                <div className="grid gap-4 xl:grid-cols-2">
                    {reports.map((report) => (
                        <ReportCard
                            actions={
                                <WorkflowActionButtons
                                    onAction={onAction}
                                    pendingAction={pendingReportId === report.id ? pendingAction : null}
                                    report={report}
                                    user={user}
                                />
                            }
                            description={report.executive_summary ?? report.achievements}
                            key={report.id}
                            meta={[
                                { label: 'Department', value: report.department },
                                { label: 'Week', value: report.week },
                                { label: 'Employee', value: getEmployeeName(report) },
                            ]}
                            onSelect={() => onOpen(report)}
                            progress={getReportProgress(report.status.value)}
                            status={report.status.value}
                            subtitle={`${report.department} · ${report.week}`}
                            title={getEmployeeName(report)}
                        />
                    ))}
                </div>
            )}
        </section>
    );
}