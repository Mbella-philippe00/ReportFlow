import { FileText } from 'lucide-react';
import { useNavigate } from 'react-router-dom';

import { ReportStatusBadge } from '@/components/business/reports/ReportStatusBadge';
import { Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Pagination, Skeleton, Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui';
import { formatEmployeeDate } from '../utils/employee-utils';
import type { WeeklyReport } from '@/types';

export type EmployeeReportsPanelProps = {
    isLoading?: boolean;
    onPageChange?: (page: number) => void;
    page?: number;
    pageCount?: number;
    reports: readonly WeeklyReport[];
    title?: string;
};

export function EmployeeReportsPanel({ isLoading = false, onPageChange, page = 1, pageCount = 1, reports, title = 'Employee reports' }: EmployeeReportsPanelProps) {
    const navigate = useNavigate();

    return (
        <Card>
            <CardHeader>
                <CardTitle>{title}</CardTitle>
                <CardDescription>Weekly reports returned by the Employee Reports API endpoint.</CardDescription>
            </CardHeader>
            <CardContent className="grid gap-4">
                {isLoading ? (
                    <div className="grid gap-3">
                        <Skeleton className="h-12" />
                        <Skeleton className="h-12" />
                        <Skeleton className="h-12" />
                    </div>
                ) : reports.length === 0 ? (
                    <EmptyState description="This employee does not have reports returned by the API yet." icon={<FileText aria-hidden="true" className="size-10" />} title="No employee reports" />
                ) : (
                    <>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Week</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Department</TableHead>
                                    <TableHead>Updated</TableHead>
                                    <TableHead className="text-right">Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                {reports.map((report) => (
                                    <TableRow key={report.id}>
                                        <TableCell className="font-medium">{report.week}</TableCell>
                                        <TableCell><ReportStatusBadge label={report.status.label} status={report.status.value} /></TableCell>
                                        <TableCell>{report.department}</TableCell>
                                        <TableCell>{formatEmployeeDate(report.updated_at)}</TableCell>
                                        <TableCell className="text-right">
                                            <Button onClick={() => navigate(`/reports/${report.id}`)} size="sm" variant="outline">
                                                Open
                                            </Button>
                                        </TableCell>
                                    </TableRow>
                                ))}
                            </TableBody>
                        </Table>
                        {onPageChange && pageCount > 1 && <Pagination className="justify-center" onPageChange={onPageChange} page={page} pageCount={pageCount} />}
                    </>
                )}
            </CardContent>
        </Card>
    );
}