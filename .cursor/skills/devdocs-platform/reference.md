# DevDocs Platform — Reference

Extended guidance for the Blade monolith. Main rules are in [SKILL.md](SKILL.md).

---

## 1. Core Backend (Laravel 12)

- **MVC** — Controllers thin; models for data; Services for business logic (slug generation, file handling).
- **Routing** — `routes/web.php`; group by middleware (public vs `auth`).
- **Models & Eloquent** — Relationships, `$fillable`/`$guarded`, accessors/mutators as needed.
- **Migrations** — Schema, foreign keys, indexes, enums for status.
- **Seeders & Factories** — For local and test data.
- **Middleware** — `auth` for dashboard; no Sanctum.
- **Config** — Use `config()` and `.env`; no hardcoded secrets.

---

## 2. Server-Rendered Responses

- **Views** — Controllers return `view()`, never JSON for main flows.
- **Redirects** — POST/PUT/DELETE → `redirect()->route()` with session flash.
- **Forms** — `@csrf`; `@method('PUT')` / `@method('DELETE')` where needed.
- **Flash** — `session()->flash('success', '...')` (or `error`, `warning`).

---

## 3. Authentication & Security

- **Session auth** — Laravel built-in; no token/API auth.
- **Passwords** — Bcrypt via Laravel hashing.
- **Policies** — Owner-only edit/delete; public controllers enforce `status = published`.
- **Form Requests** — All validation in request classes.
- **XSS/SQL** — Escape in Blade; use Eloquent/query builder (no raw user input in SQL).

---

## 4. Database Design

- **Relations** — Foreign keys, cascade deletes where appropriate.
- **Indexes** — user_id, status, unique slug; composite for listing (e.g. status + updated_at).
- **Enums** — status (draft, published) in DB and code.
- **Slugs** — Unique; generate in Service; do not change after publish.

---

## 5. File Handling

- **Uploads** — `Storage` facade; `public` disk; `storage:link` for public URLs.
- **Path** — Store under `storage/app/public/docs/covers`; save relative path in DB.
- **Validation** — image type, max size in Form Request.
- **Replacement** — Delete old file when replacing cover; then store new with unique name.

---

## 6. Search

- **MVP** — `LIKE` with bindings on title/excerpt; `when()` for optional search; paginate.
- **Optional AJAX** — Minimal JSON (id, title, slug) for hero search; still enforce published.

---

## 7. Performance

- **Eager loading** — `with('user')` to avoid N+1.
- **Select** — Exclude `content` on list queries.
- **Indexes** — Match filter and sort columns.
- **Pagination** — Always use `paginate()`; cap page size.

---

## 8. Testing

- **Feature tests** — Hit web routes; assert status, redirects, view data, auth.
- **Policies** — Test allow/deny for owner vs non-owner, draft vs published.
- **Factories** — User, Doc; use `RefreshDatabase`.
- Run: `php artisan test`

---

## 9. Deployment

- **Environment** — `.env`; `APP_DEBUG=false` in production.
- **Storage** — Permissions for `storage` and `bootstrap/cache`; run `storage:link`.
- **Migrations** — Run in deployment; backup before.

---

## 10. Security Checklist

- Validate all inputs (Form Requests).
- Restrict file type and size for uploads.
- Mass assignment: `$fillable` or `$guarded`.
- Dashboard and mutating actions behind `auth` and Policy checks.
