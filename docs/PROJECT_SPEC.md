# 📘 Project Documentation

# CodeviosoDevDocs – Community Documentation Platform

---

# 1. Project Overview

## 1.1 Project Name

**CodeviosoDevDocs**

## 1.2 Purpose

CodeviosoDevDocs is a web-based community documentation platform where:

* Registered users can create and publish technical documentation.
* Visitors can search, browse, and read documentation without logging in.
* The homepage features a large hero search bar with live search results displayed below it.

---

# 2. System Architecture

## 2.1 Portal Structure

The system consists of **two main portals**:

### 🔹 Public Portal (No Authentication Required)

* View documentation
* Search documentation
* Filter by tags/categories
* Read full documentation pages

### 🔹 User Portal (Authentication Required)

* Register / Login
* Create documentation
* Edit documentation
* Upload cover images
* Publish / Unpublish
* Manage personal documentation

---

# 3. Core Features

## 3.1 Authentication

* User registration
* User login/logout
* Password hashing
* Optional: Email verification

---

## 3.2 Documentation Management

### Create Documentation

Users can:

* Add title
* Upload cover image
* Add tags
* Write content (Markdown or Rich Text)
* Save as Draft
* Publish

### Edit Documentation

* Update title/content
* Change cover image
* Update tags
* Change publish status

### Delete Documentation

* Soft delete recommended

---

## 3.3 Public Documentation Viewing

Visitors can:

* Browse latest documentation
* Search by keyword
* Filter by tag/category
* Open documentation detail page

---

## 3.4 Search System (Hero Search)

### Homepage Layout

```
-----------------------------------
| HERO SECTION                    |
| "Search Documentation..."       |
| [ Large Search Input ]          |
-----------------------------------
| Search Results                  |
| Card 1                          |
| Card 2                          |
| Card 3                          |
-----------------------------------
```

### Search Behavior

* When search input is empty → show latest documents
* When user types → fetch results dynamically
* Search matches:

  * title
  * tags
  * content (optional advanced search)

---

# 4. Functional Requirements

## 4.1 User Registration

* Name (required)
* Email (unique, required)
* Password (min 8 characters)

## 4.2 Documentation Creation

Required fields:

* Title
* Content
* Status (draft/published)

Optional:

* Cover image
* Tags

## 4.3 Public Viewing

* Only documents with status = `published` are visible publicly.

---

# 5. Database Design

## 5.1 Users Table

| Field      | Type      | Description |
| ---------- | --------- | ----------- |
| id         | bigint    | Primary key |
| name       | string    | User name   |
| email      | string    | Unique      |
| password   | string    | Hashed      |
| created_at | timestamp |             |
| updated_at | timestamp |             |

---

## 5.2 Documents Table

| Field       | Type      | Description     |
| ----------- | --------- | --------------- |
| id          | bigint    | Primary key     |
| user_id     | bigint    | Author          |
| title       | string    | Document title  |
| slug        | string    | URL slug        |
| excerpt     | text      | Short preview   |
| content     | longtext  | Markdown/HTML   |
| cover_image | string    | File path       |
| status      | enum      | draft/published |
| views       | integer   | View counter    |
| created_at  | timestamp |                 |
| updated_at  | timestamp |                 |

---

## 5.3 Tags Table

| Field | Type   |
| ----- | ------ |
| id    | bigint |
| name  | string |
| slug  | string |

---

## 5.4 Document_Tag (Pivot Table)

| Field       | Type   |
| ----------- | ------ |
| document_id | bigint |
| tag_id      | bigint |

---

# 6. API Structure (REST Example)

## Public Endpoints

```
GET    /api/docs                → list published docs
GET    /api/docs/{slug}         → doc details
GET    /api/docs?search=term    → search docs
GET    /api/tags                → list tags
```

---

## Authenticated Endpoints

```
POST   /api/register
POST   /api/login
POST   /api/logout

GET    /api/user/docs
POST   /api/user/docs
PUT    /api/user/docs/{id}
DELETE /api/user/docs/{id}
```

---

# 7. User Flow

## 7.1 Public User Flow

1. Visitor opens homepage
2. Sees hero search
3. Types "flutter"
4. Results appear below
5. Clicks result
6. Reads full documentation

---

## 7.2 Authenticated User Flow

1. User registers/logs in
2. Enters dashboard
3. Clicks "Create Documentation"
4. Adds content + cover image
5. Publishes
6. Document becomes visible publicly

---

# 8. Non-Functional Requirements

## Performance

* Search results must load in < 500ms
* Images should be optimized

## Security

* Password hashing (bcrypt/argon)
* CSRF protection
* XSS protection
* Only authors can edit their docs

## SEO

* Slug-based URLs
* Dynamic meta title + description
* OpenGraph image (cover image)

Example:

```
/docs/how-to-install-flutter-on-windows
```

---

# 9. Future Enhancements

* Likes / Upvotes
* Comments system
* Bookmarking
* User following system
* Admin moderation panel
* Full-text search (Elasticsearch / Meilisearch)
* Dark mode
* Documentation versioning

---

# 10. Recommended Tech Stack

### Backend

* Laravel (API)
* JWT or Sanctum for auth

### Frontend

* Nuxt 3 (SEO friendly)
  OR
* Next.js

### Storage

* Local (MVP)
* AWS S3 (Production)

### Database

* PostgreSQL or MySQL

---

# 11. Project Folder Structure (Example)

### Backend (Laravel)

```
app/
  Models/
  Http/
    Controllers/
    Requests/
database/
routes/
  api.php
```

### Frontend (Nuxt)

```
pages/
  index.vue
  docs/[slug].vue
  dashboard/
components/
composables/
```

---

# 12. MVP Scope

✅ Auth
✅ Create documentation
✅ Upload cover image
✅ Public listing
✅ Hero search
✅ SEO-friendly URLs

---

# 13. Project Goal Summary

DevDocs is a:

* Clean
* Scalable
* SEO-friendly
* Community-driven
* Documentation publishing platform

Where:

* Users create knowledge
* Public users search and learn
* Search is the main UX element
