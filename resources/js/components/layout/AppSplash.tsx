import { motion } from 'framer-motion';

import { ApplicationLogo } from '@/components/shell/ApplicationLogo';
import { Spinner } from '@/components/ui/Spinner';

export function AppSplash() {
    return (
        <div className='flex min-h-screen items-center justify-center bg-background px-6 text-foreground'>
            <motion.div
                animate={{ opacity: 1, scale: 1, y: 0 }}
                className='grid w-full max-w-sm justify-items-center gap-6 rounded-[2rem] border border-border/70 bg-surface/90 p-8 text-center shadow-elevated backdrop-blur'
                initial={{ opacity: 0, scale: 0.98, y: 10 }}
                transition={{ duration: 0.22, ease: 'easeOut' }}
            >
                <ApplicationLogo className='justify-center' showTagline={false} />
                <div className='grid gap-2'>
                    <p className='font-display text-xl font-semibold tracking-tight text-foreground'>ReportFlow</p>
                    <p className='text-sm text-muted-foreground'>Transforming weekly reports into decisions.</p>
                </div>
                <div className='flex items-center gap-3 rounded-full bg-blue-50 px-4 py-2 text-sm font-medium text-primary dark:bg-blue-950/40'>
                    <Spinner className='text-primary' size='sm' />
                    Loading workspace
                </div>
            </motion.div>
        </div>
    );
}
