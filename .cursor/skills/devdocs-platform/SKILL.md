---
name: devdocs-platform
description: Builds and maintains the DevDocs community documentation platform (Laravel 12, PHP 8.2, Blade monolith). Use when implementing web routes, Blade views, authentication, file uploads, search, policies, migrations, or any backend feature for the documentation platform.
---

# DevDocs Platform — Blade Monolith

When building or modifying the DevDocs documentation platform, follow these patterns.

**Stack:** Laravel 12, PHP 8.2, Blade (server-rendered), session auth, Tailwind CSS, Alpine.js (light), MySQL or PostgreSQL. This is **not** API-first.

---

## When to Use This Skill

- Adding or modifying web routes
- Creating or editing Blade views
- Implementing CRUD for docs
- Session-based authentication
- File uploads (cover images)
- Search and filtering
- Policies and authorization
- Migrations and database design
- Pagination and performance

---

## Architecture

1. **Server-rendered views** — Controllers return `view()`, not JSON.
2. **Thin controllers** — Business logic in Services when needed.
3. **Form Requests** — All validation in Form Request classes; never inline.
4. **Policies** — All authorization via Policies (e.g., `DocPolicy`).
5. **Public vs Auth** — Public routes no login; dashboard behind `auth` middleware.
6. **Slug URLs** — Public docs use `/docs/{slug}`.

---

## Authentication & Security

- Laravel session authentication only (no Sanctum/token auth).
- `auth` middleware on dashboard routes.
- All forms: `@csrf`; updates/deletes: `@method('PUT')` / `@method('DELETE')`.
- Laravel password hashing (default).
- Policy: user can update/delete only their own docs.

---

## Database & Slug Design

### Docs table (minimum)

- id, user_id (FK), title, slug (unique), excerpt (nullable), content (markdown), cover_path (nullable), status (enum: draft, published), published_at (nullable), timestamps

### Slug rules

- Generate with `Str::slug($title)`; ensure uniqueness (append suffix on conflict).
- Slug must **not** change after publish.
- Unique index on `slug`.

### Indexes

- user_id, status, unique slug, composite (status + updated_at) for listing.

---

## Routing (web.php)

### Public

- `GET /` → Home (hero search + latest published docs)
- `GET /docs/{slug}` → Show published doc
- Optional: `GET /ajax/docs?search=...` → lightweight JSON for hero search

### Auth

Use Laravel default session auth scaffolding.

### Dashboard (auth middleware)

- `GET /dashboard`
- `GET /dashboard/docs` | `GET /dashboard/docs/create` | `POST /dashboard/docs`
- `GET /dashboard/docs/{doc}/edit` | `PUT /dashboard/docs/{doc}` | `DELETE /dashboard/docs/{doc}`
- `POST /dashboard/docs/{doc}/publish` | `POST /dashboard/docs/{doc}/unpublish`

---

## Validation (Form Requests)

### StoreDocRequest

- title: required, string, min:5, max:160
- content: required, string, min:30
- excerpt: nullable, string, max:300
- status: required, in:draft,published
- cover_image: nullable, image, max:2048

### UpdateDocRequest

- Same fields; allow nullable where appropriate.
- Prevent slug change if doc is already published.

Redirect back with errors and old input on failure.

---

## File Handling

- Use `Storage` facade; store under `storage/app/public/docs/covers`.
- Run `php artisan storage:link`.
- Save only relative path in DB.
- Delete old file when replacing cover.
- Unique filenames (e.g. UUID or timestamp).

---

## Search (Blade-based)

### MVP

- No search → latest published docs.
- With search → filter by title and excerpt; always `status = published`.
- Use `LIKE` with bindings; paginate.

Optional: Alpine.js hero search via AJAX endpoint; JSON minimal (id, title, slug).

---

## Pagination

- Use `->paginate(10)` for lists.
- Render with `{{ $docs->links() }}`.
- Never unbounded `get()` on large lists.

---

## Blade Standards

- Layouts: `layouts/app.blade.php`, `layouts/dashboard.blade.php`.
- Reusable UI as components (e.g. `<x-doc-card />`).
- Flash: `session()->flash('success', 'Doc created successfully.')`.
- Clean Tailwind markup.

---

## Performance

- Use `select()` to omit large `content` in list views.
- Eager load (`with('user')`) when needed; avoid N+1.
- Always paginate.

---

## Testing

Feature tests for:

- Register/login
- Create doc
- Public page shows only published docs
- User cannot edit another user’s doc
- Slug uniqueness

Use Factories and `RefreshDatabase`.

Run: `php artisan test`

---

## MVP Checklist

Before marking a feature complete:

- [ ] Routes defined in `web.php`
- [ ] Controller thin
- [ ] Form Request used
- [ ] Policy enforced
- [ ] View returns Blade template
- [ ] Pagination applied
- [ ] Slug unique
- [ ] Only published visible publicly
- [ ] File upload validated and stored
- [ ] Flash messages working

---

## Advanced (Post-MVP)

- Caching public doc lists
- Full-text search
- Queues for image processing
- Admin moderation panel
- Version history for docs
- Rate limiting login

---

## Architecture Reminder

This is a clean Laravel Blade monolith.

- No API-first mindset.
- No Sanctum.
- No JSON resource layers.
- No SPA separation.

Everything lives in one Laravel application: routes, controllers, Blade views, models, policies, storage.

---

## Additional detail

For extended guidance (routing, auth, search, testing, deployment), see [reference.md](reference.md).
