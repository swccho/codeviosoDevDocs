# DevDocs — Community Documentation Platform

A Laravel Blade monolith for community documentation. Users create and publish docs; visitors browse and search without logging in.

## Features

- **Public**
  - Browse published documentation
  - Search by title and excerpt
  - Read full doc pages (rich text or markdown, optional cover image)

- **Authenticated**
  - Register / login (session-based)
  - Create, edit, delete docs
  - Rich text editor (Trix) with optional cover image (max 20MB)
  - Draft / Published status with Publish / Unpublish actions
  - My Docs list with filter tabs (All / Drafts / Published) and pagination

- **UI**
  - Modern shadcn-inspired layout (Tailwind CSS)
  - Sticky nav, dashboard sidebar (desktop) and mobile drawer
  - Reusable Blade components: `<x-alert>`, `<x-status-badge>`, `<x-doc-card>`
  - Responsive, accessible forms and flash messages

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Trix (rich text)
- **Database:** MySQL (or SQLite for local)
- **No SPA:** Traditional server-rendered Blade; no API layer

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm (for Vite; optional if using Tailwind CDN)
- MySQL, MariaDB, or SQLite

## Installation

1. **Clone and install PHP dependencies**

   ```bash
   cd documentation.codevioso.com
   composer install
   ```

2. **Environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Configure `.env` (e.g. `DB_CONNECTION`, `DB_DATABASE`, `APP_URL`).

3. **Database**

   ```bash
   php artisan migrate
   ```

4. **Storage link** (for cover images)

   ```bash
   php artisan storage:link
   ```

5. **Frontend assets** (optional; or rely on Tailwind CDN)

   ```bash
   npm install
   npm run build
   ```

   For development: `npm run dev`

## Running the App

```bash
php artisan serve
```

Open `http://localhost:8000`. Use **Register** to create an account, then **Dashboard → My Docs → New Doc** to create documentation.

## Project Structure (high level)

| Area            | Location / Notes                                      |
|-----------------|--------------------------------------------------------|
| Public routes   | `/`, `/docs/{slug}`                                   |
| Auth            | `/login`, `/register`, `AuthController`               |
| Dashboard       | `/dashboard/*`, sidebar layout, `DocController`       |
| Models          | `App\Models\Doc`, `User` (with `docs()` relation)     |
| Policies        | `DocPolicy` (update, delete, publish, unpublish)       |
| Form requests   | `StoreDocRequest`, `UpdateDocRequest`                 |
| Services        | `SlugService` (unique slug generation)                |
| Blade components| `resources/views/components/` (alert, status-badge, doc-card) |
| Layouts         | `layouts/app` (public), `layouts/dashboard` (sidebar)|

## Configuration

- **Cover image size:** Validated in `StoreDocRequest` / `UpdateDocRequest` (e.g. `max:20480` = 20MB).
- **Pagination:** Doc lists use Laravel paginator (default 10 per page).
- **Slug:** Unique per doc; fixed after publish (title can still be edited for display).

## Testing

```bash
composer test
# or
php artisan test
```

See `docs/TESTING_CHECKLIST.md` for a manual testing checklist.

## License

MIT.
