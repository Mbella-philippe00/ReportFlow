import { Bot, BriefcaseBusiness, Building2, Flag, GitBranch, History, Loader2, Save, Send, Users } from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import type { FormEvent, ReactNode } from 'react';

import { NoPermission } from '@/components/business';
import { PageContainer } from '@/components/layout/PageContainer';
import { Badge, Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Input, Select, Skeleton, Switch, Textarea } from '@/components/ui';
import { appConfig } from '@/config/app';
import { useToast } from '@/providers/ToastProvider';
import { useAuthStore } from '@/stores/auth.store';
import type { CompanySettingPayload, EnterpriseAiSetting, EnterpriseDepartmentPayload, EnterpriseNotificationSetting, FeatureFlag, WorkflowConfigurationPayload } from '@/types';

import {
    useAdministrationOverviewQuery,
    useCreateDepartmentMutation,
    useCreateWorkflowConfigurationMutation,
    useSaveAiSettingMutation,
    useSaveFeatureFlagMutation,
    useSaveNotificationSettingMutation,
    useUpdateCompanySettingsMutation,
    useUpdateWorkflowConfigurationMutation,
} from '../hooks/useAdministration';

const defaultWorkflowStages = [
    { editable: true, key: 'draft', label: 'Draft', terminal: false },
    { editable: false, key: 'submitted', label: 'Submitted', terminal: false },
    { editable: false, key: 'under_review', label: 'Under Review', terminal: false },
    { editable: false, key: 'approved', label: 'Approved', terminal: true },
    { editable: true, key: 'rejected', label: 'Rejected', terminal: false },
];

const defaultWorkflowTransitions = [
    { actor: 'employee', from: 'draft', notification: 'report.submitted', to: 'submitted' },
    { actor: 'employee', from: 'rejected', notification: 'report.resubmitted', to: 'submitted' },
    { actor: 'manager', from: 'submitted', notification: 'report.under_review', to: 'under_review' },
    { actor: 'manager', from: 'under_review', notification: 'report.approved', to: 'approved' },
    { actor: 'manager', from: 'submitted', notification: 'report.rejected', to: 'rejected' },
    { actor: 'manager', from: 'under_review', notification: 'report.rejected', to: 'rejected' },
];

const getSettingValue = (settings: CompanySettingPayload[], key: string, fallback = ''): string => {
    const setting = settings.find((item) => item.key === key);

    return typeof setting?.value === 'string' || typeof setting?.value === 'number' ? String(setting.value) : fallback;
};

const formatDateTime = (value: string | null | undefined) => {
    if (!value) {
        return 'Not set';
    }

    return new Intl.DateTimeFormat(undefined, { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(value));
};

const statusIntent = (enabled: boolean) => enabled ? 'success' as const : 'neutral' as const;

function MetricCard({ icon, label, value }: { icon: ReactNode; label: string; value: number | string }) {
    return (
        <Card>
            <CardHeader className='flex-row items-center justify-between gap-3'>
                <div>
                    <CardDescription>{label}</CardDescription>
                    <CardTitle>{value}</CardTitle>
                </div>
                {icon}
            </CardHeader>
        </Card>
    );
}

function SectionShell({ children, description, title }: { children: ReactNode; description: string; title: string }) {
    return (
        <Card>
            <CardHeader>
                <CardTitle>{title}</CardTitle>
                <CardDescription>{description}</CardDescription>
            </CardHeader>
            <CardContent className='grid gap-4'>{children}</CardContent>
        </Card>
    );
}

export function AdministrationCenterPage() {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);
    const { notify } = useToast();
    const overviewQuery = useAdministrationOverviewQuery();
    const updateCompanySettings = useUpdateCompanySettingsMutation();
    const createDepartment = useCreateDepartmentMutation();
    const createWorkflowConfiguration = useCreateWorkflowConfigurationMutation();
    const updateWorkflowConfiguration = useUpdateWorkflowConfigurationMutation();
    const saveNotificationSetting = useSaveNotificationSettingMutation();
    const saveAiSetting = useSaveAiSettingMutation();
    const saveFeatureFlag = useSaveFeatureFlagMutation();

    const overview = overviewQuery.data?.data;
    const canManageAdministration = user?.roles.includes('super-admin') ?? false;
    const [companyName, setCompanyName] = useState('');
    const [companyTimezone, setCompanyTimezone] = useState('UTC');
    const [departmentName, setDepartmentName] = useState('');
    const [departmentCode, setDepartmentCode] = useState('');
    const [departmentDescription, setDepartmentDescription] = useState('');
    const [aiProvider, setAiProvider] = useState<'gemini' | 'openai'>('openai');
    const [aiModel, setAiModel] = useState('');
    const [aiFallbackEnabled, setAiFallbackEnabled] = useState(true);

    useEffect(() => {
        document.title = 'Enterprise Administration - ' + appConfig.name;
    }, []);

    const companySettings = useMemo<CompanySettingPayload[]>(() => {
        if (!overview) {
            return [];
        }

        return overview.company_settings.map((setting) => ({
            group: setting.group,
            is_public: setting.is_public,
            key: setting.key,
            label: setting.label,
            type: setting.type,
            value: setting.value?.value ?? null,
        }));
    }, [overview]);

    useEffect(() => {
        if (companySettings.length === 0) {
            return;
        }

        setCompanyName(getSettingValue(companySettings, 'company.name', 'ReportFlow'));
        setCompanyTimezone(getSettingValue(companySettings, 'company.timezone', 'UTC'));
    }, [companySettings]);

    const primaryAiSetting = overview?.ai_settings[0];

    useEffect(() => {
        if (!primaryAiSetting) {
            return;
        }

        setAiProvider(primaryAiSetting.provider === 'gemini' ? 'gemini' : 'openai');
        setAiModel(primaryAiSetting.model ?? '');
        setAiFallbackEnabled(primaryAiSetting.fallback_enabled);
    }, [primaryAiSetting]);

    if (!canManageAdministration) {
        return (
            <PageContainer description='Enterprise configuration is restricted to super admins.' eyebrow='Administration' title='Enterprise Administration Center'>
                <NoPermission
                    action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }}
                    description='Only super admins can manage company settings, organization structure, workflow configuration, feature flags, and administration audit trails.'
                    title='Administration access restricted'
                />
            </PageContainer>
        );
    }

    const activeWorkflow = overview?.workflow_configurations.find((workflow) => workflow.active) ?? overview?.workflow_configurations[0];

    const handleCompanySubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const current = companySettings.filter((setting) => !['company.name', 'company.timezone'].includes(setting.key));
        const payload: CompanySettingPayload[] = [
            ...current,
            { group: 'company', is_public: true, key: 'company.name', label: 'Company name', type: 'text', value: companyName },
            { group: 'company', is_public: true, key: 'company.timezone', label: 'Default timezone', type: 'text', value: companyTimezone },
        ];

        updateCompanySettings.mutate(payload, {
            onError: (error) => notify({ description: error.message, intent: 'error', title: 'Company settings failed' }),
            onSuccess: () => notify({ intent: 'success', title: 'Company settings updated' }),
        });
    };

    const handleDepartmentSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const payload: EnterpriseDepartmentPayload = {
            active: true,
            code: departmentCode.trim().toUpperCase(),
            description: departmentDescription.trim() || null,
            manager_id: null,
            metadata: { source: 'administration_center' },
            name: departmentName.trim(),
        };

        createDepartment.mutate(payload, {
            onError: (error) => notify({ description: error.message, intent: 'error', title: 'Department not created' }),
            onSuccess: () => {
                setDepartmentName('');
                setDepartmentCode('');
                setDepartmentDescription('');
                notify({ intent: 'success', title: 'Department created' });
            },
        });
    };

    const saveDefaultWorkflow = () => {
        const payload: WorkflowConfigurationPayload = {
            active: true,
            applies_to: { departments: ['all'], report_type: 'weekly_report' },
            name: activeWorkflow?.name ?? 'Default weekly report workflow',
            stages: defaultWorkflowStages,
            transitions: defaultWorkflowTransitions,
            version: activeWorkflow?.version ?? 1,
        };

        const mutationOptions = {
            onError: (error: Error) => notify({ description: error.message, intent: 'error', title: 'Workflow configuration failed' }),
            onSuccess: () => notify({ intent: 'success', title: 'Workflow configuration saved' }),
        };

        if (activeWorkflow) {
            updateWorkflowConfiguration.mutate({ id: activeWorkflow.id, payload }, mutationOptions);
        } else {
            createWorkflowConfiguration.mutate(payload, mutationOptions);
        }
    };

    const toggleNotification = (setting: EnterpriseNotificationSetting) => {
        saveNotificationSetting.mutate({
            channels: setting.channels,
            enabled: !setting.enabled,
            frequency: setting.frequency,
            key: setting.key,
            label: setting.label,
            metadata: setting.metadata,
            recipients: setting.recipients,
        }, {
            onError: (error) => notify({ description: error.message, intent: 'error', title: 'Notification setting failed' }),
            onSuccess: () => notify({ intent: 'success', title: 'Notification setting saved' }),
        });
    };

    const handleAiSubmit = (event: FormEvent<HTMLFormElement>) => {
        event.preventDefault();

        const payload: Pick<EnterpriseAiSetting, 'enabled' | 'fallback_enabled' | 'key' | 'model' | 'options' | 'provider'> = {
            enabled: primaryAiSetting?.enabled ?? true,
            fallback_enabled: aiFallbackEnabled,
            key: primaryAiSetting?.key ?? 'weekly_report_assistant',
            model: aiModel.trim() || null,
            options: primaryAiSetting?.options ?? { managed_from: 'administration_center' },
            provider: aiProvider,
        };

        saveAiSetting.mutate(payload, {
            onError: (error) => notify({ description: error.message, intent: 'error', title: 'AI setting failed' }),
            onSuccess: () => notify({ intent: 'success', title: 'AI setting saved' }),
        });
    };

    const toggleFeatureFlag = (flag: FeatureFlag) => {
        saveFeatureFlag.mutate({
            description: flag.description,
            enabled: !flag.enabled,
            key: flag.key,
            metadata: flag.metadata,
            name: flag.name,
            rollout_percentage: flag.rollout_percentage,
            scope: flag.scope,
        }, {
            onError: (error) => notify({ description: error.message, intent: 'error', title: 'Feature flag failed' }),
            onSuccess: () => notify({ intent: 'success', title: 'Feature flag saved' }),
        });
    };

    const isSavingWorkflow = createWorkflowConfiguration.isPending || updateWorkflowConfiguration.isPending;

    return (
        <PageContainer
            actions={<Button leftIcon={<Loader2 aria-hidden='true' className='size-4' />} loading={overviewQuery.isFetching} onClick={() => void overviewQuery.refetch()} variant='outline'>Refresh</Button>}
            description='Configure company defaults, organization structure, workflow settings, notifications, AI defaults, feature flags, and administration audit visibility.'
            eyebrow='Sprint 15'
            title='Enterprise Administration Center'
        >
            {overviewQuery.isLoading ? (
                <div className='grid gap-4 md:grid-cols-2 xl:grid-cols-4'>
                    {Array.from({ length: 8 }).map((_, index) => <Skeleton className='h-28 rounded-2xl' key={index} />)}
                </div>
            ) : overviewQuery.isError ? (
                <EmptyState action={{ label: 'Retry', onClick: () => void overviewQuery.refetch() }} description={overviewQuery.error.message} title='Unable to load administration center' />
            ) : overview ? (
                <div className='grid gap-6'>
                    <div className='grid gap-4 md:grid-cols-2 xl:grid-cols-4'>
                        <MetricCard icon={<Building2 aria-hidden='true' className='size-5 text-primary' />} label='Departments' value={overview.departments.length} />
                        <MetricCard icon={<Users aria-hidden='true' className='size-5 text-primary' />} label='Teams' value={overview.teams.length} />
                        <MetricCard icon={<BriefcaseBusiness aria-hidden='true' className='size-5 text-primary' />} label='Positions' value={overview.positions.length} />
                        <MetricCard icon={<Flag aria-hidden='true' className='size-5 text-primary' />} label='Feature flags' value={overview.feature_flags.length} />
                    </div>

                    <div className='grid gap-6 xl:grid-cols-[1fr_1fr]'>
                        <SectionShell description='Public and private organization defaults used across reporting, notifications, analytics, and AI.' title='Company settings'>
                            <form className='grid gap-4' onSubmit={handleCompanySubmit}>
                                <Input label='Company name' onChange={(event) => setCompanyName(event.target.value)} required value={companyName} />
                                <Input label='Timezone' onChange={(event) => setCompanyTimezone(event.target.value)} required value={companyTimezone} />
                                <Button leftIcon={<Save aria-hidden='true' className='size-4' />} loading={updateCompanySettings.isPending} type='submit'>Save company settings</Button>
                            </form>
                        </SectionShell>

                        <SectionShell description='Create enterprise departments without changing existing employee/report business logic.' title='Department management'>
                            <form className='grid gap-4' onSubmit={handleDepartmentSubmit}>
                                <div className='grid gap-4 sm:grid-cols-2'>
                                    <Input label='Department name' onChange={(event) => setDepartmentName(event.target.value)} required value={departmentName} />
                                    <Input label='Code' onChange={(event) => setDepartmentCode(event.target.value)} required value={departmentCode} />
                                </div>
                                <Textarea label='Description' onChange={(event) => setDepartmentDescription(event.target.value)} value={departmentDescription} />
                                <Button leftIcon={<Send aria-hidden='true' className='size-4' />} loading={createDepartment.isPending} type='submit'>Create department</Button>
                            </form>
                        </SectionShell>
                    </div>

                    <div className='grid gap-6 xl:grid-cols-[1.15fr_0.85fr]'>
                        <SectionShell description='Departments, assigned managers, teams, and positions seeded for enterprise configuration.' title='Organization directory'>
                            <div className='grid gap-3'>
                                {overview.departments.map((department) => (
                                    <div className='rounded-xl border bg-muted/30 p-3' key={department.id}>
                                        <div className='flex flex-wrap items-center justify-between gap-3'>
                                            <div>
                                                <p className='font-medium text-foreground'>{department.name}</p>
                                                <p className='text-xs text-muted-foreground'>{department.code} · {department.manager?.name ?? 'No manager assigned'}</p>
                                            </div>
                                            <Badge intent={statusIntent(department.active)}>{department.active ? 'Active' : 'Inactive'}</Badge>
                                        </div>
                                        <p className='mt-2 text-sm text-muted-foreground'>{department.description}</p>
                                    </div>
                                ))}
                            </div>
                        </SectionShell>

                        <SectionShell description='Teams and positions are modeled separately from employee records to preserve reporting history.' title='Teams and positions'>
                            <div className='grid gap-3'>
                                <div className='rounded-xl border bg-muted/30 p-3'>
                                    <p className='font-medium text-foreground'>Teams</p>
                                    <p className='mt-1 text-sm text-muted-foreground'>{overview.teams.map((team) => team.name).join(', ')}</p>
                                </div>
                                <div className='rounded-xl border bg-muted/30 p-3'>
                                    <p className='font-medium text-foreground'>Positions</p>
                                    <p className='mt-1 text-sm text-muted-foreground'>{overview.positions.map((position) => position.title).join(', ')}</p>
                                </div>
                            </div>
                        </SectionShell>
                    </div>

                    <div className='grid gap-6 xl:grid-cols-2'>
                        <SectionShell description='Configure reporting cadence and deadlines surfaced to admins and future scheduling workflows.' title='Reporting calendar'>
                            {overview.reporting_calendars.map((calendar) => (
                                <div className='rounded-xl border bg-muted/30 p-3' key={calendar.id}>
                                    <div className='flex items-center justify-between gap-3'>
                                        <p className='font-medium text-foreground'>{calendar.name}</p>
                                        <Badge intent={statusIntent(calendar.active)}>{calendar.frequency}</Badge>
                                    </div>
                                    <p className='mt-2 text-sm text-muted-foreground'>Reporting day {calendar.reporting_day}; due day {calendar.due_day}; reminders {(calendar.reminder_days ?? []).join(', ') || 'none'}.</p>
                                </div>
                            ))}
                        </SectionShell>

                        <SectionShell description='Configurable workflow builder metadata mirrors the existing workflow state machine without changing its rules.' title='Workflow builder'>
                            <div className='rounded-xl border bg-muted/30 p-3'>
                                <div className='flex flex-wrap items-center justify-between gap-3'>
                                    <div>
                                        <p className='font-medium text-foreground'>{activeWorkflow?.name ?? 'Default weekly report workflow'}</p>
                                        <p className='text-xs text-muted-foreground'>{activeWorkflow ? 'Version ' + activeWorkflow.version : 'No active workflow configuration yet'}</p>
                                    </div>
                                    <Badge intent={activeWorkflow?.active ? 'success' : 'warning'}>{activeWorkflow?.active ? 'Active' : 'Draft'}</Badge>
                                </div>
                                <div className='mt-3 flex flex-wrap gap-2'>
                                    {defaultWorkflowStages.map((stage) => <Badge intent={stage.terminal ? 'success' : 'primary'} key={stage.key}>{stage.label}</Badge>)}
                                </div>
                                <Button className='mt-4' leftIcon={<GitBranch aria-hidden='true' className='size-4' />} loading={isSavingWorkflow} onClick={saveDefaultWorkflow}>Save default workflow</Button>
                            </div>
                        </SectionShell>
                    </div>

                    <div className='grid gap-6 xl:grid-cols-3'>
                        <SectionShell description='Notification defaults integrate with the existing database notification system.' title='Notification settings'>
                            {overview.notification_settings.map((setting) => (
                                <Switch
                                    checked={setting.enabled}
                                    description={setting.channels.join(', ') + ' · ' + setting.frequency}
                                    key={setting.id}
                                    label={setting.label}
                                    onChange={() => toggleNotification(setting)}
                                />
                            ))}
                        </SectionShell>

                        <SectionShell description='Administration stores AI defaults while runtime provider resolution remains config/env based.' title='AI settings'>
                            <form className='grid gap-4' onSubmit={handleAiSubmit}>
                                <Select label='Provider' onChange={(event) => setAiProvider(event.target.value === 'gemini' ? 'gemini' : 'openai')} value={aiProvider}>
                                    <option value='openai'>OpenAI</option>
                                    <option value='gemini'>Gemini</option>
                                </Select>
                                <Input label='Model' onChange={(event) => setAiModel(event.target.value)} placeholder='gpt-4o-mini' value={aiModel} />
                                <Switch checked={aiFallbackEnabled} description='Allow configured provider fallback during AI failures.' label='Fallback enabled' onChange={(event) => setAiFallbackEnabled(event.target.checked)} />
                                <Button leftIcon={<Bot aria-hidden='true' className='size-4' />} loading={saveAiSetting.isPending} type='submit'>Save AI settings</Button>
                            </form>
                        </SectionShell>

                        <SectionShell description='Feature flags expose enterprise capabilities without removing existing navigation or APIs.' title='Feature flags'>
                            {overview.feature_flags.map((flag) => (
                                <Switch
                                    checked={flag.enabled}
                                    description={flag.scope + ' · ' + flag.rollout_percentage + '% rollout'}
                                    key={flag.id}
                                    label={flag.name}
                                    onChange={() => toggleFeatureFlag(flag)}
                                />
                            ))}
                        </SectionShell>
                    </div>

                    <SectionShell description='Recent administration changes recorded through the existing activity log.' title='Administration audit center'>
                        <div className='grid gap-3 md:grid-cols-2'>
                            {overview.audit_events.length === 0 ? (
                                <EmptyState description='Administration events will appear after settings are changed.' title='No administration activity yet' />
                            ) : overview.audit_events.map((event) => (
                                <div className='rounded-xl border bg-muted/30 p-3' key={event.id}>
                                    <div className='flex items-start justify-between gap-3'>
                                        <div>
                                            <p className='font-medium text-foreground'>{event.description}</p>
                                            <p className='text-xs text-muted-foreground'>{event.causer?.name ?? 'System'} · {formatDateTime(event.created_at)}</p>
                                        </div>
                                        <History aria-hidden='true' className='size-4 text-primary' />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </SectionShell>
                </div>
            ) : null}
        </PageContainer>
    );
}
