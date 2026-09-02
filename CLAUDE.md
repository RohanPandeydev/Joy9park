# Joy9 Park — Project Reference

WordPress site for **Joy9 Park**, a long-term parking facility near JFK Airport. Local dev via XAMPP. Not a git repository (no `.git` at project root as of 2026-08-26).

## Stack

- **WordPress core** at project root (`wp-admin/`, `wp-includes/`), standard install.
- **Active theme**: `wp-content/themes/joy9park` — custom theme, originally scaffolded from an `_s`/underscores-style boilerplate (class names like `class-twentytwenty-walker-comment.php`, `class-wp-bootstrap-navwalker.php` are leftover from that lineage) and built out from a static HTML template.
- **Static source template**: `html/` at project root — the original designer-delivered static HTML/CSS/JS (Bootstrap 5 + Owl Carousel + Font Awesome via CDN). This is the _reference design_, not part of the live site. When in doubt about what a section should look like, this folder is the source of truth for markup/styling intent.
- **Key plugins**:
  - `secure-custom-fields` — this is ACF (Advanced Custom Fields) core, distributed by WordPress.org after the ACF-core acquisition. All `acf_*`, `get_field()`, `have_rows()` etc. APIs work exactly like classic ACF. This is the entire dynamic-content engine for the theme.
  - `contact-form-7` (+ `contact-form-7-honeypot`, `jquery-validation-for-contact-form-7`) — powers the booking/contact forms embedded via `[contact-form-7 id="..."]` shortcodes stored in ACF text fields.

## Dynamic content architecture (ACF + Local JSON)

Every piece of editable content on the site (front page, all inner pages, header, footer, global settings) is backed by an **ACF field group**, and every field group is **exported as Local JSON** in `wp-content/themes/joy9park/acf-json/`. This is what makes it "syncable": whenever a field group is created/edited in wp-admin (Custom Fields → Field Groups), ACF/SCF auto-writes the matching JSON file there, and any environment that has that file will show a **"Sync available"** action in wp-admin to pull it in. Do not hand-edit a group that's about to be edited in wp-admin — pull the current JSON state first (files are user-editable both ways: some groups here were authored directly in JSON, others were created in wp-admin and got auto-exported in ACF's more verbose format; both are valid and interchangeable).

**Full technical breakdown of every field group, every field, and every template**: see [`wp-content/themes/joy9park/ACF-REFERENCE.md`](wp-content/themes/joy9park/ACF-REFERENCE.md). Read that file before touching any template or field group.

## Quick map: templates ↔ field groups

| Template file                         | Template Name (WP)                                           | Field group JSON                             |
| ------------------------------------- | ------------------------------------------------------------ | -------------------------------------------- |
| `front-page.php`                      | _(automatic — static front page)_                            | `group_front_page_content.json`              |
| `page-templates/about.php`            | About                                                        | `group_page_about.json`                      |
| `page-templates/direction.php`        | Direction                                                    | `group_page_direction.json`                  |
| `page-templates/reserver-spot.php`    | Reserve a Spot                                               | `group_page_reserve_spot.json`               |
| `page-templates/testimonial.php`      | Testimonials                                                 | `group_page_testimonials.json`               |
| `page-templates/testimonial-list.php` | Testimonial List                                             | `group_page_testimonial_list.json`           |
| `page-templates/privacy-policy.php`   | Privacy Policy                                               | `group_page_privacy_policy.json`             |
| `page-templates/terms-condition.php`  | T & C                                                        | `group_page_terms_condition.json`            |
| `header.php` / `footer.php`           | _(always loaded)_                                            | `group_6a8c696ed6804.json` ("Header/Footer") |
| _(site-wide)_                         | ACF Options Page "Theme Settings" (`theme-general-settings`) | `group_global_settings.json`                 |

Each inner-page field group is a **single tabbed group** (one tab per visual section) rather than one group per section — this keeps wp-admin's Custom Fields screen from being cluttered with dozens of boxes stacked on one page. Follow this pattern for any new page.

## Helper functions (`inc/custom-functions.php`)

- `jp_field( $selector, $fallback = '', $post_id = false )` — wraps `get_field()`; returns `$fallback` if the field is empty/unset. Used everywhere instead of raw `get_field()` so pages still render the original static copy before an editor has saved anything in wp-admin. Pass `'option'` as `$post_id` for fields on the Theme Settings options page.
- `jp_img( $selector, $fallback_path, $post_id = false )` — same idea for image fields (`return_format: url`); falls back to a path inside the theme (`get_template_directory_uri() . $fallback_path`).
- `jp_template_page_url( $template_filename, $fallback = '#' )` — resolves the permalink of whichever published Page has `$template_filename` (e.g. `'page-templates/reserver-spot.php'`) assigned as its template. Used for cross-page buttons ("Reserve a Spot", "Show More" → testimonials list, etc.) so links work correctly once real Pages are created and assigned templates in wp-admin, without hardcoding slugs.

## Known gaps / TODO (as of 2026-08-26)

- **`template-parts/common-section/common-banner.php` is an empty stub.** It's called by About, Direction, Reserve a Spot, Testimonials, Privacy Policy and T&C templates via `get_template_part()`, but currently renders nothing. The CSS already has a ready-to-use `.inner-banner` / `.inner-banner-title` block (style.css, section 17) designed for a plain title banner (no background-image support, just two decorative corner circles) — implementing this only needs `the_title()` inside `<h1 class="inner-banner-title">`, no new ACF fields required. This was scoped out of the last session at the user's direction; revisit when asked.
- **Testimonials are duplicated data, not shared.** The Testimonials page (slider) and Testimonial List page (grid) each have their own independent ACF repeater (`testimonials` vs `testimonial_list_items`) with overlapping default content. If the business wants one edit to update both places, that would mean migrating to a `testimonial` custom post type + `WP_Query` instead of two repeaters — a deliberate choice was made to keep it ACF-only/simple for now.
- **`front-page.php`'s CTA buttons use ACF `link` fields with static default URLs** (e.g. pricing cards default to `"reserver-spot.html"`) rather than the `jp_template_page_url()` helper introduced later for the inner pages. This is inconsistent but was left as-is to avoid churn on already-shipped work; worth reconciling in a future pass if cross-page links on the home page turn out to be stale.
- Some inner-page forms were upgraded post-handoff (directly in wp-admin) from static non-functional `<form>` markup to real Contact Form 7 shortcodes stored in ACF fields — e.g. `direction.php` → `contact_form_shortcode` (CF7 id `7406346`), `reserver-spot.php` → `booking_form_shortcode`. Check current CF7 form IDs in wp-admin (Contact → Contact Forms) before assuming an ID in a JSON default is still valid.

## Change Safety

This project is not currently tracked by Git.

Before making significant or multi-file changes:

- Inspect the relevant files before modifying them.
- Clearly identify which files will be changed.
- Prefer minimal, targeted changes.
- Do not perform broad refactors unless explicitly requested.
- Preserve existing functionality outside the requested scope.
- After changes, verify the affected functionality where practical.
- For high-risk changes, recommend or create a backup/copy strategy before modification when appropriate.

Avoid modifying WordPress core files unless explicitly instructed.

Primary custom development should normally occur within:

- `wp-content/themes/joy9park/`
- Project-specific plugin code, if applicable

Do not modify files inside `wp-admin/` or `wp-includes/` unless explicitly requested and the reason is understood.

## Working With Existing Code

Before implementing a fix or feature:

1. Inspect the relevant existing implementation.
2. Identify the actual data flow and dependencies.
3. Check related templates, ACF fields, helper functions, and JavaScript where applicable.
4. Prefer extending existing project patterns over introducing unnecessary new patterns.
5. Do not duplicate functionality that already exists elsewhere in the theme.

For debugging:

UNDERSTAND
→ REPRODUCE
→ IDENTIFY ROOT CAUSE
→ MAKE TARGETED CHANGE
→ VERIFY
