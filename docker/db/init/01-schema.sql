-- =========================================================
--  Hadirin - event registration & QR attendance - schema
--  Runs automatically the first time the MariaDB container starts.
-- =========================================================
SET NAMES utf8mb4;
SET time_zone = '+08:00';

CREATE TABLE admins (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(150) NOT NULL,
  email         VARCHAR(190) NOT NULL UNIQUE,
  username      VARCHAR(60)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('superadmin','admin','staff') NOT NULL DEFAULT 'admin',
  is_active     TINYINT(1) NOT NULL DEFAULT 1,
  last_login_at DATETIME NULL,
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE zones (
  id   TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(40) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE states (
  id      TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  zone_id TINYINT UNSIGNED NOT NULL,
  name    VARCHAR(40) NOT NULL UNIQUE,
  CONSTRAINT fk_states_zone FOREIGN KEY (zone_id) REFERENCES zones(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE ministries (
  id   SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(190) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE events (
  id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  type                  VARCHAR(30) NOT NULL DEFAULT 'latihan',   -- latihan, seminar, bengkel, persidangan, webinar, majlis
  title                 VARCHAR(200) NOT NULL,
  slug                  VARCHAR(220) NOT NULL UNIQUE,
  description           TEXT NULL,
  zone_id               TINYINT UNSIGNED NULL,
  state_id              TINYINT UNSIGNED NULL,
  event_date            DATE NOT NULL,
  start_time            TIME NOT NULL,
  end_time              TIME NOT NULL,
  venue_name            VARCHAR(200) NOT NULL,
  venue_address         VARCHAR(300) NULL,
  capacity              INT UNSIGNED NOT NULL DEFAULT 50,
  waitlist_enabled      TINYINT(1) NOT NULL DEFAULT 1,
  registration_deadline DATETIME NULL,
  closed_message        TEXT NULL,
  custom_fields         JSON NULL,                                -- admin-defined extra questions
  status                ENUM('draft','open','closed') NOT NULL DEFAULT 'open',
  created_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_events_zone  FOREIGN KEY (zone_id)  REFERENCES zones(id)  ON DELETE SET NULL,
  CONSTRAINT fk_events_state FOREIGN KEY (state_id) REFERENCES states(id) ON DELETE SET NULL,
  INDEX idx_events_status_date (status, event_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE registrations (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  event_id       INT UNSIGNED NOT NULL,
  ref_code       VARCHAR(20)  NOT NULL UNIQUE,
  token          CHAR(40)     NOT NULL UNIQUE,      -- QR payload, unguessable
  full_name      VARCHAR(190) NOT NULL,
  email          VARCHAR(190) NOT NULL,
  ic_no          CHAR(12)     NOT NULL,
  mobile_no      VARCHAR(15)  NOT NULL,
  office_no      VARCHAR(15)  NULL,
  agency         VARCHAR(190) NOT NULL,
  ministry       VARCHAR(190) NULL,                 -- parent organisation / ministry
  grade          VARCHAR(60)  NOT NULL,             -- position / grade
  answers        JSON NULL,                         -- answers to the event's custom questions
  state          VARCHAR(40)  NULL,
  zone           VARCHAR(40)  NULL,
  status         ENUM('registered','waitlisted','attended','absent','cancelled') NOT NULL DEFAULT 'registered',
  absence_reason TEXT NULL,
  checked_in_at  DATETIME NULL,
  checked_in_by  INT UNSIGNED NULL,
  created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_reg_event FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
  CONSTRAINT fk_reg_admin FOREIGN KEY (checked_in_by) REFERENCES admins(id) ON DELETE SET NULL,
  UNIQUE KEY uq_reg_event_ic (event_id, ic_no),
  UNIQUE KEY uq_reg_event_email (event_id, email),
  INDEX idx_reg_lookup (email, ic_no),
  INDEX idx_reg_status (event_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE email_templates (
  id         TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code       VARCHAR(40)  NOT NULL UNIQUE,  -- confirm, waitlist, promoted, cancelled
  label      VARCHAR(100) NOT NULL,
  subject    VARCHAR(200) NOT NULL,
  body       TEXT NOT NULL,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE audit_log (
  id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  admin_id   INT UNSIGNED NULL,
  action     VARCHAR(60)  NOT NULL,
  entity     VARCHAR(40)  NULL,
  entity_id  INT UNSIGNED NULL,
  details    VARCHAR(500) NULL,
  ip         VARCHAR(45)  NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_audit_admin FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE SET NULL,
  INDEX idx_audit_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE login_attempts (
  id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  scope      VARCHAR(20) NOT NULL,          -- admin | lookup
  ip         VARCHAR(45) NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_attempts (scope, ip, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Handy view for reporting in DBeaver
CREATE VIEW v_event_summary AS
SELECT e.id, e.type, e.title, e.event_date, e.capacity, e.status,
       SUM(r.status IN ('registered','attended','absent')) AS confirmed,
       SUM(r.status = 'attended')   AS attended,
       SUM(r.status = 'waitlisted') AS waitlisted,
       SUM(r.status = 'cancelled')  AS cancelled
FROM events e
LEFT JOIN registrations r ON r.event_id = e.id
GROUP BY e.id;
