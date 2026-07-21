import { lazy, Suspense, useEffect } from 'react';
import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';

import { AppLayout } from '@/components/layout/AppLayout';
import { GuestLayout } from '@/components/layout/GuestLayout';
import { PageContainer } from '@/components/layout/PageContainer';
import { appConfig } from '@/config/app';
import { GuestRoute } from '@/routes/GuestRoute';
import { ProtectedRoute } from '@/routes/ProtectedRoute';

const ActionItemsPage = lazy(() => import('@/features/ai/pages/ActionItemsPage').then((module) => ({ default: module.ActionItemsPage })));
const AdministrationCenterPage = lazy(() => import('@/features/administration/pages/AdministrationCenterPage').then((module) => ({ default: module.AdministrationCenterPage })));
const ActivityAnalyticsPage = lazy(() => import('@/features/analytics/pages/ActivityAnalyticsPage').then((module) => ({ default: module.ActivityAnalyticsPage })));
const AiAssistantPage = lazy(() => import('@/features/ai/pages/AiAssistantPage').then((module) => ({ default: module.AiAssistantPage })));
const AiDashboardPage = lazy(() => import('@/features/ai/pages/AiDashboardPage').then((module) => ({ default: module.AiDashboardPage })));
const AiHistoryPage = lazy(() => import('@/features/ai/pages/AiHistoryPage').then((module) => ({ default: module.AiHistoryPage })));
const AnalyticsDashboardPage = lazy(() => import('@/features/analytics/pages/AnalyticsDashboardPage').then((module) => ({ default: module.AnalyticsDashboardPage })));
const DashboardPage = lazy(() => import('@/features/dashboard/DashboardPage').then((module) => ({ default: module.DashboardPage })));
const DepartmentAnalyticsPage = lazy(() => import('@/features/analytics/pages/DepartmentAnalyticsPage').then((module) => ({ default: module.DepartmentAnalyticsPage })));
const EmployeeActivityPage = lazy(() => import('@/features/employees/pages/EmployeeActivityPage').then((module) => ({ default: module.EmployeeActivityPage })));
const EmployeeAnalyticsPage = lazy(() => import('@/features/analytics/pages/EmployeeAnalyticsPage').then((module) => ({ default: module.EmployeeAnalyticsPage })));
const EmployeeDetailsPage = lazy(() => import('@/features/employees/pages/EmployeeDetailsPage').then((module) => ({ default: module.EmployeeDetailsPage })));
const EmployeeProfilePage = lazy(() => import('@/features/employees/pages/EmployeeProfilePage').then((module) => ({ default: module.EmployeeProfilePage })));
const EmployeesListPage = lazy(() => import('@/features/employees/pages/EmployeesListPage').then((module) => ({ default: module.EmployeesListPage })));
const ExecutiveAnalyticsPage = lazy(() => import('@/features/analytics/pages/ExecutiveAnalyticsPage').then((module) => ({ default: module.ExecutiveAnalyticsPage })));
const ExecutiveSummaryPage = lazy(() => import('@/features/ai/pages/ExecutiveSummaryPage').then((module) => ({ default: module.ExecutiveSummaryPage })));
const GrammarTonePage = lazy(() => import('@/features/ai/pages/GrammarTonePage').then((module) => ({ default: module.GrammarTonePage })));
const LoginPage = lazy(() => import('@/features/auth/pages/LoginPage').then((module) => ({ default: module.LoginPage })));
const MissingInformationPage = lazy(() => import('@/features/ai/pages/MissingInformationPage').then((module) => ({ default: module.MissingInformationPage })));
const NotificationDetailsPage = lazy(() => import('@/features/notifications/pages/NotificationDetailsPage').then((module) => ({ default: module.NotificationDetailsPage })));
const NotificationsPage = lazy(() => import('@/features/notifications/pages/NotificationsPage').then((module) => ({ default: module.NotificationsPage })));
const QualityScorePage = lazy(() => import('@/features/ai/pages/QualityScorePage').then((module) => ({ default: module.QualityScorePage })));
const RegisterPage = lazy(() => import('@/features/auth/pages/RegisterPage').then((module) => ({ default: module.RegisterPage })));
const ReportCreatePage = lazy(() => import('@/features/reports/pages/ReportCreatePage').then((module) => ({ default: module.ReportCreatePage })));
const ReportDetailPage = lazy(() => import('@/features/reports/pages/ReportDetailPage').then((module) => ({ default: module.ReportDetailPage })));
const ReportEditPage = lazy(() => import('@/features/reports/pages/ReportEditPage').then((module) => ({ default: module.ReportEditPage })));
const ReportsAnalyticsPage = lazy(() => import('@/features/analytics/pages/ReportsAnalyticsPage').then((module) => ({ default: module.ReportsAnalyticsPage })));
const ReportsListPage = lazy(() => import('@/features/reports/pages/ReportsListPage').then((module) => ({ default: module.ReportsListPage })));
const RiskAnalysisPage = lazy(() => import('@/features/ai/pages/RiskAnalysisPage').then((module) => ({ default: module.RiskAnalysisPage })));
const WorkflowAnalyticsPage = lazy(() => import('@/features/analytics/pages/WorkflowAnalyticsPage').then((module) => ({ default: module.WorkflowAnalyticsPage })));
const WorkflowApprovalPage = lazy(() => import('@/features/workflow/pages/WorkflowApprovalPage').then((module) => ({ default: module.WorkflowApprovalPage })));
const WorkflowPage = lazy(() => import('@/features/workflow/pages/WorkflowPage').then((module) => ({ default: module.WorkflowPage })));
const WorkflowRecommendationPage = lazy(() => import('@/features/ai/pages/WorkflowRecommendationPage').then((module) => ({ default: module.WorkflowRecommendationPage })));
const WritingImprovementPage = lazy(() => import('@/features/ai/pages/WritingImprovementPage').then((module) => ({ default: module.WritingImprovementPage })));

type RoutePlaceholderProps = {
    description: string;
    eyebrow?: string;
    title: string;
    variant?: 'app' | 'guest';
};

function RouteLoadingFallback() {
    return (
        <div className="flex min-h-[320px] items-center justify-center px-6 py-16">
            <div className="h-24 w-full max-w-3xl animate-pulse rounded-3xl border bg-surface/80 shadow-sm" aria-label="Loading page" />
        </div>
    );
}

function RoutePlaceholder({ description, eyebrow = 'ReportFlow Foundation', title, variant = 'app' }: RoutePlaceholderProps) {
    useEffect(() => {
        document.title = title + ' - ' + appConfig.name;
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
            <Suspense fallback={<RouteLoadingFallback />}>
                <Routes>
                    <Route element={<GuestRoute />}>
                        <Route element={<GuestLayout />}>
                            <Route element={<LoginPage />} path="/login" />
                            <Route element={<RegisterPage />} path="/register" />
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
                            <Route element={<NotificationsPage />} path="/notifications" />
                            <Route element={<NotificationDetailsPage />} path="/notifications/:id" />
                            <Route element={<EmployeesListPage />} path="/employees" />
                            <Route element={<EmployeeDetailsPage />} path="/employees/:id" />
                            <Route element={<EmployeeProfilePage />} path="/employees/:id/profile" />
                            <Route element={<EmployeeActivityPage />} path="/employees/:id/activity" />
                            <Route element={<AnalyticsDashboardPage />} path="/analytics" />
                            <Route element={<ExecutiveAnalyticsPage />} path="/analytics/executive" />
                            <Route element={<ReportsAnalyticsPage />} path="/analytics/reports" />
                            <Route element={<EmployeeAnalyticsPage />} path="/analytics/employees" />
                            <Route element={<DepartmentAnalyticsPage />} path="/analytics/departments" />
                            <Route element={<WorkflowAnalyticsPage />} path="/analytics/workflow" />
                            <Route element={<ActivityAnalyticsPage />} path="/analytics/activity" />
                            <Route element={<AiDashboardPage />} path="/ai" />
                            <Route element={<AiDashboardPage />} path="/ai/dashboard" />
                            <Route element={<AiAssistantPage />} path="/ai/assistant" />
                            <Route element={<ExecutiveSummaryPage />} path="/ai/executive-summary" />
                            <Route element={<WritingImprovementPage />} path="/ai/writing-improvement" />
                            <Route element={<GrammarTonePage />} path="/ai/grammar-tone" />
                            <Route element={<ActionItemsPage />} path="/ai/action-items" />
                            <Route element={<RiskAnalysisPage />} path="/ai/risk-analysis" />
                            <Route element={<MissingInformationPage />} path="/ai/missing-information" />
                            <Route element={<QualityScorePage />} path="/ai/quality-score" />
                            <Route element={<WorkflowRecommendationPage />} path="/ai/workflow-recommendation" />
                            <Route element={<AiHistoryPage />} path="/ai/history" />
                            <Route element={<AdministrationCenterPage />} path="/settings" />
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
            </Suspense>
        </BrowserRouter>
    );
}
