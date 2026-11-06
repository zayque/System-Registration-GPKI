SET NAMES utf8mb4;

-- Admins carried over from the v1 database (password hashes unchanged).
-- zayque / 12345  (superadmin)
INSERT INTO admins (id, name, email, username, password_hash, role) VALUES
(1, 'Akmal Hafiz', 'zayque@yahoo.com', 'zayque', '$2y$10$nL7ejhLkp.dS5WE/WYFn0OckEVpsafUQtGUXPPh.UWsOt9Hyz2Bki', 'superadmin'),
(2, 'Muhd Syarif', 'syariff@gmail.com', 'syariff', '$2y$10$fclej.rMJ4CTPB38nJo7sOt8JaMWSNQiDyDJjZolNJvgF/MVSevoW', 'admin');

INSERT INTO zones (id, name) VALUES
(1,'Tengah'),(2,'Timur'),(3,'Utara'),(4,'Selatan'),(5,'Sabah'),(6,'Sarawak');

INSERT INTO states (zone_id, name) VALUES
(1,'Kuala Lumpur'),(1,'Selangor'),(1,'Putrajaya'),
(2,'Kelantan'),(2,'Terengganu'),(2,'Pahang'),
(3,'Perlis'),(3,'Kedah'),(3,'Pulau Pinang'),(3,'Perak'),
(4,'Johor'),(4,'Negeri Sembilan'),(4,'Melaka'),
(5,'Sabah'),(6,'Sarawak');

INSERT INTO ministries (name) VALUES
('JABATAN PERDANA MENTERI'),
('KEMENTERIAN BELIA DAN SUKAN'),
('KEMENTERIAN DIGITAL'),
('KEMENTERIAN DALAM NEGERI'),
('KEMENTERIAN KEMAJUAN LUAR BANDAR DAN WILAYAH'),
('KEMENTERIAN KERJA RAYA'),
('KEMENTERIAN KESIHATAN MALAYSIA'),
('KEMENTERIAN KEWANGAN'),
('KEMENTERIAN KOMUNIKASI DAN MULTIMEDIA'),
('KEMENTERIAN LUAR NEGERI'),
('KEMENTERIAN PELANCONGAN DAN KEBUDAYAAN'),
('KEMENTERIAN PEMBANGUNAN WANITA, KELUARGA, MASYARAKAT'),
('KEMENTERIAN PENDIDIKAN TINGGI'),
('KEMENTERIAN PENGANGKUTAN'),
('KEMENTERIAN PERDAGANGAN ANTARABANGSA DAN INDUSTRI'),
('KEMENTERIAN PERDAGANGAN DALAM NEGERI, KOPERASI DAN KEPENGGUNAAN'),
('KEMENTERIAN PERTAHANAN'),
('KEMENTERIAN PERTANIAN DAN INDUSTRI ASAS TANI'),
('KEMENTERIAN PERUMAHAN DAN KERAJAAN TEMPATAN'),
('KEMENTERIAN PERUSAHAAN PERLADANGAN DAN KOMODITI'),
('KEMENTERIAN SAINS, TEKNOLOGI DAN INOVASI'),
('KEMENTERIAN SUMBER ASLI DAN ALAM SEKITAR'),
('KEMENTERIAN SUMBER MANUSIA'),
('KEMENTERIAN TENAGA, TEKNOLOGI HIJAU DAN AIR'),
('KEMENTERIAN WILAYAH PERSEKUTUAN'),
('PENTADBIRAN KERAJAAN NEGERI JOHOR'),
('PENTADBIRAN KERAJAAN NEGERI KEDAH'),
('PENTADBIRAN KERAJAAN NEGERI KELANTAN'),
('PENTADBIRAN KERAJAAN NEGERI MELAKA'),
('PENTADBIRAN KERAJAAN NEGERI PAHANG'),
('PENTADBIRAN KERAJAAN NEGERI PERAK'),
('PENTADBIRAN KERAJAAN NEGERI PERLIS'),
('PENTADBIRAN KERAJAAN NEGERI PULAU PINANG'),
('PENTADBIRAN KERAJAAN NEGERI SABAH'),
('PENTADBIRAN KERAJAAN NEGERI SARAWAK'),
('PENTADBIRAN KERAJAAN NEGERI SELANGOR'),
('PENTADBIRAN KERAJAAN NEGERI SEMBILAN'),
('PENTADBIRAN KERAJAAN NEGERI TERENGGANU');

-- Sample events (edit or delete from the admin panel)
INSERT INTO events (id, type, title, slug, description, zone_id, state_id, event_date, start_time, end_time, venue_name, venue_address, capacity, registration_deadline, closed_message, custom_fields, status) VALUES
(1, 'bengkel', 'Bengkel Keselamatan Siber untuk Penjawat Awam 2026', 'bengkel-keselamatan-siber-2026',
 'Bengkel hands-on mengenai amalan terbaik keselamatan siber: pengurusan kata laluan, serangan phishing, dan perlindungan data peribadi di tempat kerja.',
 1, 2, DATE_ADD(CURDATE(), INTERVAL 21 DAY), '09:30:00', '16:00:00', 'Dewan Seminar Utama', 'Persiaran Perdana, 62000 Putrajaya', 50,
 NULL, 'Penyertaan telah DITUTUP kerana kuota telah mencukupi. Terima kasih atas minat tuan/puan.',
 '[{"key":"pengalaman","label":"Tahap pengalaman keselamatan siber","type":"radio","options":["Asas","Pertengahan","Mahir"],"required":true},{"key":"laptop","label":"Adakah anda akan membawa komputer riba sendiri?","type":"select","options":["Ya","Tidak"],"required":true},{"key":"diet","label":"Keperluan pemakanan","type":"select","options":["Tiada","Vegetarian","Alahan makanan (nyatakan semasa hari acara)"],"required":false}]',
 'open'),
(2, 'seminar', 'Seminar Transformasi Digital Sektor Awam 2026', 'seminar-transformasi-digital-2026',
 'Seminar sehari bersama pakar industri dan kerajaan mengenai hala tuju pendigitalan perkhidmatan awam, AI dan analitik data.',
 4, 11, DATE_ADD(CURDATE(), INTERVAL 35 DAY), '08:30:00', '17:00:00', 'Dewan Persidangan Antarabangsa', 'Persiaran Medini, 79100 Iskandar Puteri, Johor', 150,
 NULL, 'Penyertaan ke seminar telah DITUTUP kerana kuota telah mencukupi.',
 '[{"key":"sesi","label":"Sesi yang paling diminati","type":"checkbox","options":["Kecerdasan Buatan (AI)","Analitik Data","Perkhidmatan Digital","Keselamatan Siber"],"required":true},{"key":"soalan","label":"Soalan untuk ahli panel (pilihan)","type":"textarea","options":[],"required":false}]',
 'open'),
(3, 'latihan', 'Latihan Microsoft Excel Tahap Lanjutan', 'latihan-excel-lanjutan-2026',
 'Kuasai PivotTable, XLOOKUP, Power Query dan papan pemuka dalam latihan intensif sehari.',
 3, 9, DATE_ADD(CURDATE(), INTERVAL 49 DAY), '09:00:00', '16:30:00', 'Makmal Komputer 2, Pusat Latihan', 'Jalan Tun Dr Awang, 11900 Bayan Lepas, Pulau Pinang', 30,
 NULL, NULL,
 '[{"key":"versi","label":"Versi Excel yang digunakan","type":"select","options":["Microsoft 365","Excel 2021","Excel 2019 atau lebih lama"],"required":true}]',
 'open');

-- Sample participants
INSERT INTO registrations (event_id, ref_code, token, full_name, email, ic_no, mobile_no, office_no, agency, ministry, grade, answers, state, zone, created_at) VALUES
(2, 'SM-0001AA', SHA1('sample-seminar-1'), 'NUR AISYAH BINTI HASHIM', 'aisyah@example.gov.my', '990916023433', '0176768793', '0388881234', 'Jabatan Digital Negara', 'KEMENTERIAN DIGITAL', 'F44',
 '{"sesi":["Kecerdasan Buatan (AI)","Analitik Data"]}', 'Negeri Sembilan', 'Selatan', NOW() - INTERVAL 2 DAY),
(1, 'BK-0001AA', SHA1('sample-bengkel-1'), 'MUHAMMAD AKMAL BIN HASHIM', 'akmal@example.gov.my', '990916025388', '0176768794', NULL, 'Jabatan Akauntan Negara', 'KEMENTERIAN KEWANGAN', 'F41',
 '{"pengalaman":"Pertengahan","laptop":"Ya","diet":"Tiada"}', 'Selangor', 'Tengah', NOW() - INTERVAL 1 DAY);

INSERT INTO email_templates (code, label, subject, body) VALUES
('confirm', 'Pengesahan Pendaftaran', 'PENGESAHAN PENDAFTARAN — {acara}',
'Assalamualaikum dan Salam Sejahtera {nama},

Terima kasih. Pendaftaran tuan/puan telah diterima dan BERJAYA untuk:

{acara}
Tarikh : {tarikh} ({hari})
Masa   : {masa}
Tempat : {tempat}

No. Rujukan: {rujukan}

Sila tunjukkan kod QR yang dilampirkan semasa pendaftaran kehadiran di kaunter. Anda juga boleh menyemak atau membatalkan pendaftaran di: {pautan}

Sekian, terima kasih.
Urusetia Penganjur'),
('waitlist', 'Senarai Menunggu', 'PENDAFTARAN DALAM SENARAI MENUNGGU — {acara}',
'Salam Sejahtera {nama},

Kuota bagi {acara} telah penuh. Pendaftaran tuan/puan (No. Rujukan {rujukan}) telah dimasukkan ke dalam SENARAI MENUNGGU.

Kami akan memaklumkan melalui e-mel sekiranya terdapat kekosongan.

Semak status di: {pautan}

Urusetia Penganjur'),
('promoted', 'Dinaikkan dari Senarai Menunggu', 'TEMPAT ANDA TELAH DISAHKAN — {acara}',
'Salam Sejahtera {nama},

Berita baik! Terdapat kekosongan dan tempat tuan/puan untuk {acara} kini telah DISAHKAN.

Tarikh : {tarikh} ({hari})
Masa   : {masa}
Tempat : {tempat}
No. Rujukan: {rujukan}

Kod QR anda dilampirkan. Semak di: {pautan}

Urusetia Penganjur'),
('cancelled', 'Pembatalan', 'PEMBATALAN PENDAFTARAN — {acara}',
'Salam Sejahtera {nama},

Pendaftaran tuan/puan (No. Rujukan {rujukan}) untuk {acara} telah DIBATALKAN.

Jika ini satu kesilapan, sila daftar semula di: {pautan}

Urusetia Penganjur');
