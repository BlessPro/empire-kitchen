## Empire Kitchen — Deployment Guide

This project is Laravel 12 with Vite. Keep `.env` off Git. Run everything from the project root (`empire-kitchen/empire-kitchen`).

### 1) Server prep
- PHP 8.2+, Composer, Node 18+ (with `pdo_pgsql`/PostgreSQL client libraries installed).
- PostgreSQL reachable with a database and user created.
- Web user must write to `storage/` and `bootstrap/cache/`.

### 2) Environment file (server only, never commit)
- Copy `.env.example` to `.env`.
- Set (PostgreSQL):
  - `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://your-domain`
  - Generate `APP_KEY`: `php artisan key:generate`
  - DB creds: `DB_CONNECTION=pgsql`, `DB_HOST/PORT/DATABASE/USERNAME/PASSWORD`, `DB_PORT=5432`, `DB_SSLMODE=prefer|require` (as needed)
  - Mail: `MAIL_MAILER=smtp`, `MAIL_SCHEME=tls`, `MAIL_HOST`, `MAIL_PORT=587`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`
  - Queue/cache/session: `QUEUE_CONNECTION=database`, `CACHE_STORE=database`, `SESSION_DRIVER=database`
  - Pusher: `PUSHER_APP_ID/KEY/SECRET`, `PUSHER_HOST=`, `PUSHER_PORT=443`, `PUSHER_SCHEME=https`, `PUSHER_APP_CLUSTER=mt1`
  - Twilio WhatsApp: `TWILIO_ACCOUNT_SID`, `TWILIO_AUTH_TOKEN`, `TWILIO_WHATSAPP_FROM` (e.g., `whatsapp:+123456789`)

### 3) Install & build
```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

### 4) Optimize app
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan storage:link
```

### 5) Database
```bash
php artisan migrate --force
```

### 6) Processes
- Queue worker (Supervisor/systemd): `php artisan queue:work --tries=3 --max-time=3600`
- Scheduler cron: `* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1`

### 7) Smoke test after deploy
- Homepage loads; auth + password reset email works.
- Invoices/budgets render with assets.
- Follow-up reminders and Twilio/Pusher events fire as expected.

### 8) Security
- Keep `.env` private; rotate secrets if exposed.
- Ensure Git remote is your intended origin.
