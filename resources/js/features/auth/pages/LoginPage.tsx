import { zodResolver } from '@hookform/resolvers/zod';
import { AlertCircle, LogIn } from 'lucide-react';
import { useEffect } from 'react';
import { useForm } from 'react-hook-form';
import { useLocation, useNavigate } from 'react-router-dom';

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

    return pathname && pathname !== '/login' ? pathname : '/dashboard';
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
        document.title = `Sign in - ${appConfig.name}`;
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

    const isPending = isSubmitting || loginMutation.isPending;

    return (
        <div>
            <p className="text-sm font-medium uppercase tracking-wide text-primary">ReportFlow</p>
            <h1 className="mt-3 text-2xl font-semibold text-surface-foreground">Sign in</h1>
            <p className="mt-3 text-sm leading-6 text-muted-foreground">Use your ReportFlow account to access reports, workflow, notifications, and analytics.</p>

            <form className="mt-8 grid gap-5" onSubmit={submitForm}>
                {errors.root?.message && (
                    <Alert description={errors.root.message} icon={<AlertCircle aria-hidden="true" className="size-5" />} intent="danger" title="Sign in failed" />
                )}

                <Input autoComplete="email" error={errors.email?.message} label="Email" placeholder="you@example.com" type="email" {...register('email')} />
                <Input autoComplete="current-password" error={errors.password?.message} label="Password" type="password" {...register('password')} />

                <Button leftIcon={<LogIn aria-hidden="true" className="size-4" />} loading={isPending} type="submit">
                    Sign in
                </Button>
            </form>
        </div>
    );
}
