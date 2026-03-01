# Manual Testing Checklist — Backend MVP

Verify these scenarios before marking backend complete.

## Visibility & SEO

- [ ] **Create draft** → Doc not visible on public homepage or at `/docs/{slug}`.
- [ ] **Publish doc** → Doc appears on homepage and is viewable at `/docs/{slug}`.
- [ ] **Unpublish** → Doc no longer visible publicly; 404 at `/docs/{slug}`.
- [ ] **Slug stability** → After publish, editing title does not change the URL (slug unchanged).

## Authorization

- [ ] **Edit another user's doc** → Blocked (403 or 404). Use two accounts; try to open `/dashboard/docs/{id}/edit` for a doc owned by the other user.
- [ ] **Dashboard without login** → Redirect to login.

## File & Data

- [ ] **Replace cover image** → Old file removed from storage; new image displays.
- [ ] **Slug uniqueness** → Creating two docs with the same title yields different slugs (e.g. `my-title`, `my-title-2`).

## UX

- [ ] **Flash messages** → Success shown after create, update, delete, publish, unpublish.
- [ ] **Pagination** → Home and dashboard doc lists show pagination links when there are enough items.
- [ ] **Validation** → Invalid form data redirects back with errors and old input.

## Security

- [ ] **Public routes** → Only published docs; no drafts leak.
- [ ] **Mass assignment** → `user_id` cannot be set via request (test by attempting to pass `user_id` in create/update).

Run: `php artisan migrate` before testing. Ensure `php artisan storage:link` has been run for cover images.
