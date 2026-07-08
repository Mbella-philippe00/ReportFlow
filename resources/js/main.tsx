import '../css/app.css';

import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';

import { App } from '@/app/App';

const rootElement = document.getElementById('app');

if (!rootElement) {
    throw new Error('ReportFlow root element was not found.');
}

createRoot(rootElement).render(
    <StrictMode>
        <App />
    </StrictMode>,
);
