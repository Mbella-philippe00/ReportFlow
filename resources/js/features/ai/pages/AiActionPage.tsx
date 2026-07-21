import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business';
import { appConfig } from '@/config/app';
import { useAuthStore } from '@/stores/auth.store';
import type { AiAction } from '@/types';

import { AiPageShell, AiReportActionPanel } from '../components';
import { canRequestWorkflowRecommendation, getAiActionDescription } from '../utils/ai-utils';

export type AiActionPageProps = {
    action: AiAction;
    description?: string;
    title: string;
};

export function AiActionPage({ action, description, title }: AiActionPageProps) {
    const navigate = useNavigate();
    const user = useAuthStore((state) => state.user);

    useEffect(() => {
        document.title = `${title} - ${appConfig.name}`;
    }, [title]);

    if (action === 'workflow_recommendation' && !canRequestWorkflowRecommendation(user)) {
        return (
            <AiPageShell description="Workflow recommendations are restricted by the backend AI policy." title={title}>
                <NoPermission
                    action={{ label: 'Open AI Assistant', onClick: () => navigate('/ai/assistant') }}
                    description="Only managers and super-admins can request AI workflow recommendations."
                    title="Workflow recommendation restricted"
                />
            </AiPageShell>
        );
    }

    return (
        <AiPageShell description={description ?? getAiActionDescription(action)} title={title}>
            <AiReportActionPanel
                actions={[action]}
                defaultAction={action}
                description="Enter an existing report ID and optional context. The backend remains authoritative for permissions and validation."
                title={title}
            />
        </AiPageShell>
    );
}
