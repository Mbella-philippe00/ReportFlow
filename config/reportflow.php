<?php

return [
    'version' => env('REPORTFLOW_VERSION', '1.0.0'),
    'release' => env('REPORTFLOW_RELEASE', 'production-readiness'),
    'commit' => env('REPORTFLOW_COMMIT', env('GIT_COMMIT', 'local')),

    'cache' => [
        'dashboard_ttl' => (int) env('REPORTFLOW_DASHBOARD_CACHE_TTL', 60),
        'analytics_ttl' => (int) env('REPORTFLOW_ANALYTICS_CACHE_TTL', 300),
        'readiness_ttl' => (int) env('REPORTFLOW_READINESS_CACHE_TTL', 15),
    ],

    'uploads' => [
        'max_file_size_kb' => (int) env('REPORTFLOW_UPLOAD_MAX_KB', 20480),
        'allowed_extensions' => array_filter(array_map(
            'trim',
            explode(',', (string) env('REPORTFLOW_UPLOAD_EXTENSIONS', 'pdf,doc,docx,xls,xlsx,csv,png,jpg,jpeg,gif,webp,txt,md,json'))
        )),
    ],

    'security' => [
        'force_hsts' => (bool) env('REPORTFLOW_FORCE_HSTS', false),
        'csp' => env(
    'REPORTFLOW_CSP',
    "default-src 'self'; base-uri 'self'; frame-ancestors 'self'; object-src 'none'; img-src 'self' data: blob:; font-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; connect-src 'self' https://api.openai.com https://generativelanguage.googleapis.com"
),
        'permissions_policy' => env('REPORTFLOW_PERMISSIONS_POLICY', 'camera=(), microphone=(), geolocation=(), payment=()'),
    ],

    'rate_limits' => [
        'api_per_minute' => (int) env('REPORTFLOW_API_RATE_LIMIT', 120),
        'login_per_minute' => (int) env('REPORTFLOW_LOGIN_RATE_LIMIT', 5),
    ],
];
