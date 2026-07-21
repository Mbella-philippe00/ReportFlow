import { useNavigate } from 'react-router-dom';

import { NoPermission } from '@/components/business';
import { PageContainer } from '@/components/layout/PageContainer';

export function AnalyticsAccessDenied() {
    const navigate = useNavigate();

    return (
        <PageContainer description="Analytics are restricted by the backend Analytics policy." eyebrow="Analytics" title="Analytics">
            <NoPermission
                action={{ label: 'Go to dashboard', onClick: () => navigate('/dashboard') }}
                description="Your current role cannot access the Analytics REST API. Managers and super-admins can view analytics."
                title="Analytics access restricted"
            />
        </PageContainer>
    );
}
