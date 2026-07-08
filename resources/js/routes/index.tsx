import { useEffect } from 'react';
import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';

import { AppLayout } from '@/components/layout/AppLayout';
import { GuestLayout } from '@/components/layout/GuestLayout';
import { PageContainer } from '@/components/layout/PageContainer';
import { appConfig } from '@/config/app';
import { DashboardPage } from '@/features/dashboard';
import { EmployeeActivityPage, EmployeeDetailsPage, EmployeeProfilePage, EmployeesListPage } from '@/features/employees';
import { ReportCreatePage, ReportDetailPage, ReportEditPage, ReportsListPage } from '@/features/reports';
import { WorkflowApprovalPage, WorkflowPage } from '@/features/workflow';
import { GuestRoute } from '@/routes/GuestRoute';
import { ProtectedRoute } from '@/routes/ProtectedRoute';

type RoutePlaceholderProps = {
    description: string;
    eyebrow?: string;
    title: string;
    variant?: 'app' | 'guest';
};

function RoutePlaceholder({ description, eyebrow = 'ReportFlow Foundation', title, variant = 'app' }: RoutePlaceholderProps) {
    useEffect(() => {
        document.title = `${title} - ${appConfig.name}`;
    }, [title]);

    if (variant === 'guest') {
        return (
            <div>
                <p className="text-sm font-medium uppercase tracking-wide text-primary">{eyebrow}</p>
                <h1 className="mt-3 text-2xl font-semibold text-surface-foreground">{title}</h1>
                <p className="mt-3 text-sm leading-6 text-muted-foreground">{description}</p>
            </div>
        );
    }

    return (
        <PageContainer description={description} eyebrow={eyebrow} title={title}>
            <div className="rounded-2xl border border-dashed bg-surface p-6 text-sm text-muted-foreground">
                Feature-specific content will be injected into this shell in later phases.
            </div>
        </PageContainer>
    );
}

export function AppRouter() {
    return (
        <BrowserRouter basename={appConfig.routerBasename}>
            <Routes>
                <Route element={<GuestRoute />}>
                    <Route element={<GuestLayout />}>
                        <Route
                            element={
                                <RoutePlaceholder
                                    description="Authentication UI is intentionally deferred beyond the technical foundation phase."
                                    title="Sign in"
                                    variant="guest"
                                />
                            }
                            path="/login"
                        />
                    </Route>
                </Route>

                <Route element={<ProtectedRoute />}>
                    <Route element={<AppLayout />}>
                        <Route element={<DashboardPage />} path="/dashboard" />
                        <Route element={<ReportsListPage />} path="/reports" />
                        <Route element={<ReportCreatePage />} path="/reports/create" />
                        <Route element={<ReportDetailPage />} path="/reports/:id" />
                        <Route element={<ReportEditPage />} path="/reports/:id/edit" />
                        <Route element={<WorkflowPage />} path="/workflow" />
                        <Route element={<WorkflowApprovalPage />} path="/workflow/approvals/:id" />
                        <Route
                            element={
                                <RoutePlaceholder
                                    description="Notification navigation is wired. Notification features are intentionally deferred."
                                    title="Notifications"
                                />
                            }
                            path="/notifications"
                        />
                        <Route element={<EmployeesListPage />} path="/employees" />
                        <Route element={<EmployeeDetailsPage />} path="/employees/:id" />
                        <Route element={<EmployeeProfilePage />} path="/employees/:id/profile" />
                        <Route element={<EmployeeActivityPage />} path="/employees/:id/activity" />
                        <Route
                            element={
                                <RoutePlaceholder
                                    description="Analytics navigation is wired. Analytics screens are intentionally deferred."
                                    title="Analytics"
                                />
                            }
                            path="/analytics"
                        />
                        <Route
                            element={
                                <RoutePlaceholder
                                    description="AI navigation is wired. AI experiences are intentionally deferred."
                                    title="AI"
                                />
                            }
                            path="/ai"
                        />
                        <Route
                            element={
                                <RoutePlaceholder
                                    description="Settings navigation is wired. Settings screens are intentionally deferred."
                                    title="Settings"
                                />
                            }
                            path="/settings"
                        />
                        <Route
                            element={
                                <RoutePlaceholder
                                    description="Profile navigation is wired. Profile screens are intentionally deferred."
                                    title="Profile"
                                />
                            }
                            path="/profile"
                        />
                    </Route>
                </Route>

                <Route path="/" element={<Navigate replace to="/dashboard" />} />
                <Route
                    element={
                        <RoutePlaceholder
                            description="The requested route does not exist in the current frontend foundation."
                            title="Not found"
                            variant="guest"
                        />
                    }
                    path="*"
                />
            </Routes>
        </BrowserRouter>
    );
}