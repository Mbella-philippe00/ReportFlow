#!/usr/bin/env sh
set -eu

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

php artisan storage:link --force >/dev/null 2>&1 || true

if [ "${REPORTFLOW_RUN_MIGRATIONS:-false}" = "true" ]; then
    php artisan migrate --force
fi

# Création automatique de l'administrateur Filament
if [ -n "${FILAMENT_ADMIN_EMAIL:-}" ] && [ -n "${FILAMENT_ADMIN_PASSWORD:-}" ]; then
php artisan tinker --execute="
\$user = \App\Models\User::firstOrNew([
    'email' => env('FILAMENT_ADMIN_EMAIL')
]);

\$user->name = env('FILAMENT_ADMIN_NAME', 'Administrator');
\$user->password = \Illuminate\Support\Facades\Hash::make(
    env('FILAMENT_ADMIN_PASSWORD')
);

\$user->save();
"
fi

php artisan optimize:clear

if [ "${REPORTFLOW_OPTIMIZE:-true}" = "true" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
fi

exec "$@"