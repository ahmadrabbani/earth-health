# GreenLens

GreenLens is a Laravel app for location-based urban greening assessments. It supports:

- address search with Google Maps
- AQI lookup with Google Air Quality API
- local AQI display when available
- Miyawaki forest opportunity suggestions near the selected location
- Gemini-powered recommendation summaries

## Setup

1. Install dependencies:
```bash
composer install
```

2. Create the environment file:
```bash
cp .env.example .env
php artisan key:generate
```

3. Configure these variables in `.env`:
```env
GOOGLE_MAPS_API_KEY=
GOOGLE_AIR_QUALITY_API_KEY=
GEMINI_API_KEY=
GEMINI_MODEL=gemini-2.5-flash
```

4. Configure the database.

For SQLite:
```bash
touch database/database.sqlite
```

Then set:
```env
DB_CONNECTION=sqlite
```

Or use MySQL and set:
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=earth-health
DB_USERNAME=root
DB_PASSWORD=root
```

5. Run migrations:
```bash
php artisan migrate
```

6. Start the app:
```bash
php artisan serve
```

Open:
```text
http://127.0.0.1:8000
```

## Notes

- `.env`, `vendor`, compiled views, logs, and local SQLite files are ignored by git.
- A fresh assessment is required to fetch updated AQI or nearby Miyawaki suggestions after code changes.
