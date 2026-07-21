import { http } from '@/lib/http';
import type {
    AdministrationAuditEvent,
    AdministrationOverview,
    ApiMessageResponse,
    ApiSuccessResponse,
    CompanySetting,
    CompanySettingPayload,
    EnterpriseAiSetting,
    EnterpriseAiSettingPayload,
    EnterpriseDepartment,
    EnterpriseDepartmentPayload,
    EnterpriseNotificationSetting,
    EnterpriseNotificationSettingPayload,
    EnterprisePosition,
    EnterprisePositionPayload,
    EnterpriseTeam,
    EnterpriseTeamPayload,
    FeatureFlag,
    FeatureFlagPayload,
    ReportingCalendar,
    ReportingCalendarPayload,
    WorkflowConfiguration,
    WorkflowConfigurationPayload,
} from '@/types';

export type AdministrationRequestOptions = {
    signal?: AbortSignal;
};

export type AdministrationAuditPage = {
    current_page: number;
    data: AdministrationAuditEvent[];
    first_page_url: string | null;
    from: number | null;
    last_page: number;
    last_page_url: string | null;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
};

export const administrationQueryKeys = {
    all: ['administration'] as const,
    audit: () => ['administration', 'audit'] as const,
    overview: () => ['administration', 'overview'] as const,
};

export const getAdministrationOverview = ({ signal }: AdministrationRequestOptions = {}) =>
    http<ApiSuccessResponse<AdministrationOverview>>('/admin/overview', { signal });

export const getAdministrationAudit = ({ signal }: AdministrationRequestOptions = {}) =>
    http<ApiSuccessResponse<AdministrationAuditPage>>('/admin/audit', { signal });

export const updateCompanySettings = (settings: CompanySettingPayload[]) =>
    http<ApiSuccessResponse<CompanySetting[]>>('/admin/company-settings', {
        body: { settings },
        method: 'PUT',
    });

export const createDepartment = (payload: EnterpriseDepartmentPayload) =>
    http<ApiSuccessResponse<EnterpriseDepartment>>('/admin/departments', {
        body: payload,
        method: 'POST',
    });

export const updateDepartment = ({ id, payload }: { id: number; payload: EnterpriseDepartmentPayload }) =>
    http<ApiSuccessResponse<EnterpriseDepartment>>('/admin/departments/' + id, {
        body: payload,
        method: 'PUT',
    });

export const deleteDepartment = (id: number) => http<ApiMessageResponse>('/admin/departments/' + id, { method: 'DELETE' });

export const createTeam = (payload: EnterpriseTeamPayload) =>
    http<ApiSuccessResponse<EnterpriseTeam>>('/admin/teams', {
        body: payload,
        method: 'POST',
    });

export const updateTeam = ({ id, payload }: { id: number; payload: EnterpriseTeamPayload }) =>
    http<ApiSuccessResponse<EnterpriseTeam>>('/admin/teams/' + id, {
        body: payload,
        method: 'PUT',
    });

export const deleteTeam = (id: number) => http<ApiMessageResponse>('/admin/teams/' + id, { method: 'DELETE' });

export const createPosition = (payload: EnterprisePositionPayload) =>
    http<ApiSuccessResponse<EnterprisePosition>>('/admin/positions', {
        body: payload,
        method: 'POST',
    });

export const updatePosition = ({ id, payload }: { id: number; payload: EnterprisePositionPayload }) =>
    http<ApiSuccessResponse<EnterprisePosition>>('/admin/positions/' + id, {
        body: payload,
        method: 'PUT',
    });

export const deletePosition = (id: number) => http<ApiMessageResponse>('/admin/positions/' + id, { method: 'DELETE' });

export const createReportingCalendar = (payload: ReportingCalendarPayload) =>
    http<ApiSuccessResponse<ReportingCalendar>>('/admin/reporting-calendars', {
        body: payload,
        method: 'POST',
    });

export const updateReportingCalendar = ({ id, payload }: { id: number; payload: ReportingCalendarPayload }) =>
    http<ApiSuccessResponse<ReportingCalendar>>('/admin/reporting-calendars/' + id, {
        body: payload,
        method: 'PUT',
    });

export const deleteReportingCalendar = (id: number) => http<ApiMessageResponse>('/admin/reporting-calendars/' + id, { method: 'DELETE' });

export const createWorkflowConfiguration = (payload: WorkflowConfigurationPayload) =>
    http<ApiSuccessResponse<WorkflowConfiguration>>('/admin/workflow-configurations', {
        body: payload,
        method: 'POST',
    });

export const updateWorkflowConfiguration = ({ id, payload }: { id: number; payload: WorkflowConfigurationPayload }) =>
    http<ApiSuccessResponse<WorkflowConfiguration>>('/admin/workflow-configurations/' + id, {
        body: payload,
        method: 'PUT',
    });

export const saveNotificationSetting = (payload: EnterpriseNotificationSettingPayload) =>
    http<ApiSuccessResponse<EnterpriseNotificationSetting>>('/admin/notification-settings', {
        body: payload,
        method: 'PUT',
    });

export const saveAiSetting = (payload: EnterpriseAiSettingPayload) =>
    http<ApiSuccessResponse<EnterpriseAiSetting>>('/admin/ai-settings', {
        body: payload,
        method: 'PUT',
    });

export const saveFeatureFlag = (payload: FeatureFlagPayload) =>
    http<ApiSuccessResponse<FeatureFlag>>('/admin/feature-flags', {
        body: payload,
        method: 'PUT',
    });
