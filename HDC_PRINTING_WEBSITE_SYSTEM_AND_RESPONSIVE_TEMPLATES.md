# HDC Printing Website System & Responsive Templates

**Status:** Integrated design specification  
**Scope:** Website information architecture, reusable page templates, responsive design tokens, interaction behavior, product configuration, validation and ORVIA workflow.  
**Reference base:** HDC homepage capture, HDC product-universe concept image, finishing page HTML, expanding-panels HTML, printing catalogue specification, and Khanh Nguyen-inspired interaction archive.

> This is a system specification, not a full coded website. Measurements marked **proposed** are implementation targets to verify in the eventual site. The interaction archive is a reconstruction record; its numeric values are not measurements from Khanh Nguyen’s live site.

---

## 1. System intent

Build a premium printing website that feels **editorial, material-led and production-literate**. Use a stable grid, repeated type hierarchy and consistent control geometry to create symmetry; introduce asymmetry through image scale, split proportions, selected wide cards and alternating section composition.

The site should help a visitor move through five questions:

1. What can HDC print?
2. Which product or application is closest to my job?
3. What information does production need?
4. Is the surface/process combination viable?
5. Should I place a structured job or request a technical review/quote?

### Design principles

- Put the **customer’s desired output** in navigation and the **production route** in the technical explanation.
- Treat every option as conditional on an approved product/configuration record.
- Use material and process imagery as evidence, not decoration.
- Keep product pages on two controlled templates rather than designing one-off pages.
- Use motion to clarify sequence or material behavior; all functionality must remain clear without motion or hover.
- Use square geometry and hairline rules as the base. Use asymmetry in composition, never in spacing or alignment logic.

---

## 2. Source authority and decisions

| Decision area | Canonical basis | Application |
|---|---|---|
| HDC identity colors | Locked HDC palette in project context | Use exact values in §3. The separate social palette image is inspiration only. |
| Public service navigation | HDC site architecture: four service territories | Use four public-facing service routes in §4. |
| Catalogue records | `PRINTING_PRODUCT_CATALOGUE_AND_PRODUCT_PAGE_TEMPLATES.md` | Preserve its five families, 19 products, two templates, surface families, commercial modes and data relationships. |
| Visual direction | HDC homepage capture + “Engineered Tactility” direction | Warm paper / charcoal editorial contrast, technical labels, close material photography, no glassy neon card UI. |
| Finishing interaction | `finishing-embellishment.html` | Four-intent register, macro visual evidence, progressive details/ledger. |
| Expanding process panels | `hdc-expanding-panels-lab.html` | Four production-method panels, one active panel, accessible trigger/content relationships. |
| Khanh-inspired interactions | `KHANH_NGUYEN_UI_UX_REVERSE_ENGINEERED_COMPONENTS.md` | Use as inspiration patterns only. Preserve the archive’s caveats and provenance. |
| Platform status | Connected GitHub/Vercel search returned no matching HDC project | Keep repository and deployment mapping as an ORVIA setup step; do not infer a repo or deploy target. |

### Public taxonomy and backend taxonomy

Keep the **four HDC service territories** as the public discovery layer and the catalogue’s **five product families / 19 products** as structured product records. The two taxonomies solve different jobs and must not be forced into a one-to-one mapping. In particular, DTF transfers and finished DTF apparel stay data-ready; expose them publicly only after confirming they belong in the current HDC customer-facing offer.

---

## 3. Visual foundation

### 3.1 Color tokens — locked HDC palette

| Token | Hex | Role |
|---|---|---|
| `ink-950` | `#0B1013` | Primary dark field, footer, dark process sections |
| `ink-850` | `#171D21` | Secondary dark surface, cards on dark sections |
| `teal-700` | `#036F86` | Primary action, links, active rule / index |
| `teal-400` | `#47C1C7` | Small highlight on dark surfaces; use sparingly |
| `copper-800` | `#7D4E2C` | Warm secondary accent, technical markers |
| `copper-400` | `#D89A63` | Warm highlight in imagery or small emphasis |
| `paper-100` | `#F0EFED` | Main light canvas |
| `white` | `#FFFFFF` | Cards, form surfaces, text on dark backgrounds |
| `mist-400` | `#A9B3B7` | Quiet text and dividers on dark / light surfaces as contrast allows |

Do not use the attached `#F9F9F9 / #004E72 / #FF6E42 / #092634` social palette as the site palette. Avoid gradients and colored glows in the interface. Let print objects carry their own color.

**Contrast rule:** body text at least 4.5:1; large text and meaningful UI boundaries at least 3:1. Validate actual pairings, especially `mist-400` on `paper-100` and `teal-400` on `ink-950`; use darker approved colors when a pairing fails.

### 3.2 Type system — proposed

The site capture has an editorial serif/sans pairing. Preserve the currently approved HDC web fonts if already defined in code. If the implementation has no locked family, test an editorial serif such as **Newsreader** or **Instrument Serif** for display and **Inter** for interface/body copy; approve one pairing before production.

| Style | Desktop target | Mobile target | Use |
|---|---:|---:|---|
| Display / H1 | 72–88 px / 0.96–1.02 line height | 46–56 px / 0.98–1.04 | One per page; short, 2–4 lines |
| H2 | 44–56 px / 1.00–1.08 | 34–40 px / 1.04–1.10 | Section statement |
| H3 | 24–30 px / 1.05–1.15 | 22–26 px / 1.08–1.18 | Card or subsection |
| Lead | 18–20 px / 1.35–1.5 | 16–18 px / 1.4–1.55 | Page/section introduction |
| Body | 15–17 px / 1.5–1.65 | 15–16 px / 1.5–1.65 | Explanatory copy |
| Label / eyebrow | 10–11 px / 1.2 | 10–11 px / 1.2 | Uppercase, tracking 1–1.4 px |
| Control | 14–16 px / 1.2 | 16 px / 1.25 | Inputs, buttons, selection labels |

Do not set long paragraphs in display serif. Avoid all-caps body copy. Keep line length near 55–75 characters.

### 3.3 Geometry and spacing — proposed

- Base spacing unit: **8 px**.
- Main layout grid: **12 columns desktop**, **8 columns tablet**, **4 columns mobile**.
- Desktop content maximum: **1,296 px** within a 1,440 px viewport (72 px side margins).
- Wide desktop 1,280 px: **1,168 px content**, 56 px side margins.
- Tablet 768 px: **688 px content**, 40 px side margins.
- Mobile 390 px: **358 px content**, 16 px side margins. At 360 px, content is 328 px.
- Desktop grid gutter: **24 px**; tablet **20 px**; mobile **16 px**.
- Standard section padding: desktop **112–144 px**, tablet **88–104 px**, mobile **64–80 px**. Use 8 px multiples.
- Controls and interactive rows: minimum **48 px height**; standard input **52 px**.
- Border: **1 px**. Radius: **0–2 px** for cards and fields; avoid pill controls except compact filter chips.
- Focus outline: **2 px** high-contrast outline with **2 px offset**; never remove browser keyboard visibility.
- Maintain at least **24 px** between unrelated content groups and **32 px** between stacked form fields.

### 3.4 Asymmetry without layout drift

Use one strong asymmetry per section, built on the same grid:

- Hero: **5 / 7 columns** copy-to-image at desktop; switch image-first or copy-first consistently on mobile.
- Editorial split: **5 / 7** or **7 / 5**; alternate which side receives the larger visual.
- Four service cards: equal base width, with an occasional **2× width feature** only where card count and reading order remain predictable.
- Macro gallery: **7 / 5** image-to-index split; do not resize the list rows independently.
- Align every section title, index rule and CTA to shared grid edges. Do not use `grid-auto-flow: dense` for fixed editorial placement.

---

## 4. Information architecture

### Primary navigation

`Services` · `Products` · `Surfaces` · `About` · **Request a Quote**

- Desktop: one-line navigation with one high-contrast CTA.
- Mobile: compact wordmark + menu button. Keep a direct quote/project action visible inside the menu and near page end.
- Avoid nested navigation deeper than two levels. Product filters handle catalogue breadth.

### Four public-facing service territories

1. **Labels & Decals** — labels, stickers, custom sticker sheets, decals.
2. **Products & Object Printing** — qualified bottles, plaques and promotional objects.
3. **Packaging & Commercial Print** — packaging, brochures, certificates, stationery and commercial print.
4. **Large Format & Brand Environments** — posters, wall vinyls, signs, displays and environmental graphics.

### Five canonical catalogue families / 19 product records

1. **DTF Transfers:** Custom DTF Transfers; Gang Sheets; Bulk Transfers.
2. **Finished DTF Apparel:** T-Shirts; Hoodies; Jerseys / Uniforms; Caps.
3. **UV Printing + Decals:** UV DTF Decals; Labels & Stickers; Custom Sticker Sheets; UV Printed Bottles.
4. **Commercial Print + Branding:** Packaging Print; Branded / Promotional Products; Brochures; Certificates; Printed Bottles.
5. **Large Format + Display:** Signage / Retail & Event Displays; Posters; UV Printed Wall Vinyls.

The canonical catalogue file owns exact product descriptions, configuration fields, surface families, production relationships and template assignments. Preserve those records. A public service card can point to several product records; a record may have related or alternate production routes.

---

## 5. Page templates

### 5.1 Homepage template

Recommended sequence:

1. **Header / navigation** — wordmark, four links, quote action.
2. **Hero / print promise** — short H1, 1–2 sentence explanation, one primary action, one secondary action, hero visual combining finished object and surface detail.
3. **Service register** — four territories, visual led, descriptive labels; equal card system with one optional wide feature.
4. **Production logic** — “Process follows the physical job”; explain surface, object, artwork and application as decision inputs.
5. **Surface / application study** — representative macro image plus a concise explanation and link to surface library.
6. **Finishing & embellishment** — four intents: protect, reflect, dimension, shape; link to the full finish ledger.
7. **Selected work / evidence** — examples labelled by product/application and process evidence. Do not claim an unverified material compatibility.
8. **Product catalogue entry** — family navigation and search/filter controls.
9. **Project CTA** — start project / request technical review.
10. **Footer** — contact, core navigation, location and visible “Powered by ORVIA” marker.

Do not put all catalogue details, process panels and finish definitions above the fold. The hero introduces the system; below-fold sections answer the next question.

### 5.2 Product page — Template A: Standard Product Configurator

Use for products whose options can be chosen from an approved option profile (for example brochures, certificates, standard labels, posters, approved packaging-print jobs).

**Desktop top section:** 7-column gallery + 5-column configuration panel, aligned at the top. Product title/lead sits above the form or in the upper portion of the right column. Keep the primary submit action visible without requiring a full-page scan.

**Required sequence:**

1. Format / size
2. Material / stock
3. Print method or print specification (only approved choices)
4. Finish / conversion
5. Quantity
6. Versions / artwork variations, when applicable
7. Artwork upload and production notes
8. Price, quote, or technical-review status
9. Add to job / request quote

**Product gallery — four evidence views:**

- `01 / Object`: finished output.
- `02 / Surface`: actual stock/substrate.
- `03 / Process`: credible production evidence.
- `04 / Detail`: ink, registration, cut or finish macro.

**Specification register:** `Printing` · `Material / stock` · `Finishing` · `Artwork`. Use horizontal register rows, not a generic stack of feature tiles.

### 5.3 Product page — Template B: Surface / Application Configurator

Use whenever compatibility depends on the physical object and surface: UV DTF decals, bottles, promotional objects and future object-printing products.

**Required sequence:**

1. Surface material
2. Object type / format
3. Geometry (flat, cylindrical, curved, irregular; only supported values)
4. Printable area / dimensions
5. Candidate print process
6. Ink construction / white layer where relevant
7. Finish / effect
8. Quantity
9. Artwork upload
10. Compatibility state with reasons and next action
11. Request technical review / quote

A surface selection alone must not imply compatibility. The compatibility result must be one of:

- `REVIEWED / AVAILABLE` — approved production profile exists.
- `NEEDS TEST / TECHNICAL REVIEW` — more information or a sample test is needed.
- `NOT CURRENTLY SUPPORTED` — explain why and offer a contact route.

### 5.4 Shared commerce modes

Keep the source catalogue’s three commercial modes:

- **MATRIX:** show a price only when the selected configuration exactly matches an active, approved matrix row.
- **QUOTE:** collect required job fields, then submit for a quotation.
- **TECHNICAL_REVIEW:** gather surface/object/artwork details and route to a human review.

If no approved price row matches, switch to quote; never estimate with a front-end formula. Do not use fake stock, unverified discounts, empty reviews or artificial urgency.

### 5.5 Job summary

Persistent summary lists: product, size/format, material, process, finish, quantity, artwork status and price/quote state.

- Desktop: sticky right-side summary; top offset **24 px** below the header; preserve viewport room and never cover form controls.
- Mobile: compact bottom action bar with a **48 px** primary action and expandable summary sheet; keep enough scroll padding that the bar does not obscure the final field.
- Summary updates after every valid selection. Announce material changes to screen readers through a polite live region.

---

## 6. Reusable interaction patterns

Treat values below as proposed production targets derived from the archived snippets and the visual brief, not as source-site measurements.

| Pattern | Recommended behavior | Parameters / safeguards |
|---|---|---|
| Masked heading reveal | Reveal each line on initial entry | 0.75–0.9 s, 0.10–0.14 s stagger, cubic-bezier `(0.22, 1, 0.36, 1)`; disable translation for reduced motion. Do not delay critical content. |
| Internal media parallax | Move image within a fixed, clipped frame | Reduce archived `±10%` travel to **±4%**; image overscan **1.10–1.12×**, verify crop at every aspect ratio. Static image on mobile/reduced-motion. |
| Asymmetric catalogue cadence | Repeat a deliberate feature rhythm | Keep deterministic 6-item cadence only if explicit placement is authored; first/sixth can be feature items. Remove `grid-flow-dense`; preserve DOM order and reading order. |
| Hover preview index | Preview related image on row hover/focus | Retain spring `damping 28 / stiffness 200 / mass 0.5` as an initial desktop tuning point; preview offset from cursor to avoid occlusion; clamp to viewport; enable focus state; use click/tap selection on touch. |
| Sticky scroll register | Activate rows based on the central reading band | Archive is partial. Proposed activation band at **45–55%** viewport height; one active item; no scroll hijacking; keyboard and direct-anchor navigation. |
| Macro inspection | Allow detailed image inspection | Archive uses scale `2.5`; offer only on deliberate click/press, not hover alone; inspect crop and prevent page overflow; Escape/close control; static fallback on touch. |
| Expanding production panels | Four process cards expand into details | One open panel at a time; collapsed cards retain index/title; activation via button; `aria-expanded`, `aria-controls`, hidden/inert content; keyboard sequence follows DOM order. |
| Finish gallery / index | Select one of four intent states | Surface/Protect, Metallic/Reflect, Dimension/Touch, Shape/Complete; persistent initial selection; keyboard button behavior; update alt/caption with the image. |
| Configuration dependency | Recompute valid options when a prior choice changes | Preserve still-valid downstream choices; clear invalid options and explain why; do not submit partial invalid states. |
| Upload state | Show file state and preflight outcome | Idle → selected → uploading → received → preflight-needed/ready → error; keep original filename and recovery action visible. |

### Motion and input rules

- Use opacity/transform for interface transitions; avoid animating layout dimensions when a simple crossfade will read clearly.
- Standard interface transition: **160–240 ms**; expandable panel: **280–420 ms**; avoid long page-wide transitions.
- Hover/focus effect must be reproducible by keyboard focus and touch selection.
- `prefers-reduced-motion: reduce`: remove parallax, reveal travel, cursor-follow previews and scroll-linked transforms; keep state changes instantaneous or use a short opacity fade.
- No automatic carousel advancement. If a carousel is necessary, provide explicit controls and visible position.

---

## 7. Responsive behavior

| Width range | Layout intent |
|---|---|
| `≥ 1280 px` | 12 columns; max content 1,296 px; hero split 5/7; full navigation; 4 service cards per row; sticky configurator summary. |
| `1024–1279 px` | 12 columns; content `calc(100% - 96px)` with a max width; hero remains split only if each side retains at least 400 px; service cards 2×2 when copy is dense. |
| `768–1023 px` | 8 columns; 40 px outer gutters; hero split 4/4 or stacked; cards 2×2; disable pointer-follow preview. |
| `600–767 px` | 6 columns; 24 px outer gutters; stack hero; service cards 2-up only if each stays ≥ 250 px, otherwise 1-up; configurator summary becomes bottom action. |
| `< 600 px` | 4 columns; 16 px outer gutters; single-column reading flow; gallery becomes swipeable only with visible controls or stacked; panels become accessible accordion/list; no hover-only behavior. |

### Small-screen checks

- At **360 px**: no horizontal page overflow; controls stay at least 48 px high; body type does not fall below 15 px (controls 16 px); long product names wrap without colliding with action icons.
- At **390 px**: 16 px page gutters; full-width CTA; sticky bottom bar has safe-area padding.
- At **768 px**: verify service cards, split hero and configurator do not become narrow two-column slivers.
- At **1024 px**: navigation and summary panel do not overlap; long copy preserves readable line length.
- At **1440 px**: max-width grid is centered; no section accidentally stretches rules/copy into the full viewport.

### Mobile transformations

- Desktop side-by-side hero → stacked copy and image; preserve logical sequence and heading-first reading order.
- Desktop expanding panels → stacked accordion; do not keep narrow vertical strips requiring hover.
- Desktop floating cursor preview → inline thumbnail or selected-row image.
- Desktop side summary → bottom summary/action drawer.
- Desktop 4-image gallery → primary image plus accessible thumbnail buttons or vertically stacked evidence; all four evidence roles remain reachable.

---

## 8. Content and image system

### 8.1 Existing-image-first asset policy — locked

- Use HDC's existing, approved image library as the first source for every page and product.
- Before use, map each image to its product/service, verify that it represents the actual material or production route, and record its source, approval status, crop, alt text and rights/usage status.
- Reuse existing originals through responsive crops and appropriately optimized derivatives. Keep the source intact; do not overwrite or silently replace an approved image.
- If a required image does not exist, mark the slot **ASSET REQUIRED** and request or capture approved HDC photography. Do not fill a missing slot with generated product photography.
- Do not add an image-generation command, model/API integration, dependency or runtime generation feature to the website package or deployment workflow.
- Generated page mockups are layout and art-direction references only. They are not approved HDC portfolio images, product specifications, compatibility evidence or production claims.

### Image sequence

For product/service groups, prioritize: **finished object → substrate/surface → graphic system → process → finish behavior → detail**. Use consistent light direction, scale cues and backgrounds across a family. Include real production evidence only when it is accurate for that service.

### Image frame targets

- Homepage hero: **3:2** landscape; reserve sufficient negative space on the copy side.
- Service card: **3:2** or **4:3**, consistent across one row.
- Product gallery object view: **4:3**; detail/macro can use **1:1**; never crop away the product’s defining edge.
- Material study: **4:5** or **1:1** according to actual texture; keep the comparison set consistent.
- Parallax/zoom frame: test at the exact output ratio before choosing overscan.

Use descriptive alt text for informative images. Decorative process imagery uses empty alt text only when the same information appears in adjacent text. Avoid text embedded in generated product images.

---

## 9. Data and configuration contract

Keep the catalogue’s relationship model:

`catalog_family → product → template → configuration_profile → option_group/value + configuration_rules → production_profile → compatibility rules + artwork_profile + pricing_profile → job_line snapshot`

A job line stores an immutable snapshot of selected options, artwork files, validation result, price/quote result and review state. The public product is not permanently tied to a single process unless that process is part of its intentional product definition.

Each configuration option must define:

- stable ID and display label;
- allowed values and default policy;
- dependencies and invalidation behavior;
- whether required, optional or conditional;
- source of truth / approval owner;
- commercial effect: matrix lookup, quote field or technical-review trigger.

The canonical catalogue specification remains authoritative for current product records, surface families, production methods, artwork requirements and field-level data. Do not add new process names or compatibility claims from layout assumptions.

---

## 10. Accessibility and visual QA gates

A page is ready for build handoff only when it passes:

1. **Responsive geometry:** no overlap or unintended horizontal overflow at 360, 390, 430, 600, 768, 1024, 1280 and 1440 px.
2. **Typography:** no clipped headings; field labels remain associated; long names wrap; line length is controlled.
3. **Contrast:** body text ≥ 4.5:1; large text and UI indicators ≥ 3:1; focus visible in both light and dark sections.
4. **Keyboard:** tab order matches visual order; menus, gallery, panels, configurator, uploader and dialogs work without a pointer.
5. **Screen reader:** headings are hierarchical; controls have names; expanding content state and selection are announced; image alt text is meaningful.
6. **Motion:** reduced-motion mode removes nonessential motion; no content depends on an animation completing.
7. **Product integrity:** only approved options appear; dependency changes invalidate stale choices; unsupported combinations route to review/quote; displayed matrix price comes from an exact approved row.
8. **Visual rhythm:** section edges align to the shared grid; dividers are consistent; asymmetry has one clear purpose per section; cards do not reflow out of content order.
9. **Content truth:** process, material and finishing statements match approved HDC capability records.

---

## 11. ORVIA workflow and release map

### Phase 0 — Source and scope register

- Register each input as **locked**, **reference**, **reconstruction**, or **proposed**.
- Resolve the public DTF/apparel visibility question before exposing those catalogue families.
- Confirm current HDC fonts and site palette in the actual codebase before implementation.

### Phase 1 — Catalogue and production data

- Map the four public service territories to the five product families and 19 records.
- Audit product-template assignments, required option data, compatibility rules, artwork profiles and quote modes.
- Mark missing/unknown production facts as review states rather than inventing defaults.

### Phase 2 — Design system

- Establish named color/type/spacing/grid tokens.
- Define shared navigation, buttons, field states, product cards, registers, accordions, gallery controls and status messages.
- Build homepage, Template A, Template B and mobile transformation views from those tokens.

### Phase 3 — Interaction and content proof

- Prototype one expansion panel, one finish-gallery switch, one conditional configurator and one upload/error sequence.
- Check pointer, touch, keyboard and reduced-motion behavior.
- Review all four image evidence roles and content claims.

### Phase 4 — GitHub implementation handoff

- Connect the confirmed HDC repository only after its identity is verified.
- Work on a feature branch with one reversible slice at a time: tokens → shared shell → page templates → interactions/data wiring.
- Keep secrets out of the repository and store deploy credentials only in the hosting environment.

### Phase 5 — Preview and release

- Use a Vercel preview deployment for each reviewed branch/PR.
- Run build, type/lint checks where applicable, responsive screenshot checks, accessibility checks and configuration data validation before approval.
- Promote a validated preview to production only after the intended production owner approves the release.
- Record preview URL, commit SHA, QA results and rollback target in the ORVIA change record.

### Current integration state

No HDC-matching GitHub repository or Vercel project appeared in the connected account lookup during this specification pass. The design is ready for those connections once the correct repository and hosting project are identified. No source repository was changed and no deployment was started.

---

## 12. Deliverable status and open decisions

**Specified:** information architecture; HDC palette; responsive spacing/grid/type targets; homepage sequence; Template A and B; gallery and job summary; interaction behavior; mobile rules; accessibility gates; data contract; ORVIA implementation/release workflow.

**Open before implementation:**

1. Confirm whether DTF transfers and finished DTF apparel appear in the public HDC catalogue or remain internal/data-ready.
2. Confirm the active HDC web fonts from the current repository.
3. Confirm product-by-product approved options, price matrices, surface compatibility, artwork profiles and production lead-time language.
4. Identify the HDC GitHub repository and Vercel project.
5. Add the editable Figma page layouts after the connected account permits further design-tool calls; the created Figma file currently contains only its initial blank page.
