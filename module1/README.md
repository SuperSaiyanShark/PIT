# Wellmeadow Hospital — Patient Management Module
## Setup Instructions

---

### 1. Copy Files Into Your Laravel Project

Place each file in the path shown:

```
app/
  Http/Controllers/PatientController.php
  Models/Patient.php
  Models/NextOfKin.php
  Models/MedicalRecord.php
  Models/Ward.php
  Models/Admission.php

database/
  migrations/2024_01_01_000001_create_patients_table.php
  seeders/PatientModuleSeeder.php

resources/views/
  layouts/app.blade.php
  patients/index.blade.php
  patients/show.blade.php

routes/
  web.php  ← merge these routes into your existing web.php
```

---

### 2. Configure PostgreSQL in `.env`

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

---

### 3. Run Migrations

```bash
php artisan migrate
```

---

### 4. (Optional) Seed Sample Data

```bash
php artisan db:seed --class=PatientModuleSeeder
```

---

### 5. Register the Seeder (if using DatabaseSeeder)

In `database/seeders/DatabaseSeeder.php`, add:
```php
$this->call(PatientModuleSeeder::class);
```

---

### 6. Routes

The module adds these routes (all prefixed `/patients`):

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET    | `/patients`           | patients.index | Dashboard + list |
| POST   | `/patients`           | patients.store | Register new patient |
| GET    | `/patients/{id}`      | patients.show  | Patient detail page |
| PUT    | `/patients/{id}`      | patients.update | Edit patient |
| POST   | `/patients/{id}/medical-records` | patients.medical-records.store | Add medical record |
| POST   | `/patients/{id}/admit`    | patients.admit | Admit patient |
| POST   | `/patients/{id}/discharge` | patients.discharge | Discharge patient |

---

### 7. For Your Leader (Database Integration Notes)

When combining modules, note:
- Primary keys use custom names: `PatientID`, `WardID`, etc.
- All FK references use the same naming convention
- The `patients` table is central — other modules (staff, prescriptions, etc.) 
  will likely FK into it via `PatientID`
- Timestamps (`created_at`, `updated_at`) are included on all tables

---

### Design Notes

- Color scheme: Teal (`#12a8bd`) — matches your Figma
- Fonts: DM Sans (Google Fonts — no install needed)
- No npm/Vite required — pure CSS, no Tailwind dependency
- Works with Laravel 10+ and Laravel 11+
