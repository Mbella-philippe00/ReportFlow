import { BarChart3, CheckCircle2, FileText, LockKeyhole, Sparkles, Users } from 'lucide-react';
import { Outlet } from 'react-router-dom';

import { ApplicationLogo } from '@/components/shell/ApplicationLogo';

const proofPoints = [
    { icon: FileText, label: 'Weekly reports', value: '150+' },
    { icon: Users, label: 'Enterprise teams', value: '24' },
    { icon: BarChart3, label: 'Executive KPIs', value: '98%' },
];

export function GuestLayout() {
    return (
        <div className='min-h-screen overflow-hidden bg-background text-foreground'>
            <main className='grid min-h-screen lg:grid-cols-[1.08fr_0.92fr]'>
                <section className='relative hidden min-h-screen overflow-hidden border-r border-border/70 bg-white px-10 py-8 lg:flex lg:flex-col dark:bg-surface' aria-label='ReportFlow enterprise preview'>
                    <div className='absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.18),transparent_32rem),linear-gradient(135deg,rgba(255,255,255,0.96),rgba(239,246,255,0.78))] dark:bg-[radial-gradient(circle_at_20%_20%,rgba(37,99,235,0.20),transparent_32rem)]' />
                    <div className='relative z-10 flex items-center justify-between'>
                        <ApplicationLogo showTagline={false} />
                        <div className='rounded-full border border-blue-100 bg-white/80 px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-primary shadow-soft backdrop-blur dark:border-blue-900 dark:bg-surface/80'>Premium SaaS</div>
                    </div>

                    <div className='relative z-10 my-auto max-w-3xl animate-premium-slide-up'>
                        <div className='mb-6 inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white/80 px-4 py-2 text-sm font-semibold text-primary shadow-soft backdrop-blur dark:border-blue-900 dark:bg-surface/80'>
                            <Sparkles aria-hidden='true' className='size-4' />
                            Apple-clean reporting workflows
                        </div>
                        <h1 className='font-display text-5xl font-semibold leading-[1.04] tracking-[-0.055em] text-slate-950 dark:text-white xl:text-6xl'>
                            Transform weekly reporting into executive decisions.
                        </h1>
                        <p className='mt-6 max-w-2xl text-lg leading-8 text-slate-600 dark:text-slate-300'>
                            A calm enterprise workspace for workflow approvals, documents, analytics, AI assistance, and administration.
                        </p>

                        <div className='mt-10 grid max-w-2xl gap-4 sm:grid-cols-3'>
                            {proofPoints.map(({ icon: Icon, label, value }) => (
                                <div className='rounded-3xl border border-white/70 bg-white/80 p-5 shadow-elevated backdrop-blur dark:border-slate-800 dark:bg-surface/80' key={label}>
                                    <Icon aria-hidden='true' className='size-5 text-primary' />
                                    <p className='mt-4 font-display text-2xl font-semibold tracking-tight text-slate-950 dark:text-white'>{value}</p>
                                    <p className='mt-1 text-sm text-muted-foreground'>{label}</p>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className='relative z-10 mb-8 rounded-[2rem] border border-white/70 bg-white/80 p-5 shadow-premium backdrop-blur dark:border-slate-800 dark:bg-surface/80'>
                        <div className='flex items-center justify-between border-b border-border/70 pb-4'>
                            <div>
                                <p className='text-sm font-semibold text-foreground'>Executive dashboard</p>
                                <p className='text-xs text-muted-foreground'>Workflow health · current quarter</p>
                            </div>
                            <span className='rounded-full bg-success/10 px-3 py-1 text-xs font-semibold text-success'>On track</span>
                        </div>
                        <div className='mt-5 grid grid-cols-3 gap-3'>
                            {[76, 92, 61].map((height, index) => (
                                <div className='flex h-28 items-end rounded-2xl bg-blue-50 p-2 dark:bg-blue-950/30' key={height}>
                                    <div className='w-full rounded-xl bg-primary shadow-[0_12px_24px_rgba(37,99,235,0.24)]' style={{ height: String(height) + '%', opacity: 1 - index * 0.14 }} />
                                </div>
                            ))}
                        </div>
                        <div className='mt-4 flex items-center gap-2 text-sm text-muted-foreground'>
                            <CheckCircle2 aria-hidden='true' className='size-4 text-success' />
                            Reports, documents, and approvals stay synchronized.
                        </div>
                    </div>
                </section>

                <section className='flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 lg:px-10'>
                    <div className='w-full max-w-md animate-premium-slide-up'>
                        <div className='mb-8 flex justify-center lg:hidden'>
                            <ApplicationLogo showTagline={false} />
                        </div>
                        <div className='rounded-[2rem] border border-border/70 bg-surface/95 p-6 shadow-premium backdrop-blur sm:p-8'>
                            <div className='mb-8 hidden justify-center lg:flex'>
                                <ApplicationLogo showTagline={false} />
                            </div>
                            <Outlet />
                        </div>
                        <p className='mt-6 flex items-center justify-center gap-2 text-center text-xs text-muted-foreground'>
                            <LockKeyhole aria-hidden='true' className='size-3.5' />
                            Secure enterprise access · ReportFlow
                        </p>
                    </div>
                </section>
            </main>
        </div>
    );
}
