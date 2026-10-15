# Production Readiness Checklist

Use this checklist before deploying the Drug Interaction Checker to production.

## Environment

- Set `APP_ENV=production`.
- Set `APP_DEBUG=false`.
- Set `APP_URL` to the real production domain.
- Generate a fresh `APP_KEY` if this is a new production environment.
- Confirm `ADMIN_NAME`, `ADMIN_EMAIL`, and `ADMIN_PASSWORD` are set if you want the seeded admin account created or updated.

## Database

- Create the production database.
- Run `php artisan migrate --force`.
- Run `php artisan db:seed --force` only if you want the seed data in production.
- Confirm the `users`, `drugs`, `interaction_severities`, and `drug_interactions` tables exist.

## Data Review

- Confirm the interaction data is appropriate for the intended educational use. Do not represent it as clinically validated unless that has been independently established.
- Verify the admin account exists and has the correct role.
- Remove or adjust any placeholder references before public release.

## Caching and Optimization

- Run `php artisan config:cache`.
- Run `php artisan route:cache`.
- Run `php artisan view:cache`.
- Run `php artisan event:cache` if events are used later.

## Frontend Assets

- Run `npm install` if dependencies are not already installed.
- Run `npm run build`.
- Confirm the compiled Vite assets are deployed with the application.

## Files and Permissions

- Ensure `storage/` is writable.
- Ensure `bootstrap/cache/` is writable.
- Confirm log files can be created in `storage/logs/`.

## Queue and Background Work

- Confirm the queue driver matches production needs.
- If using queues, confirm a worker or supervisor is running.
- If queues are not used, confirm the default `QUEUE_CONNECTION` is appropriate.

## Security

- Confirm `APP_DEBUG` is off.
- Confirm admin routes are protected by `auth` and `admin`.
- Confirm no real credentials are committed.
- Confirm the clinical disclaimer is visible on the public site.
- Configure a production mail transport through `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_SCHEME`, `MAIL_FROM_ADDRESS`, and `MAIL_FROM_NAME` using protected environment secrets.
- Set `APP_URL` to the public HTTPS domain so verification links are signed for the correct host.
- Run `php artisan migrate --force` to add the per-user interaction-check history table.

## Backup and Recovery

- Back up the database before release.
- Back up the `.env` file securely.
- Confirm you can restore the database if deployment fails.

## Final Verification

- Open the home page.
- Check a known interaction.
- Check a reversed drug order.
- Confirm an unknown pair shows the current database limitation message.
- Sign in as admin.
- Open the admin dashboard.
- Confirm drug and interaction CRUD pages load.
- Confirm the site works on mobile and desktop.

## Deployment Command Sequence

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

