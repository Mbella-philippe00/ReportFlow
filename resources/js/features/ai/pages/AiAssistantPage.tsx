import { useEffect } from 'react';

import { appConfig } from '@/config/app';

import { AiPageShell, AiReportActionPanel } from '../components';

export function AiAssistantPage() {
    useEffect(() => {
        document.title = `AI Assistant - ${appConfig.name}`;
    }, []);

    return (
        <AiPageShell
            description="Run ReportFlow AI actions against existing weekly reports without leaving the application shell."
            title="AI Assistant"
        >
            <AiReportActionPanel />
        </AiPageShell>
    );
}
