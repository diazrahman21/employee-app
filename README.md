# Employee Management System

Aplikasi web full-stack untuk manajemen data karyawan dengan fitur CRUD dan analitik ringkasan yang komprehensif. Dibangun dengan Laravel 11, Bootstrap 3, dan DataTables.

## 📋 Fitur Utama

- ✅ **CRUD Karyawan**: Tambah, lihat, edit, dan hapus data karyawan via AJAX
- ✅ **Tabel Interaktif**: DataTables dengan pencarian, sorting, dan paginasi
- ✅ **Analitik Ringkasan**: Query UNION ALL untuk menampilkan jumlah karyawan per pekerjaan dan kota
- ✅ **REST API**: API endpoint untuk integrasi dengan aplikasi lain
- ✅ **Responsive Design**: Antarmuka yang responsif dengan Bootstrap 3
- ✅ **AJAX Only**: Tidak ada reload halaman, semua operasi berjalan asynchronous

## 📦 Technology Stack

- **Backend**: Laravel 11
- **Database**: PostgreSQL 15+
- **Frontend**: Bootstrap 3.3.7, jQuery 1.12.4, DataTables 1.13.4
- **PHP**: 8.2.12+

## 🚀 Instalasi

### Prerequisites
- PHP 8.2+
- Composer
- PostgreSQL 15+
- Node.js & npm (untuk build assets)

### Langkah-langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd employees-app
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env` sesuaikan dengan koneksi PostgreSQL Anda:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=employee_db
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

5. **Jalankan Migrations**
```bash
php artisan migrate
```

6. **Jalankan Seeder**
```bash
php artisan db:seed
```

7. **Build Assets** (optional)
```bash
npm run build
```

8. **Start Development Server**
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000/employees`

## 📊 Database Schema

### Tabel: employees

| Column | Type | Nullable | Default |
|--------|------|----------|---------|
| id | BIGINT | No | auto increment |
| nama | VARCHAR(255) | No | - |
| kota | VARCHAR(255) | No | - |
| pekerjaan | VARCHAR(255) | No | - |
| created_at | TIMESTAMP | Yes | NULL |
| updated_at | TIMESTAMP | Yes | NULL |

### Sample Data

Sistem sudah dilengkapi dengan 14 data karyawan:

| Nama | Kota | Pekerjaan |
|------|------|-----------|
| Jane Doe | Madrid | Programmer |
| Adam Smith | London | UI/UX Designer |
| Steven Berk | Madrid | System Analyst |
| John Drink Water | Jakarta | Programmer |
| Alphonse Calman | Paris | UI/UX Designer |
| Paulo Verbose | Jakarta | System Analyst |
| Rebecca Bernardo | Paris | Programmer |
| Luis Petrucci | London | System Analyst |
| Frank Bethoveen | Madrid | UI/UX Designer |
| Calumn Sweet | Jakarta | UI/UX Designer |
| Edward Campbell | Lisbon | Programmer |
| Harry Potter | Jakarta | UI/UX Designer |
| Gilberto | Lisbon | System Analyst |
| Luka Smitic | Madrid | Programmer |

## 🔌 REST API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Endpoints

#### 1. Get All Employees
```
GET /api/employees
```
**Response**: Array of all employees
```json
[
  {
    "id": 1,
    "nama": "Jane Doe",
    "kota": "Madrid",
    "pekerjaan": "Programmer",
    "created_at": "2026-04-17T09:35:56.000000Z",
    "updated_at": "2026-04-17T09:35:56.000000Z"
  }
]
```

#### 2. Create Employee
```
POST /api/employees
```
**Request Body**:
```json
{
  "nama": "John Doe",
  "kota": "Jakarta",
  "pekerjaan": "Programmer"
}
```
**Response**: Created employee object (status 201)

#### 3. Update Employee
```
PUT /api/employees/{id}
```
**Request Body**:
```json
{
  "nama": "Jane Smith",
  "kota": "Bangkok",
  "pekerjaan": "Senior Programmer"
}
```
**Response**: Updated employee object

#### 4. Delete Employee
```
DELETE /api/employees/{id}
```
**Response**: Empty (status 204)

#### 5. Get Summary
```
GET /api/employees/summary
```
**Response**: Summary dengan UNION ALL query
```json
[
  {
    "label": "Programmer",
    "jumlah": 5
  },
  {
    "label": "System Analyst",
    "jumlah": 4
  },
  {
    "label": "UI/UX Designer",
    "jumlah": 5
  },
  {
    "label": "Madrid",
    "jumlah": 4
  },
  {
    "label": "Lisbon",
    "jumlah": 2
  },
  {
    "label": "Jakarta",
    "jumlah": 4
  },
  {
    "label": "Paris",
    "jumlah": 2
  },
  {
    "label": "London",
    "jumlah": 2
  }
]
```

## 📄 Struktur File

```
employees-app/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── EmployeeController.php     # Controller utama
│   └── Models/
│       └── Employee.php                   # Model Eloquent
├── bootstrap/
│   └── app.php                            # Bootstrap aplikasi
├── database/
│   ├── migrations/
│   │   └── 2026_04_17_093556_create_employees_table.php
│   └── seeders/
│       └── EmployeeSeeder.php             # Seeder data
├── resources/
│   └── views/
│       └── index.blade.php                # UI dengan DataTables
├── routes/
│   ├── api.php                            # API routes
│   └── web.php                            # Web routes
└── README.md                              # Dokumentasi ini
```

## 🎨 User Interface

### Halaman Utama: `/employees`

Aplikasi memiliki 2 tab utama:

#### Tab 1: Employees
- **Tabel Karyawan**: Menampilkan daftar semua karyawan dengan kolom ID, Nama, Kota, Pekerjaan, dan Actions
- **Tombol Add New Employee**: Membuka modal untuk menambah karyawan baru
- **Edit Button**: Untuk mengubah data karyawan
- **Delete Button**: Untuk menghapus karyawan
- **Search & Filter**: Fitur pencarian real-time
- **Pagination**: Navigasi antar halaman

#### Tab 2: Summary
- **Tabel Ringkasan**: Menampilkan statistik dengan 2 kolom (Label, Jumlah)
- **Jobs Count**: Total karyawan per jenis pekerjaan
- **Cities Count**: Total karyawan per kota

## 🔄 SQL Query

Endpoint `/api/employees/summary` menggunakan query UNION ALL berikut:

```sql
SELECT label, jumlah FROM (
    SELECT pekerjaan AS label, COUNT(*) AS jumlah, 
        CASE pekerjaan 
            WHEN 'Programmer' THEN 1
            WHEN 'System Analyst' THEN 2
            WHEN 'UI/UX Designer' THEN 3
        END as sort_order
    FROM employees 
    GROUP BY pekerjaan
    UNION ALL
    SELECT kota AS label, COUNT(*) AS jumlah,
        CASE kota
            WHEN 'Madrid' THEN 4
            WHEN 'Lisbon' THEN 5
            WHEN 'Jakarta' THEN 6
            WHEN 'Paris' THEN 7
            WHEN 'London' THEN 8
        END as sort_order
    FROM employees 
    GROUP BY kota
) as combined
WHERE sort_order IS NOT NULL
ORDER BY sort_order
```

## 🧪 Testing API

### Menggunakan cURL

```bash
# Get all employees
curl http://localhost:8000/api/employees

# Create employee
curl -X POST http://localhost:8000/api/employees \
  -H "Content-Type: application/json" \
  -d '{"nama":"John Doe","kota":"Jakarta","pekerjaan":"Programmer"}'

# Get summary
curl http://localhost:8000/api/employees/summary

# Update employee
curl -X PUT http://localhost:8000/api/employees/1 \
  -H "Content-Type: application/json" \
  -d '{"nama":"Jane Smith","kota":"Bangkok","pekerjaan":"Senior Programmer"}'

# Delete employee
curl -X DELETE http://localhost:8000/api/employees/1
```

### Menggunakan Postman
1. Import collection atau buat request manual
2. Untuk POST/PUT, set Content-Type header ke `application/json`
3. Masukkan JSON body sesuai format endpoint

## 🔧 Konfigurasi

### Environment Variables (.env)

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=employee_db
DB_USERNAME=postgres
DB_PASSWORD=master123

LOG_CHANNEL=stack
```

## 📝 Validasi Data

### Create/Update Employee

- **nama**: Required, string, max 255 karakter
- **kota**: Required, string, max 255 karakter
- **pekerjaan**: Required, string, max 255 karakter

## 🛠️ Development

### Menjalankan Migrations
```bash
php artisan migrate              # Jalankan migrations
php artisan migrate:refresh      # Reset database
php artisan migrate:rollback     # Batalkan migrations terakhir
```

### Menjalankan Seeder
```bash
php artisan db:seed             # Jalankan semua seeder
php artisan db:seed --class=EmployeeSeeder  # Jalankan seeder tertentu
```

### Akses Tinker (REPL)
```bash
php artisan tinker
> App\Models\Employee::count()
> DB::table('employees')->get()
```

## 📋 Lihat Routes
```bash
php artisan route:list
```

## 🐛 Troubleshooting

### Error: Database Connection Failed
- Pastikan PostgreSQL running
- Cek koneksi di `.env` sudah benar
- Pastikan database sudah dibuat: `CREATE DATABASE employee_db;`

### Error: Permission Denied
- Pastikan folder `storage` dan `bootstrap/cache` writable
```bash
chmod -R 775 storage bootstrap/cache
```

### AJAX Requests Return 404
- Pastikan API routes terdaftar: `php artisan route:list`
- Pastikan `bootstrap/app.php` sudah include file `api.php`

### Data Tidak Muncul di Tabel
- Buka Developer Tools (F12) → Console
- Cek apakah ada error message
- Pastikan API endpoint `/api/employees` mengembalikan data

## 📞 Support

Untuk masalah atau pertanyaan, silakan buat issue di repository.

## 📄 License

MIT License - Silakan gunakan untuk keperluan komersial maupun non-komersial.

---

**Dibuat**: April 17, 2026  
**Framework**: Laravel 11  
**Database**: PostgreSQL
