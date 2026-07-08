import { Outlet } from 'react-router-dom';

import { ApplicationLogo } from '@/components/shell/ApplicationLogo';
import { Footer } from '@/components/shell/Footer';

export function GuestLayout() {
    return (
        <div className="flex min-h-screen flex-col bg-background text-foreground">
            <main className="flex flex-1 items-center justify-center px-4 py-10">
                <section className="w-full max-w-md rounded-2xl border bg-surface p-6 shadow-soft sm:p-8">
                    <ApplicationLogo />
                    <div className="mt-8">
                        <Outlet />
                    </div>
                </section>
            </main>
            <Footer />
        </div>
    );
}

