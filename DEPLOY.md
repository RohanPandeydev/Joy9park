# Deploying Joy9 Park to Render

The site runs as a **Docker web service** (`Dockerfile` → PHP 8.3 + Apache) with an
**external MySQL** database. `wp-config.php` is generated from environment variables
(`docker/wp-config.render.php`), so nothing environment-specific is committed.

## 1. Database (free: TiDB Cloud Serverless)

1. https://tidbcloud.com → sign in → **Create Cluster** → *Serverless* (free, no card).
2. Cluster → **Connect** → note *Host*, *Port* (4000), *User*, and generate a *Password*.
3. In the SQL editor (or any client) run: `CREATE DATABASE wordpress;`

Any MySQL 8-compatible host works — just set `DB_PORT` to `3306` and `DB_SSL` as required.

## 2. Render

1. Render Dashboard → **New → Blueprint** → connect `RohanPandeydev/Joy9park`.
2. Render reads `render.yaml`; fill in the prompted values:
   `DB_HOST`, `DB_NAME` (`wordpress`), `DB_USER`, `DB_PASSWORD`.
3. Apply. First build takes ~3–5 min.

## 3. WordPress install

Open `https://joy9park.onrender.com` → the WP installer runs → create the admin user.
Then in wp-admin:

- **Appearance → Themes** → activate **Joy9 Park**
- **Plugins** → activate Secure Custom Fields, Contact Form 7 (+ honeypot, jQuery validation)
- **Custom Fields → Field Groups** → **Sync available** → sync all (they ship in `acf-json/`)
- **Pages** → create pages, assign the templates listed in `CLAUDE.md`; set a static
  front page under **Settings → Reading**

## Free-tier caveats

- Container filesystem is **ephemeral**: media uploads (`wp-content/uploads`) are lost on
  every deploy / spin-down. Fine for a demo; for production add a Render Disk (paid) or
  an S3 offload plugin.
- `DISALLOW_FILE_MODS` is on — add plugins/themes by committing them to the repo.
- Free instances sleep after 15 min idle; first request afterwards takes ~30–60 s.

## Importing the XAMPP database later

```bash
mysql --ssl-mode=REQUIRED -h $DB_HOST -P 4000 -u $DB_USER -p wordpress < dump.sql
# then fix URLs (WP-CLI, or the Better Search Replace plugin committed to the repo):
wp search-replace 'http://localhost/joy9park' 'https://joy9park.onrender.com' --all-tables
```
