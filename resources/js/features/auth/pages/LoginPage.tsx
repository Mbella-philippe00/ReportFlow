import { zodResolver } from '@hookform/resolvers/zod';
import { AlertCircle, ArrowRight, Mail, ShieldCheck } from 'lucide-react';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { Link, useLocation, useNavigate } from 'react-router-dom';

import { Alert, Button, Input } from '@/components/ui';
import { appConfig } from '@/config/app';
import { loginSchema } from '@/features/auth/schemas/login.schema';
import type { LoginFormValues } from '@/features/auth/schemas/login.schema';
import { useLoginMutation } from '@/features/auth/hooks/useAuth';
import { HttpError } from '@/lib/http';
import { useToast } from '@/providers/ToastProvider';

type LoginLocationState = {
    from?: {
        pathname?: string;
    };
};

const getRedirectPath = (state: unknown) => {
    const locationState = state as LoginLocationState | null;
    const pathname = locationState?.from?.pathname;

    return pathname ? (pathname !== '/login' ? pathname : '/dashboard') : '/dashboard';
};

export function LoginPage() {
    const navigate = useNavigate();
    const location = useLocation();
    const { notify } = useToast();
    const loginMutation = useLoginMutation();
    const {
        formState: { errors, isSubmitting },
        handleSubmit,
        register,
        setError,
    } = useForm<LoginFormValues>({
        resolver: zodResolver(loginSchema),
        defaultValues: {
            email: '',
            password: '',
        },
    });

    useEffect(() => {
        document.title = 'Sign in - ' + appConfig.name;
    }, []);

    const submitForm = handleSubmit(async (values) => {
        try {
            await loginMutation.mutateAsync(values);
            notify({ intent: 'success', title: 'Signed in' });
            navigate(getRedirectPath(location.state), { replace: true });
        } catch (error) {
            if (error instanceof HttpError && error.validationErrors) {
                Object.entries(error.validationErrors).forEach(([field, messages]) => {
                    if (field === 'email' || field === 'password') {
                        setError(field, {
                            message: messages[0] ?? 'This field is invalid.',
                            type: 'server',
                        });
                    }
                });
                return;
            }

            setError('root', {
                message: error instanceof Error ? error.message : 'Unable to sign in.',
                type: 'server',
            });
        }
    });

    const isPending = isSubmitting ? true : loginMutation.isPending;

    return (
        <div>
            <div className='mb-8 text-center'>
                <div className='mx-auto mb-4 flex size-12 items-center justify-center rounded-2xl bg-blue-50 text-primary shadow-soft dark:bg-blue-950/40'>
                    <ShieldCheck aria-hidden='true' className='size-6' />
                </div>
                <p className='text-xs font-semibold uppercase tracking-[0.18em] text-primary'>Welcome back</p>
                <h1 className='mt-3 font-display text-3xl font-semibold tracking-[-0.04em] text-surface-foreground'>Sign in to ReportFlow</h1>
                <p className='mt-3 text-sm leading-6 text-muted-foreground'>Access reports, workflow approvals, documents, AI insights, analytics, and administration.</p>
            </div>

            <form className='grid gap-5' onSubmit={submitForm}>
                {errors.root?.message ? (
                    <Alert description={errors.root.message} icon={<AlertCircle aria-hidden='true' className='size-5' />} intent='danger' title='Sign in failed' />
                ) : null}

                <Input autoComplete='email' error={errors.email?.message} label='Email' leftIcon={<Mail aria-hidden='true' className='size-4' />} placeholder='admin@reportflow.test' type='email' {...register('email')} />
                <Input autoComplete='current-password' error={errors.password?.message} label='Password' type='password' {...register('password')} />

                <div className='flex items-center justify-between gap-3 text-sm'>
                    <label className='inline-flex items-center gap-2 text-muted-foreground'>
                        <input className='size-4 rounded border-border text-primary focus:ring-primary' type='checkbox' />
                        Remember me
                    </label>
                    <Link className='font-semibold text-primary transition hover:text-blue-700' to='/login'>Forgot password?</Link>
                </div>

                <Button className='w-full' loading={isPending} rightIcon={<ArrowRight aria-hidden='true' className='size-4' />} size='lg' type='submit'>
                    Sign in
                </Button>
            </form>

            <p className='mt-7 text-center text-sm text-muted-foreground'>
                New to ReportFlow?{' '}
                <Link className='font-semibold text-primary transition hover:text-blue-700' to='/register'>Request access</Link>
            </p>
        </div>
    );
}
