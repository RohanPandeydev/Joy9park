# ACF Field Group Reference — Joy9 Park Theme

Detailed reference for every ACF field group in `acf-json/`, what template renders it, and the exact field names available to `get_field()` / `have_rows()`. See the project-root `CLAUDE.md` for the high-level architecture summary.

General conventions used throughout:
- Every group uses **Local JSON** (`acf-json/*.json`), synced via wp-admin → Custom Fields → Field Groups → "Sync available".
- Multi-section pages use **one field group with `tab` fields** (left placement) rather than several groups on one location, to keep the admin edit screen tidy.
- Every text/image render goes through `jp_field()` / `jp_img()` (see `inc/custom-functions.php`) with a **fallback matching the original static design copy**, so a page still looks correct even before an editor has saved anything for that field.
- Repeaters follow the same pattern: template code has a `*_default` PHP array matching the field group's `default_value`, and falls back to looping over that array when `have_rows()` returns false.
- Image fields return a plain **URL** (`"return_format": "url"`) unless noted otherwise.
- "Link"-style buttons where the destination is a *sibling WordPress page* (not yet guaranteed to exist) are modeled as a plain **text field for the label only** — the actual `href` is computed at render time via `jp_template_page_url()`. Buttons that stay on the same page (anchors like `#directions`) or point somewhere genuinely arbitrary use ACF's `link` field type instead.

---

## `group_global_settings.json` — Global Site Settings

**Location:** ACF Options Page, slug `theme-general-settings` (registered in `functions.php` via `acf_add_options_page()`, menu title "Theme Settings"). Read anywhere with `get_field( $name, 'option' )`.

| Field name | Type | Notes |
|---|---|---|
| `global_phone_button` | link | `{title, url, target}`. Default: "Call (516) 849 - 3413" → `tel:+15168493413`. Used on the front page hero, shuttle-glance, and ready-to-park sections. |
| `global_logo_white` | image (url) | White-on-dark logo, reused on hero / shuttle-glance / ads-banner backgrounds. |
| `global_logo_secondary` | image (url) | The secondary/"logo2" mark used as the floating logo in Contact sections. |
| `global_address` | textarea (`new_lines: br`) | Default: `145-25 155TH STREET / JAMAICA NY 11434`. |
| `global_map_embed_url` | url | Default Google Maps embed src, reused by front page and About page contact sections (Direction page has its own zoomed-in override, see below). |

**Consumers:** `front-page.php`, `page-templates/about.php`, `page-templates/direction.php` (address only — has its own map override), `page-templates/privacy-policy.php` (address only).

---

## `group_6a8c696ed6804.json` — Header/Footer

**Location:** Options Page, `theme-general-settings` (same options page as Global Site Settings, but created as a separate group directly in wp-admin — hence the auto-generated key name instead of a human-readable one; leave it as ACF-authored, don't rename the key).

Tabs: **Header**, **Footer**.

| Field name | Type | Used in |
|---|---|---|
| `header_button` | link | `header.php` — CTA button in the nav bar. |
| `footer_logo_1` / `footer_logo_2` | image (**array** return format — `['url'=>..,'alt'=>..]`, unlike most other image fields in this theme which return a plain URL) | `footer.php` footer logo lockup. |
| `footer_info` | textarea | `footer.php` about blurb (rendered with `wp_kses_post`). |
| `social_list` | repeater: `social_platform` (select: instagram/twitter/facebook/linkedin/youtube/tiktok/google/whatsapp), `social_url` (url) | `footer.php` social icons — platform mapped to a Font Awesome class in a lookup array in `footer.php`. |
| `contact_list` | repeater: `contact_icons` (select: phone/email/location/worktime), `contact_info` (text) | `footer.php` contact column. **Position-dependent**: `footer.php` hardcodes row 1 = maps link, row 2 = tel:, row 3 = mailto: by loop index, not by the icon value — keep row order intact if editing in wp-admin. |

⚠️ This group predates the Local JSON convention used elsewhere in this theme — it was reverse-engineered from `get_field()` calls already present in `header.php`/`footer.php` that had no corresponding field group at all until it was created in wp-admin. If you add more header/footer fields, prefer editing this group directly in wp-admin (it will re-export automatically) over hand-editing the JSON, since ACF's own export format (defaults for every possible setting) is already established here.

---

## `group_front_page_content.json` — Front Page Content

**Location:** `page_type == front_page` (i.e. whatever Page is set as the static front page in Settings → Reading — works regardless of that page's title/slug). **Template:** `front-page.php`.

One group, 9 tabs (in display order):

1. **Hero Banner** — `hero_bg_image`, `hero_badge_text`, `hero_title` (textarea, `\n` → `<br>`), `hero_text`, `hero_secondary_btn` (link, default `#directions`), `hero_features` (repeater: `text` — 3 checklist items), `hero_form_title`, `hero_form_shortcode_id` (full `[contact-form-7 ...]` shortcode text, `do_shortcode()`'d directly).
2. **Marquee Slider** — `slider_ads_items` (repeater: `text`, `is_hollow` true_false — alternating solid/outline marquee style).
3. **Why Choose Us** — `wcu_eyebrow`, `wcu_title`, `wcu_subtitle`, `wcu_description`, `wcu_cards` (repeater: `icon` image, `title`, `text` — 4 cards; card 1 gets an `.active` class hardcoded by loop position, not by data).
4. **Shuttle at a Glance** — `shuttle_bg_image`, `shuttle_title`, `shuttle_subtitle`, `shuttle_glance_title`, `shuttle_stats` (repeater: `number`, `label` — 4 stat boxes), `shuttle_note_text`. Phone button reuses `global_phone_button`.
5. **Pricing** — `pricing_bg_image`, `pricing_eyebrow`, `pricing_title`, `pricing_description`, `pricing_cards` (repeater: `image`, `vehicle_type`, `rate`, `button` link — **default button URL is the stale `"reserver-spot.html"`**, see Known Gaps in root `CLAUDE.md`).
6. **Free Shuttle Service** — `fss_bg_image`, `fss_badge_text`, `fss_title`, `fss_text`, `fss_features` (repeater: `title`, `text` — 3 items), `fss_learn_more_btn` (link), `fss_logo_primary`/`fss_logo_secondary` (images), `fss_logo_link` (url), `fss_book_now_btn` (link).
7. **Ready to Park** — `rtp_title`, `rtp_text`, `rtp_primary_btn` (link, default `#booking-form`), `rtp_trust_list` (repeater: `text` — 3 badges; icons for these are hardcoded per-position in the template: shield/clock/rotate-left, not stored as data).
8. **Ads Banner** — `ads_bnr_bg_image`, `ads_bnr_title`. Logo reuses `global_logo_white`.
9. **Contact & Directions** — `contact_eyebrow`, `contact_title`, `contact_text`, `contact_address_title`, `contact_direction_steps` (repeater: `title`, `text` — 2 steps). Map URL and address text reuse `global_map_embed_url` / `global_address`.

---

## `group_page_about.json` — Page: About

**Location:** `page_template == page-templates/about.php`. 7 tabs:

1. **Intro** — `about_intro_heading` (textarea, `\n`→`<br>`), `about_intro_text_1`, `about_intro_text_2`, `about_intro_image`.
2. **Founder** — `founder_image`, `founder_heading`, `founder_name`, `founder_role`, `founder_text`.
3. **What We Offer** — `offer_heading`, `offer_subtext`, `offer_cards` (repeater: `image`, `title`, `text` — 4 cards).
4. **Free Shuttle Service** — page-local copy of the same section on the front page, intentionally **not** shared data: `about_fss_bg_image`, `about_fss_badge_text`, `about_fss_title`, `about_fss_text`, `about_fss_features` (repeater: `title`, `text`), `about_fss_learn_more_text` (plain text label — href is hardcoded to `home_url('/#about')`, i.e. links back to the front page's Why Choose Us section), `about_fss_logo_primary`/`about_fss_logo_secondary` (images), `about_fss_book_now_text` (plain text label — href resolved via `jp_template_page_url('page-templates/reserver-spot.php')`).
5. **How It Works** — `how_heading`, `how_text`, `how_image`, `how_steps` (repeater: `icon` image, `title`, `text` — 4 steps).
6. **Mission** — `mission_image`, `mission_heading`, `mission_text_1`, `mission_text_2`.
7. **Contact & Directions** — `about_contact_eyebrow`, `about_contact_title`, `about_contact_text`, `about_contact_address_title`, `about_direction_steps` (repeater: `title`, `text`). Map/address reuse `global_map_embed_url` / `global_address` / `global_logo_secondary`.

---

## `group_page_direction.json` — Page: Direction

**Location:** `page_template == page-templates/direction.php`. Flat (no tabs — small enough):

`direction_eyebrow`, `direction_title`, `direction_text`, `direction_address_title` (address text itself reuses `global_address`), `direction_steps` (repeater: `title`, `text`), `direction_form_title`, `direction_map_embed_url` (page-specific — defaults to a tighter zoom (`z=15`) than the global map), and **`contact_form_shortcode`** (text — full CF7 shortcode; **added later directly in wp-admin**, currently defaults to `[contact-form-7 id="7406346" title="Contact Form"]` — a different, dedicated CF7 form from the home page's booking form).

---

## `group_page_reserve_spot.json` — Page: Reserve a Spot

**Location:** `page_template == page-templates/reserver-spot.php`.

`reserve_bg_image`, `reserve_form_title`, and **`booking_form_shortcode`** (text — full CF7 shortcode; **added later directly in wp-admin**, `do_shortcode()`'d in place of what was originally a static non-functional `<form>`).

---

## `group_page_testimonials.json` — Page: Testimonials

**Location:** `page_template == page-templates/testimonial.php`. 2 tabs:

1. **Testimonials Slider** — `testimonials` (repeater: `photo` image, `name`, `location`, `rating` number 1–5, `text`), `testimonials_show_more_text` (plain text label — href resolved via `jp_template_page_url('page-templates/testimonial-list.php')`).
2. **FAQ** — `faq_heading`, `faq_items` (repeater: `question`, `answer` — rendered as a Bootstrap accordion; first item is always expanded by loop position, not by data).

See root `CLAUDE.md` "Known gaps" re: this repeater being independent from the Testimonial List page's data.

---

## `group_page_testimonial_list.json` — Page: Testimonial List

**Location:** `page_template == page-templates/testimonial-list.php`. Flat, single field:

`testimonial_list_items` (repeater: `photo` image, `name`, `location`, `rating` number 1–5, `text`) — rendered as a 2-column grid, no slider.

---

## `group_page_privacy_policy.json` — Page: Privacy Policy

**Location:** `page_template == page-templates/privacy-policy.php`. 3 tabs:

1. **Overview** — `privacy_label`, `privacy_heading`, `privacy_intro_text`, `privacy_meta_items` (repeater: `icon` select [shield/phone/envelope/clock/lock/location] → mapped to a Font Awesome class in a lookup array in the template, `title`, `text`).
2. **Policy Content** — `privacy_sections` (repeater: `heading`, `text` — the numbered policy blocks, 7 by default).
3. **Sidebar** — `privacy_sidebar_heading`, `privacy_sidebar_text`, `privacy_contact_email` (email field), `privacy_contact_phone` (text, display format e.g. `+1 (516) 849-3413` — `tel:` href is derived at render time by stripping non-digits), `privacy_sidebar_button_text` (plain text label — href via `jp_template_page_url('page-templates/reserver-spot.php')`).

---

## `group_page_terms_condition.json` — Page: T & C

**Location:** `page_template == page-templates/terms-condition.php`. 3 tabs:

1. **Overview** — `terms_eyebrow`, `terms_heading`, `terms_description`, `terms_highlight_label`, `terms_highlight_heading`, `terms_highlight_text`, `terms_highlight_button_text` (plain text label → `jp_template_page_url('page-templates/reserver-spot.php')`).
2. **Terms List** — `terms_items` (repeater: `icon` select [calendar/payment/shuttle/car/rotate/shield/info] → FA class lookup in template, `title`, `text` — 5 items by default).
3. **Sidebar** — `terms_sidebar_heading`, `terms_sidebar_text`, `terms_sidebar_phone` (text, same `tel:` derivation pattern as Privacy Policy), `terms_sidebar_email` (email).

---

## Adding a new dynamic page

1. Copy the pattern above: build the `.php` template in `page-templates/`, with a `Template Name:` doc comment.
2. Write the field group as JSON directly in `acf-json/` (fastest — copy an existing group and adjust `key`/`title`/`location`/fields), **or** build it in wp-admin and let ACF export it — both are fine, this theme has examples of each.
3. Location rule: `page_template == page-templates/<file>.php` (must match the path WordPress stores in the `_wp_page_template` postmeta — always `page-templates/` + filename here, since that's this theme's subfolder convention).
4. In the template, read content via `jp_field()` / `jp_img()` with a fallback equal to whatever static copy you're replacing — never call `get_field()` directly, to keep the "safe before first save" behavior consistent site-wide.
5. For any button linking to another WP page whose slug isn't guaranteed yet, use `jp_template_page_url( 'page-templates/<target>.php' )` rather than a hardcoded href or a `link`-type ACF field with a guessed URL.
6. Group multiple visual sections into **one field group with tabs** rather than one group per section, unless the page truly has only one section.
