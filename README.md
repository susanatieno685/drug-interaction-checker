# Drug Interaction Checker

A Laravel 11 application for checking drug-drug interactions, reviewing clinical details, and managing interaction data through a protected admin area.

## Version 1 Features

- Public home page with two-drug interaction search
- Interaction result page with severity and clinical details
- Searchable drug selectors
- Basic authentication
- Admin dashboard
- Admin drug CRUD
- Admin interaction CRUD
- Seeded drugs, severities, and interaction examples
- Responsive Bootstrap 5 interface

## Technology Stack

- Laravel 11
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

For the seeded super admin account, add these variables:

```env
ADMIN_NAME=Susan Atieno
ADMIN_EMAIL=susanatieno@gmail.com
ADMIN_PASSWORD=your-secure-password
```

If `ADMIN_PASSWORD` is missing, the admin seeder keeps the existing password when updating the admin record.

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
- Clinical content must be reviewed by a pharmacist before use in patient care.
- Interaction data should not be treated as a substitute for professional clinical judgment.

## Clinical Disclaimer

This application is a clinical support tool. It is not a substitute for pharmacist review, prescriber judgment, or local clinical policy. Always verify interaction information before using it in patient care.

## Future Improvements

- More interaction records with pharmacist-reviewed references
- Better search and filtering tools
- Additional audit fields for clinical review workflow
- Production deployment checklist
- Optional screenshots and user guide updates

