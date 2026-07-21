import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';

import { analyticsQueryKeys } from '@/services/analytics.service';
import {
    administrationQueryKeys,
    createDepartment,
    createPosition,
    createReportingCalendar,
    createTeam,
    createWorkflowConfiguration,
    deleteDepartment,
    deletePosition,
    deleteReportingCalendar,
    deleteTeam,
    getAdministrationAudit,
    getAdministrationOverview,
    saveAiSetting,
    saveFeatureFlag,
    saveNotificationSetting,
    updateCompanySettings,
    updateDepartment,
    updatePosition,
    updateReportingCalendar,
    updateTeam,
    updateWorkflowConfiguration,
} from '@/services/administration.service';
import { dashboardQueryKeys } from '@/services/dashboard.service';

const administrationStaleTime = 60_000;

const useAdministrationInvalidation = () => {
    const queryClient = useQueryClient();

    return () => {
        void queryClient.invalidateQueries({ queryKey: administrationQueryKeys.all });
        void queryClient.invalidateQueries({ queryKey: dashboardQueryKeys.detail() });
        void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });
    };
};

export const useAdministrationOverviewQuery = () =>
    useQuery({
        queryFn: ({ signal }) => getAdministrationOverview({ signal }),
        queryKey: administrationQueryKeys.overview(),
        staleTime: administrationStaleTime,
    });

export const useAdministrationAuditQuery = () =>
    useQuery({
        queryFn: ({ signal }) => getAdministrationAudit({ signal }),
        queryKey: administrationQueryKeys.audit(),
        staleTime: administrationStaleTime,
    });

export const useUpdateCompanySettingsMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({
        mutationFn: updateCompanySettings,
        onSuccess: invalidate,
    });
};

export const useCreateDepartmentMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: createDepartment, onSuccess: invalidate });
};

export const useUpdateDepartmentMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: updateDepartment, onSuccess: invalidate });
};

export const useDeleteDepartmentMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: deleteDepartment, onSuccess: invalidate });
};

export const useCreateTeamMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: createTeam, onSuccess: invalidate });
};

export const useUpdateTeamMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: updateTeam, onSuccess: invalidate });
};

export const useDeleteTeamMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: deleteTeam, onSuccess: invalidate });
};

export const useCreatePositionMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: createPosition, onSuccess: invalidate });
};

export const useUpdatePositionMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: updatePosition, onSuccess: invalidate });
};

export const useDeletePositionMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: deletePosition, onSuccess: invalidate });
};

export const useCreateReportingCalendarMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: createReportingCalendar, onSuccess: invalidate });
};

export const useUpdateReportingCalendarMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: updateReportingCalendar, onSuccess: invalidate });
};

export const useDeleteReportingCalendarMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: deleteReportingCalendar, onSuccess: invalidate });
};

export const useCreateWorkflowConfigurationMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: createWorkflowConfiguration, onSuccess: invalidate });
};

export const useUpdateWorkflowConfigurationMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: updateWorkflowConfiguration, onSuccess: invalidate });
};

export const useSaveNotificationSettingMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: saveNotificationSetting, onSuccess: invalidate });
};

export const useSaveAiSettingMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: saveAiSetting, onSuccess: invalidate });
};

export const useSaveFeatureFlagMutation = () => {
    const invalidate = useAdministrationInvalidation();

    return useMutation({ mutationFn: saveFeatureFlag, onSuccess: invalidate });
};
