# Release Notes

## [Unreleased]

### Added
- **Bulk Approve/Reject** — Checkboxes on pending-by-event page with sticky action bar; bulk approve generates & emails all selected certificates at once; bulk reject sends rejection emails with a shared reason
- **Allow Re-claim** — Admin button on rejected claim detail; resets status to pending, clears rejection data, sends re-open email to user
- **Activity Log** (`/admin/activity-log`) — Full searchable/filterable history of all admin actions (approved, rejected, reset, bulk\_approved, bulk\_rejected, regenerated, resent\_email) with admin name, participant, event, notes, and timestamp
- **Global Search** — Inline search input in both desktop and mobile navbars; searches across all claims by name, email, certificate number, or event
- **Export CSV** — Download button on pending/generated/rejected by-event pages; streams a CSV with name, email, certificate number, status, timestamps, and rejection reason
- **Claim Deadline per Event** — `claim_deadline` (datetime, nullable) field on events; `Event::isClaimOpen()` enforced at both form display and form submission; field in create/edit event forms
- **`AdminActivityLog` model** — `record()` static helper, `action_label` / `action_color` accessors, relationships to `Certificate` and `User`
- **`admin_activity_logs` migration** — New table with FK to users and certificates
- **`add_claim_deadline_to_events` migration** — Adds nullable `claim_deadline` datetime column
- **`CertificateResetToPending` Mailable + email template** — Branded email notifying user their claim was re-opened with step-by-step instructions and track status CTA
- **Rejected by Event page** — Rejected claims grouped and categorized by event, matching the Pending and Generated layout
- **Rejected nav link** — "Rejected" added to admin navbar (desktop & mobile) with active state highlighting
- **Rejected stat card on dashboard** — Dashboard now shows Pending / Generated / Rejected / Events stats
- **"View Rejected" quick action** — Added to dashboard Quick Actions section
- **Pending by Event page** — Pending claims grouped by event with card grid and search
- **404 / 403 / 500 error pages** — Custom branded error pages matching admin theme
- **Custom pagination view** — Replaced default Tailwind paginator with inline-styled view (no Tailwind dependency)
- **Quick-select rejection reason** — "Not found in attendance / not present" preset button on reject form
- **Optional certificate number prefix on events** — Fixed prefix per event; falls back to auto-generated format (`EVT-YEAR-SEQ`)
- **Responsive admin navbar** — Hamburger menu for mobile with slide-down menu and inline search

### Changed
- **Certificate downloads use `unique_key`** — All download URLs now use a UUID `unique_key` instead of `certificate_number` to ensure the correct certificate is always fetched, even when numbers are duplicated
- **Pending page** — Converted from flat table to events grid (grouped by event)
- **Rejected page** — Converted from flat card list to events grid (grouped by event)
- **Admin dashboard** — Added Rejected stat card and View Rejected quick action

### Fixed
- **Reject button not working** — Fixed CSS/JS conflict on Review Claim page; `.hidden` class now properly hides/shows the rejection form
- **Certificate download 404** — Fixed download URLs that used certificate number with slashes in path segments; now uses query param `?key=`
- **Gmail redirect 403** — Fixed URL encoding issue where Gmail rewrote download links causing 403 errors
- **PDF filename error** — Fixed `The filename cannot contain / or \` error caused by slashes in certificate numbers
- **Duplicate certificate number SQL error** — Removed unique constraint on `certificate_number` to allow events with shared prefix sequences
- **Email icon rendering** — Replaced SVG icons in approval email with emoji for better cross-client compatibility
- **Pagination rendering** — Fixed huge SVG chevrons caused by Tailwind classes being applied without Tailwind CSS loaded

---

## [v11.0.0 (2023-02-17)](https://github.com/laravel/laravel/compare/v10.3.2...v11.0.0)

Laravel 11 includes a variety of changes to the application skeleton. Please consult the diff to see what's new.
