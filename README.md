# Aress CRM (Laravel + Filament)

## Overview
Internal CRM to manage leads, track pipeline status, and view performance metrics. The Filament dashboard is the base landing page for the admin panel.

## Stack Justification
- Laravel: fast CRUD, migrations, validation, authentication, and stable ORM for business logic.
- Filament: rapid admin UI, resources, dashboard widgets, and Livewire-powered interactivity.
- MySQL/PostgreSQL: relational storage with strong consistency for lead lifecycle data.
- Vite: modern asset bundler for fast development and optimized production builds.
- Observers/Events: event-driven architecture for decoupled lead lifecycle logic and automated triggers.
- Job Queue (Laravel Queue): asynchronous task processing for scalable background operations.
- PHPUnit: comprehensive testing framework for reliability and maintainability.

## Features
- Lead CRUD (name, email, phone, company source, status, notes, timestamps)
- Kanban pipeline with drag-and-drop status updates
- Dashboard widgets: total leads, leads per status, conversion rate, monthly lead evolution

## Setup
1. Install dependencies:
   - `composer install`
2. Configure environment:
   - `cp .env.example .env`
   - Update `DB_*` values in `.env`
3. Generate app key:
   - `php artisan key:generate`
4. Run migrations and seed sample data:
   - `php artisan migrate --seed`
5. Start the app:
   - `php artisan serve`

## Access
- Admin panel: `http://localhost:8000/admin`
- Kanban pipeline: `http://localhost:8000/admin/leads/kanban`

## Seeded Test User
- Email: `moncef.elatlassy@gmail.com`
- Password: `moncef.elatlassy`

## Notes
- Lead statuses: New, Contacted, Interested, Negotiation, Won, Lost.
- Conversion rate = Won / total leads.
