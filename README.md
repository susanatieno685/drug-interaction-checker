# DawaCross

A Laravel 12 application for checking drug-drug interactions, reviewing educational interaction information, and managing interaction data through a protected admin area.

## Version 1 Features

- Public home page with two-drug interaction search
- Interaction result page with severity and clinical details
- Searchable drug selectors
- Authentication with email verification
- Admin dashboard
- Admin drug CRUD
- Admin interaction CRUD
- Seeded drugs, severities, and interaction examples
- Responsive Bootstrap 5 interface

## Technology Stack

- Laravel 12
- PHP 8.x
- Bootstrap 5
- Blade templates
- Vite for frontend assets
- PHPUnit for automated tests

## Installation

```bash
composer install
npm install
```

## Environment Setup

Create or update your `.env` file with the usual Laravel settings.

For production email verification, configure `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_SCHEME`, `MAIL_FROM_ADDRESS`, and `MAIL_FROM_NAME` using credentials supplied by your email provider. Keep credentials in deployment secrets or the server's protected environment; do not commit them. The `log` mailer is suitable only for local development. Also set a public `APP_URL` so verification links use the correct HTTPS domain.

For the optional seeded super admin account, add these variables in the protected deployment environment:

```env
ADMIN_NAME=Susan Atieno
ADMIN_EMAIL=susanatieno@gmail.com
ADMIN_PASSWORD=your-secure-password
```

The admin seeder does not create an admin if these values are absent. If `ADMIN_PASSWORD` is missing, the admin seeder keeps an existing password when updating the admin record.

## Database Setup

Run migrations:

```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

This seeds:

- interaction severities
- common drugs
- sample interaction records
- an admin user
- a test user record

## Running Locally

```bash
php artisan serve
npm run dev
```

Open the app in your browser and use the home page to check interactions.

## Admin Access

The admin area is protected by `auth` and `admin` middleware.

Seeded admin account:

- Name: Susan Atieno
- Email: susanatieno@gmail.com

## Test Commands

Run the full test suite:

```bash
php artisan test
```

Run targeted tests:

```bash
php artisan test --filter=DrugPairNormalizerTest
php artisan test --filter=PublicInteractionCheckerTest
php artisan test --filter=AdminAuthorizationTest
php artisan test --filter=AdminDrugCrudTest
php artisan test --filter=AdminInteractionCrudTest
```

## Screenshots

Add screenshots here for:

- Public home page
- Interaction results page
- Admin dashboard
- Drug management
- Interaction management

## Limitations

- The application only checks drug pairs that exist in the local database.
- A missing result means no matching record was found in the current database, not that the combination is medically safe.
- DawaCross is for educational and informational purposes only. It is not intended to diagnose, treat, cure, or prevent disease and is not a substitute for professional medical judgment or individualized healthcare advice. Results may not cover every interaction, patient-specific factor, contraindication, or clinical circumstance. Do not start, stop, or change medication based solely on these results; consult a qualified healthcare professional.

## Clinical Disclaimer

The database content has not been independently established as clinically validated. A missing match means only that the current database has no matching record; it does not mean a combination is safe.

## Future Improvements

- More interaction records with pharmacist-reviewed references
- Better search and filtering tools
- Additional audit fields for clinical review workflow
- Production deployment checklist
- Optional screenshots and user guide updates
