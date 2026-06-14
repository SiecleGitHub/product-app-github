# Product App

A professional Symfony application for managing products, categories, and users with full authentication and email verification.

> Note: this repository is built with Symfony 8.1 and PHP 8.4. It includes a modern Doctrine + MariaDB setup, user registration with email verification, password reset support, and admin/CRUD features.

## Key Features

- Symfony 8.1 / PHP 8.4 application
- MariaDB-compatible database support via Doctrine DBAL
- Doctrine ORM entities for `User`, `Product`, `Category`, and `ResetPasswordRequest`
- Full authentication flow:
    - user registration
    - email verification via `symfonycasts/verify-email-bundle`
    - login/logout
    - password hashing and secure credential handling
    - reset password workflow via `symfonycasts/reset-password-bundle`
- Form types for user registration, product management, category management, and reset password requests
- Doctrine migrations for schema versioning
- Data fixtures for seeded sample data and admin user setup
- EasyAdmin integration for admin backend support
- Twig templates for frontend pages and email content
- Route configuration using Symfony attributes and central controller import

## Project Structure

- `src/Controller/` — application controllers, including `RegistrationController`, `SecurityController`, `ProductController`, `CategoryController`, `ResetPasswordController`, `HomeController`, `EmailTestController`, plus `Admin/` and `Api/` controllers
- `src/Entity/` — Doctrine entities for persistent application state
- `src/Form/` — Symfony form types for user registration and entity editing
- `src/DataFixtures/` — fixture classes used to seed the database
- `config/` — framework, doctrine, security, and routing configuration
- `migrations/` — Doctrine migration classes
- `templates/` — Twig templates for UI and email rendering

## Requirements

- PHP 8.4
- Composer
- MariaDB or MySQL compatible database
- Symfony CLI (recommended for local development)

## Setup

1. Clone the repository:

```bash
git clone <repo-url> product-app-github
cd product-app-github
```

2. Install dependencies:

```bash
composer install
```

3. Configure environment variables:

Create a `.env.local` file from `.env` and set the database and mailer connections.

Example MariaDB settings:

```dotenv
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=10.6&charset=utf8mb4"
MAILER_DSN="smtp://localhost"
APP_SECRET="your_app_secret"
```

4. Create the database:

```bash
bin/console doctrine:database:create
```

5. Run migrations:

```bash
bin/console doctrine:migrations:migrate
```

6. Load fixtures:

```bash
bin/console doctrine:fixtures:load
```

## Running the Application

Start the local web server with Symfony CLI:

```bash
symfony serve
```

Or use the built-in PHP server:

```bash
php -S 127.0.0.1:8000 -t public
```

Then open `http://127.0.0.1:8000` in your browser.

## Authentication and Email Verification

The app includes a secure registration flow that:

- collects user name, email, password, and terms agreement
- hashes passwords using Symfony password hashing
- sends a verification email after registration
- marks the user as verified only after clicking the signed confirmation link

Important routes:

- `/register` — registration page
- `/verify/email` — email confirmation endpoint
- `/login` — login page
- `/logout` — logout route

## Database and Migrations

Doctrine is configured via `config/packages/doctrine.yaml`.

- Uses environment variable `DATABASE_URL` for connection settings
- Entity mapping is auto-configured for `src/Entity`
- Migrations live in `migrations/`

Common migration commands:

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
bin/console doctrine:migrations:status
```

## Fixtures

Seed sample data using Doctrine fixtures. The repository includes fixture classes in `src/DataFixtures/`, such as admin user and product/category seeders.

```bash
bin/console doctrine:fixtures:load
```

## Additional Notes

- Security is configured in `config/packages/security.yaml` with:
    - `form_login`
    - CSRF protection
    - `remember_me`
    - a user provider by email
    - a custom `UserChecker`
- Email verification logic is implemented in `src/Security/EmailVerifier.php`
- Registration form validation is handled in `src/Form/RegistrationFormType.php`
- The project uses Twig for rendering HTML pages and email templates

## Useful Console Commands

- `bin/console debug:router`
- `bin/console debug:config security`
- `bin/console doctrine:schema:validate`
- `bin/console lint:twig templates/`

## License

This repository is currently configured as a proprietary project.
