# HDC-RELOADED
Build the complete Hadi Digital Craft (HDC) website and its data-persistence backend in this repository.

SCOPE
Write the code and project documentation only. Do not deploy, publish, or run live QA. Do not launch a preview server or use browser/device testing. Basic syntax or build checks are acceptable only to catch incomplete code.

Do not generate images or use image-generation tools, APIs, packages, or commands. Do not invent imagery. I will prepare and add the final imagery package later. Build complete image slots with clear filenames, descriptive alt text, and graceful placeholders so I can add assets without changing component code.

Before implementation:
1. Inspect the repository and any existing project instructions.
2. Use the attached or available HDC references if present:
   - PRINTING_PRODUCT_CATALOGUE_AND_PRODUCT_PAGE_TEMPLATES
   - KHANH_NGUYEN_UI_UX_REVERSE_ENGINEERED_COMPONENTS
   - hdc-expanding-panels-lab.html
   - finishing-embellishment.html
   - HDC website screenshots and existing approved assets
3. If a reference is unavailable, continue from this brief. Do not stall or fabricate its contents.
4. Preserve existing files. Do not delete or overwrite unrelated work.

HOSTING AND ARCHITECTURE
The target is Hostinger deployment through GitHub, which I will handle later. Keep the application straightforward to deploy and document the required hosting configuration. If the repository has no established stack, build a server-rendered PHP 8 application with MySQL/MariaDB and progressive-enhancement JavaScript, avoiding a required Node runtime. If the repository already contains a working, Hostinger-compatible stack, keep it and follow its conventions.

Implement the actual backend, not just static screens:
- Store quote requests, customer/contact details, configured line items, artwork-file metadata, job status, and admin audit events in a relational database.
- Include versioned, repeatable database migrations and clearly separated seed data.
- Use server-side validation, prepared statements, transactions, CSRF protection, secure sessions, role-protected admin access, and password hashing.
- Store uploaded artwork as files, not database blobs. Validate file type and size, generate safe random filenames, and keep uploads outside public execution paths where the hosting plan permits. Store file metadata and references in the database.
- Keep credentials out of the repository. Provide an `.env.example` with placeholders and document setup.
- Include an admin workflow to review, update, and export quote/job records. Never expose private customer or artwork data publicly.
- Do not add fake customer reviews, prices, turnaround times, stock claims, production capacity, or compatibility guarantees.

SITE STRUCTURE AND CONTENT
Use HDC’s four service groups:
1. Labels & Decals
2. Products & Object Printing
3. Packaging & Commercial Print
4. Large Format & Brand Environments

Build the homepage, service/category listings, reusable product pages, quote/contact flow, finishing information, Surface Lab, and the supporting about/process/FAQ content needed to make the site coherent. Use the catalogue’s two page patterns:
- Template A: standard product configurator
- Template B: surface/application configurator with compatibility review

Keep textile/DTF products out of public navigation unless explicitly approved for HDC’s customer-facing offer. HDC provides printing services; do not present it as an equipment seller.

DATA AND BUSINESS RULES
Use structured seed data and keep catalogue content separate from presentation code. Preserve unknown values as “needs quote/review”; do not guess.

Implement these owner-confirmed rules:
- A3 sticker or label sheet base price: PKR 2,500 per sheet. This is a base price only. Do not calculate a total or assume add-ons are included unless their pricing rules are supplied.
- Catalogues and posters: minimum order quantity is 500 pieces.
- Catalogue and poster pricing depends on 1, 2, or 4 print colours. Make colour count part of the exact pricing lookup. Do not invent the actual prices. If no approved price row matches, route to quote.
- UV printing and UV DTF are common across most products. Keep them as distinct processes. This does not approve either process for every individual product; require a product-specific approved production profile or route.
- Keep the established product catalogue, materials, surfaces, candidate processes, and commercial modes distinct. A product name alone must never imply surface compatibility.

DESIGN SYSTEM
Follow HDC’s “Engineered Tactility” direction: premium, precise, editorial, tactile, and restrained. Use the supplied HDC palette:
#0B1013, #171D21, #036F86, #47C1C7, #7D4E2C, #D89A63, #F0EFED, #FFFFFF, #A9B3B7.

Create reusable CSS variables for colours, type roles, spacing, radii, borders, motion, content widths, and breakpoints. Use a consistent responsive grid with deliberate asymmetry inside aligned page boundaries. Maintain clean spacing, image ratios, type hierarchy, and component alignment across desktop, tablet, and mobile.

Use an editorial display type role, a highly readable interface/body type role, and a restrained technical-label role. Keep font choices centralized and easy to replace when HDC’s final typography is supplied.

Implement accessible, responsive interactions: keyboard support, visible focus, semantic controls, reduced-motion handling, touch-friendly behavior, and no hover-only essential information. Use the archived interaction references as reconstruction references, not verified source code. Preserve their provenance and tune parameters only where the component needs it; do not apply every effect everywhere.

DELIVERABLES
Write the complete application code, schema/migrations, seed data, reusable components, example environment file, and a README that explains local setup, database initialization, image-slot naming, storage behavior, and the later Hostinger deployment requirements. Do not deploy or configure production credentials. Do not claim live QA or visual verification.
