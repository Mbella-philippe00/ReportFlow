export type AdminJson = Record<string, unknown>;

export type AdminUserSummary = {
    email: string;
    id: number;
    name: string;
};

export type CompanySetting = {
    created_at: string;
    group: string;
    id: number;
    is_public: boolean;
    key: string;
    label: string;
    type: 'boolean' | 'email' | 'json' | 'number' | 'text' | 'url' | string;
    updated_at: string;
    value: { value: unknown } | null;
};

export type CompanySettingPayload = Pick<CompanySetting, 'group' | 'is_public' | 'key' | 'label' | 'type'> & {
    value: unknown;
};

export type EnterpriseDepartment = {
    active: boolean;
    code: string;
    created_at: string;
    description: string | null;
    id: number;
    manager?: AdminUserSummary | null;
    manager_id: number | null;
    metadata: AdminJson | null;
    name: string;
    positions?: EnterprisePosition[];
    teams?: EnterpriseTeam[];
    updated_at: string;
};

export type EnterpriseDepartmentPayload = Pick<EnterpriseDepartment, 'active' | 'code' | 'description' | 'manager_id' | 'metadata' | 'name'>;

export type EnterpriseTeam = {
    active: boolean;
    code: string;
    created_at: string;
    department?: EnterpriseDepartment | null;
    department_id: number;
    description: string | null;
    id: number;
    lead?: AdminUserSummary | null;
    lead_id: number | null;
    metadata: AdminJson | null;
    name: string;
    updated_at: string;
};

export type EnterpriseTeamPayload = Pick<EnterpriseTeam, 'active' | 'code' | 'department_id' | 'description' | 'lead_id' | 'metadata' | 'name'>;

export type EnterprisePosition = {
    active: boolean;
    code: string;
    created_at: string;
    department?: EnterpriseDepartment | null;
    department_id: number | null;
    description: string | null;
    id: number;
    level: string | null;
    metadata: AdminJson | null;
    title: string;
    updated_at: string;
};

export type EnterprisePositionPayload = Pick<EnterprisePosition, 'active' | 'code' | 'department_id' | 'description' | 'level' | 'metadata' | 'title'>;

export type ReportingCalendar = {
    active: boolean;
    created_at: string;
    due_day: number;
    ends_at: string | null;
    frequency: 'biweekly' | 'monthly' | 'weekly' | string;
    id: number;
    metadata: AdminJson | null;
    name: string;
    reminder_days: number[] | null;
    reporting_day: number;
    starts_at: string | null;
    updated_at: string;
};

export type ReportingCalendarPayload = Pick<ReportingCalendar, 'active' | 'due_day' | 'ends_at' | 'frequency' | 'metadata' | 'name' | 'reminder_days' | 'reporting_day' | 'starts_at'>;

export type WorkflowStageConfiguration = {
    editable?: boolean;
    key: string;
    label: string;
    terminal?: boolean;
};

export type WorkflowTransitionConfiguration = {
    actor?: string;
    from: string;
    notification?: string;
    to: string;
};

export type WorkflowConfiguration = {
    active: boolean;
    applies_to: AdminJson | null;
    created_at: string;
    id: number;
    name: string;
    stages: WorkflowStageConfiguration[];
    transitions: WorkflowTransitionConfiguration[];
    updated_at: string;
    version: number;
};

export type WorkflowConfigurationPayload = Pick<WorkflowConfiguration, 'active' | 'applies_to' | 'name' | 'stages' | 'transitions' | 'version'>;

export type EnterpriseNotificationSetting = {
    channels: string[];
    created_at: string;
    enabled: boolean;
    frequency: 'daily_digest' | 'instant' | 'weekly_digest' | string;
    id: number;
    key: string;
    label: string;
    metadata: AdminJson | null;
    recipients: string[] | null;
    updated_at: string;
};

export type EnterpriseNotificationSettingPayload = Pick<EnterpriseNotificationSetting, 'channels' | 'enabled' | 'frequency' | 'key' | 'label' | 'metadata' | 'recipients'>;

export type EnterpriseAiSetting = {
    created_at: string;
    enabled: boolean;
    fallback_enabled: boolean;
    id: number;
    key: string;
    model: string | null;
    options: AdminJson | null;
    provider: 'gemini' | 'openai' | string;
    updated_at: string;
};

export type EnterpriseAiSettingPayload = Pick<EnterpriseAiSetting, 'enabled' | 'fallback_enabled' | 'key' | 'model' | 'options' | 'provider'>;

export type FeatureFlag = {
    created_at: string;
    description: string | null;
    enabled: boolean;
    id: number;
    key: string;
    metadata: AdminJson | null;
    name: string;
    rollout_percentage: number;
    scope: 'department' | 'global' | 'role' | string;
    updated_at: string;
};

export type FeatureFlagPayload = Pick<FeatureFlag, 'description' | 'enabled' | 'key' | 'metadata' | 'name' | 'rollout_percentage' | 'scope'>;

export type AdministrationAuditEvent = {
    causer?: AdminUserSummary | null;
    created_at: string;
    description: string;
    event: string | null;
    id: number;
    log_name: string;
    properties: AdminJson | null;
    subject_id: number | null;
    subject_type: string | null;
};

export type AdministrationOverview = {
    ai_settings: EnterpriseAiSetting[];
    audit_events: AdministrationAuditEvent[];
    company_settings: CompanySetting[];
    departments: EnterpriseDepartment[];
    feature_flags: FeatureFlag[];
    notification_settings: EnterpriseNotificationSetting[];
    positions: EnterprisePosition[];
    reporting_calendars: ReportingCalendar[];
    teams: EnterpriseTeam[];
    workflow_configurations: WorkflowConfiguration[];
};
