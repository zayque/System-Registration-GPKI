# Hadirin

**Pendaftaran acara & kehadiran berkod QR.** Hadirin is an event registration system for trainings, seminars, workshops, conferences, webinars and ceremonies. Participants register online and get a QR e-ticket. Organisers check them in at the door by scanning it.

Built with plain PHP 8.3 (no framework), MariaDB, and a hand-written design system with light and dark themes. Everything runs in Docker.

---

## Features

**For participants**
- Event listing with live seat counts, capacity bars and a countdown
- Smart registration form with inline validation, MyKad date-of-birth hint and a progress meter
- Instant **QR e-ticket**: web page, **PDF download**, **add-to-calendar (.ics)** and print
- Confirmation email with the QR code and calendar file attached
- **Waitlist**: when an event is full, people join a queue and are auto-confirmed (by email) when a seat frees up
- Self-service portal (email + MyKad) to view, download or **cancel** tickets, or notify absence

**For organisers (admin panel)**
- Dashboard: KPIs, 30-day registration trend, breakdowns by zone, event type and organisation
- Events: create, edit, duplicate, delete; capacity, waitlist toggle, registration deadline, draft/open/closed
- **Custom questions per event**: text, long text, dropdown, single or multiple choice, required or optional (e.g. shirt size, dietary needs, preferred sessions)
- Participants: search, filter by event/status/zone, status tabs, bulk actions (mark attended/absent, resend email, delete), per-person edit and history
- **QR check-in scanner** using the device camera (also works with USB barcode scanners or typed reference codes), with live attendance counter, sound and vibration
- CSV export (Excel-friendly). With a single event selected, each custom question gets its own column
- Editable email templates with placeholders, live preview and test send
- Admin accounts with roles: `superadmin`, `admin`, `staff` (scan & view only)
- Full **audit log** of every admin action

**Security**
- PDO prepared statements everywhere (no SQL injection)
- CSRF tokens on every form, `password_hash` for passwords, session hardening
- Login and lookup rate limiting, honeypot against bots, output escaping
- Unguessable 40-character ticket tokens; MyKad masked on tickets

---

## Quick start (Docker)

```bash
cp .env.example .env
docker compose up -d --build
```

The first start installs Composer packages and creates the database with sample data, so give it about a minute.

| What | URL |
|---|---|
| Public site | http://localhost:8088 |
| Admin panel | http://localhost:8088/admin (`zayque` / `12345`) |
| Mailpit (catches all outgoing email) | http://localhost:8025 |

> Change the admin password after first login (**Profil & Kata Laluan**).

To reset the database to the sample data:

```bash
docker compose down -v && docker compose up -d
```

---

## Connecting with DBeaver

1. **Database → New Database Connection → MariaDB** (MySQL also works)
2. Fill in:

| Field | Value |
|---|---|
| Host | `localhost` |
| Port | `3308` |
| Database | `hadirin` |
| Username | `hadirin` |
| Password | `hadirin_secret` |

3. Click **Test Connection** (DBeaver will offer to download the driver), then **Finish**.

For root access use username `root` / password `root_secret`. All values come from `.env`.

**Tables:** `events`, `registrations`, `admins`, `email_templates`, `audit_log`, `zones`, `states`, `ministries`, `login_attempts`.
The view **`v_event_summary`** gives per-event confirmed / attended / waitlisted / cancelled counts, handy for quick reports.

Custom questions are stored as JSON in `events.custom_fields`, and answers in `registrations.answers`. In DBeaver you can query them with MariaDB's JSON functions, e.g.

```sql
SELECT full_name, JSON_VALUE(answers, '$.diet') AS diet
FROM registrations WHERE event_id = 1;
```

---

## Configuration (`.env`)

| Key | Purpose |
|---|---|
| `APP_NAME` | Brand name shown everywhere (site, emails, PDF tickets) |
| `APP_URL` | Public URL used in email links |
| `APP_PORT`, `DB_PORT` | Host ports (defaults 8088 and 3308) |
| `MAIL_*` | SMTP settings. Defaults point at Mailpit; see `.env.example` for Gmail |
| `APP_DEBUG` | Show detailed errors. Set to `false` in production |

The lists of states/zones and ministries/parent organisations live in the `states`, `zones` and `ministries` tables. Edit them in DBeaver to suit your organisation.

---

## Project structure

```
docker/            PHP-Apache image, php.ini, DB init scripts (schema + seed)
public/            Web root: index.php (front controller), assets/
src/               App code: Router, Database, Events, Registrations, Mailer, Qr, Ticket, Ics
src/routes/        public.php (site) and admin.php (panel)
views/             layouts/, public/, admin/, partials/, emails/
```

The camera scanner needs HTTPS or `localhost` (a browser rule). For use on phones over the network, put the app behind HTTPS.

---

Originally built by **Akmal Hafiz bin Hashim** as a GPKI training registration form; rebuilt as a general-purpose event system.
