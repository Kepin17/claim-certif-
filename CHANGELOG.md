# Release Notes

## [Unreleased]

### Added
- **Rejected by Event page** — Rejected claims now grouped and categorized by event, matching the Pending and Generated layout
- **Rejected nav link** — "Rejected" added to admin navbar (desktop & mobile) with active state highlighting
- **Rejected stat card on dashboard** — Dashboard now shows Pending / Generated / Rejected / Events stats
- **"View Rejected" quick action** — Added to dashboard Quick Actions section
- **Pending by Event page** — Pending claims grouped by event with card grid and search
- **404 / 403 / 500 error pages** — Custom branded error pages matching admin theme with proper icons and navigation buttons
- **Custom pagination view** — Replaced default Tailwind paginator with inline-styled view matching the admin design system (no Tailwind dependency)
- **Quick-select rejection reason** — "Not found in attendance / not present" preset button on the reject form
- **Optional certificate number prefix on events** — Admin can set a fixed prefix per event; falls back to auto-generated format (`EVT-YEAR-SEQ`) if not set
- **Responsive admin navbar** — Hamburger menu for mobile with slide-down mobile menu
- **Pagination CSS** — Added comprehensive pagination styles to admin layout

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
