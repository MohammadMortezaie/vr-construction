# Blog Migration Report

Migration source: `https://vrplusconstruction.com/wp-json/wp/v2/posts`

Migration date: 2026-11-19

## Result

- 38 published articles imported.
- All original article slugs remain at the domain root with the same trailing-slash URLs.
- `/blog/` and seven archive pages are available.
- 73 unique blog images are stored locally in `assets/images/blog/`.
- All 73 local blog images were converted to or retained as valid WebP files.
- Imported article HTML contains no remaining `wp-content/uploads` image references.
- Old internal service links were mapped to the current PHP pages.
- `post-sitemap.xml` contains all 38 article URLs and their local WebP images.
- The WordPress API contained one article, `green-home-building-costs`, that was missing from the old post sitemap; it was included in the migration.

## Re-run and validation

```bash
php scripts/import-blog.php
php scripts/validate-blog.php
```

The validator checks article routes, archive pages, sitemap coverage, image existence, WebP MIME types, duplicate slugs and remote WordPress image references.
