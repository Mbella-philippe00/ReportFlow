import { ArrowLeft, Building2, CheckCircle2, Mail, UserRound } from 'lucide-react';
import { useEffect } from 'react';
import { Link } from 'react-router-dom';

import { Button, Input } from '@/components/ui';
import { appConfig } from '@/config/app';

const onboardingItems = ['Enterprise SSO-ready workspace', 'Workflow, AI, analytics and documents', 'Designed for executive reporting teams'];

export function RegisterPage() {
    useEffect(() => {
        document.title = 'Request access - ' + appConfig.name;
    }, []);

    return (
        <div>
            <div className='mb-8 text-center'>
                <div className='mx-auto mb-4 flex size-12 items-center justify-center rounded-2xl bg-blue-50 text-primary shadow-soft dark:bg-blue-950/40'>
                    <Building2 aria-hidden='true' className='size-6' />
                </div>
                <p className='text-xs font-semibold uppercase tracking-[0.18em] text-primary'>Enterprise onboarding</p>
                <h1 className='mt-3 font-display text-3xl font-semibold tracking-[-0.04em] text-surface-foreground'>Request access</h1>
                <p className='mt-3 text-sm leading-6 text-muted-foreground'>Create a premium onboarding request for your organization. A ReportFlow administrator can provision your account.</p>
            </div>

            <div className='grid gap-5'>
                <Input label='Full name' leftIcon={<UserRound aria-hidden='true' className='size-4' />} placeholder='Amina ReportFlow' />
                <Input label='Work email' leftIcon={<Mail aria-hidden='true' className='size-4' />} placeholder='you@company.com' type='email' />
                <Input label='Company' leftIcon={<Building2 aria-hidden='true' className='size-4' />} placeholder='Acme Group' />

                <div className='rounded-3xl border border-blue-100 bg-blue-50/70 p-4 text-sm text-slate-700 dark:border-blue-900 dark:bg-blue-950/30 dark:text-slate-200'>
                    <p className='font-semibold text-foreground'>What happens next?</p>
                    <ul className='mt-3 grid gap-2'>
                        {onboardingItems.map((item) => (
                            <li className='flex items-start gap-2' key={item}>
                                <CheckCircle2 aria-hidden='true' className='mt-0.5 size-4 shrink-0 text-success' />
                                <span>{item}</span>
                            </li>
                        ))}
                    </ul>
                </div>

                <Button disabled size='lg'>Submit request</Button>
            </div>

            <p className='mt-7 text-center text-sm text-muted-foreground'>
                Already have access?{' '}
                <Link className='inline-flex items-center gap-1 font-semibold text-primary transition hover:text-blue-700' to='/login'>
                    <ArrowLeft aria-hidden='true' className='size-3.5' />
                    Sign in
                </Link>
            </p>
        </div>
    );
}
