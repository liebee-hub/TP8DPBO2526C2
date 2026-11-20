# TP8DPBO2526C2

## Janji
Saya Refan Maher Aysel dengan NIM 2509129 mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Tema
**Sistem Data Dosen**, website PHP Native dengan arsitektur **Model-View-Controller (MVC)** untuk mengelola data dosen (Lecturers), departemen (Departments), dan mata kuliah (Courses). Program ini adalah hasil perubahan kode awal (CRUD data dosen dalam satu file yang masih mencampur HTML dan query) menjadi struktur MVC, ditambah dua tabel baru yang berelasi.

## Desain Database

Database `tp_mvc25` terdiri dari 3 tabel. File SQL ada di `tp_mvc25.sql`.

| Tabel | Kolom | Keterangan |
|---|---|---|
| `departments` (baru) | `id` (PK), `name`, `building` | Daftar departemen |
| `lecturers` (lama) | `id` (PK), `name`, `nidn`, `phone`, `join_date`, `department_id` (**FK** ke `departments.id`) | Data dosen. Kolom `department_id` ditambahkan |
| `courses` (baru) | `id` (PK), `code`, `name`, `credits`, `lecturer_id` (**FK** ke `lecturers.id`) | Mata kuliah, masing-masing diajar oleh satu dosen |

Relasi: satu departemen punya banyak dosen, satu dosen mengajar banyak mata kuliah.

```
departments (1) ──< lecturers (1) ──< courses
```

Aturan foreign key:
- `lecturers.department_id` memakai `ON DELETE SET NULL`. Jika departemen dihapus, dosennya tetap ada dan departemennya menjadi kosong (`-`).
- `courses.lecturer_id` memakai `ON DELETE CASCADE`. Jika dosen dihapus, mata kuliah yang diajarnya ikut terhapus.

## Desain Program

Program memakai **OOP dengan mysqli** dan struktur folder MVC sesuai modul:

```
tp_mvc25/
├── assets/          bootstrap.min.css, bootstrap.bundle.min.js
├── controllers/     LecturerController, DepartmentController, CourseController
├── models/          DB, Lecturer, Department, Course
├── templates/       navbar.html, lecturer.html, department.html, course.html
├── views/           Template, LecturerView, DepartmentView, CourseView
├── config.php
├── index.php
├── department.php
└── course.php
```

| File | Peran |
|---|---|
| `index.php`, `department.php`, `course.php` | Entry point tiap halaman (Lecturers, Departments, Courses). Hanya memilih aksi controller berdasarkan `$_POST` / `$_GET`. |
| `config.php` | Pengaturan koneksi database (host, user, password, nama database). |
| `models/DB.php` (`DB`) | Class induk. Membuka koneksi, menjalankan query (`execute`), mengambil hasil (`getResult`), dan membersihkan input (`escape`). |
| `models/Lecturer.php` (`Lecturer`) | Mewarisi `DB`. Query tabel `lecturers`: `getLecturer` (JOIN ke departemen), `getLecturerById`, `addLecturer`, `updateLecturer`, `deleteLecturer`. |
| `models/Department.php` (`Department`) | Mewarisi `DB`. Query tabel `departments`: `getDepartment`, `getDepartmentById`, `addDepartment`, `updateDepartment`, `deleteDepartment`. |
| `models/Course.php` (`Course`) | Mewarisi `DB`. Query tabel `courses`: `getCourse` (JOIN ke dosen), `getCourseById`, `addCourse`, `updateCourse`, `deleteCourse`. |
| `controllers/*Controller.php` | Menerima request dari entry point, meminta data ke model, mengirimkannya ke view, dan melakukan redirect setelah tambah, ubah, atau hapus. |
| `views/Template.php` (`Template`) | Membaca file `.html` dari `templates/`, mengganti placeholder (misal `DATA_TABEL`), lalu menampilkannya. Juga berisi `safe()` untuk `htmlspecialchars`. |
| `views/*View.php` | Menyusun baris tabel, isi form, dan dropdown dari data controller, lalu mengisinya ke template. |
| `templates/*.html` | Kerangka HTML dengan placeholder `DATA_...`. `navbar.html` dipakai semua halaman. |

Keamanan dasar: input dibersihkan dengan `mysqli_real_escape_string` atau cast `(int)` di model, dan output ditampilkan dengan `htmlspecialchars` di view.

## Penjelasan Alur

Contoh: membuka halaman Courses (`course.php`).

1. **Browser** mengirim request ke `course.php`.
2. **`course.php`** membuat `CourseController`, lalu memilih aksi berdasarkan request. Tanpa parameter, aksinya adalah `index()`.
3. **Controller** meminta data ke **model**: `Course::getCourse()` (di-JOIN dengan nama dosen) dan `Lecturer::getLecturer()` (untuk isi dropdown).
4. **Model** menjalankan query lewat `DB::execute()` dan mengembalikan hasilnya ke controller.
5. **Controller** memasukkan hasil ke array, lalu mengirimnya ke `CourseView`.
6. **View** membaca `templates/course.html`, mengganti placeholder (`DATA_TABEL`, `DATA_LECTURER_OPTIONS`, dan lainnya), lalu menampilkannya ke user.

Alur aksi CRUD (pola sama di ketiga halaman, contoh Courses):

| Aksi | Request | Yang terjadi |
|---|---|---|
| **Create** | Form "Add Course" dikirim (`POST add`) | `course.php` → `CourseController::add()` → `Course::addCourse()` → redirect ke `course.php` |
| **Read** | Buka `course.php` | Alur 1–6 di atas |
| **Update** | Klik **Edit** (`?id_edit=ID`), form terisi data lama, klik **Update** (`POST update`) | `index()` mengirim data lama ke view, lalu `update()` → `Course::updateCourse()` → redirect |
| **Delete** | Klik **Delete** (`?id_hapus=ID`) setelah konfirmasi | `delete()` → `Course::deleteCourse()` → redirect |

Halaman Lecturers (`index.php`) dan Departments (`department.php`) memakai pola yang sama.

**Alur Relasi**:
- Pada halaman Lecturers, kolom Department diisi lewat `LEFT JOIN` ke tabel `departments`. Dosen tanpa departemen ditampilkan dengan tanda `-`.
- Pada halaman Courses, kolom Lecturer diisi lewat `JOIN` ke tabel `lecturers`.
- Form Lecturers dan Courses memakai dropdown yang diisi dari data departemen dan dosen.

**Alur Hapus**:
- Hapus departemen akan membuat `department_id` dosen terkait menjadi `NULL`.
- Hapus dosen akan ikut menghapus semua mata kuliah yang diajarnya.

## Dokumentasi

Halaman Home
<img width="1917" height="1026" alt="tp 8 hal web" src="https://github.com/user-attachments/assets/0a243df3-5948-4dcd-a43a-1b4625090c24" />
Add Lecturer
<img width="1917" height="1027" alt="tp 8 add home" src="https://github.com/user-attachments/assets/b713e1a2-b80d-4eb6-9b3d-a34b7125c599" />
Edit Lecturer
<img width="1917" height="1022" alt="tp 8 edit home" src="https://github.com/user-attachments/assets/87bd6dc1-efed-4f80-a18e-14969c117e69" />
Delete Home
<img width="1917" height="1020" alt="tp 8 delete home" src="https://github.com/user-attachments/assets/2221cdfc-3b43-4d36-9bde-dfe732f74569" />

Halaman Department
<img width="1917" height="1017" alt="tp 8 hal department" src="https://github.com/user-attachments/assets/34c4e252-ff55-4795-8aac-f0590e6d996b" />
Add Department
<img width="1915" height="1020" alt="tp 8 add department" src="https://github.com/user-attachments/assets/65a372a6-3e63-4b9a-8dd8-3399d7278925" />
Edit Department
<img width="1917" height="1022" alt="tp 8 edit department" src="https://github.com/user-attachments/assets/cbf2287d-ae1d-465e-869c-5dc9cc9b5e41" />
Delete deoartment
<img width="1916" height="1017" alt="tp 8 delete department" src="https://github.com/user-attachments/assets/0a64243e-0600-42f8-9363-0a99fe6a1ad9" />

Halaman Courses
<img width="1911" height="1017" alt="tp 8 hal courses" src="https://github.com/user-attachments/assets/b3dc4709-1745-4db3-9c58-e17c2e2818dc" />
Add Courses
<img width="1917" height="1021" alt="tp 8 add courses" src="https://github.com/user-attachments/assets/648ca72c-44fb-4f93-9dea-2cfac491b8ae" />
Edit Courses
<img width="1915" height="1022" alt="tp 8 edit courses" src="https://github.com/user-attachments/assets/68cc2814-e82e-4fa0-bace-ebd30527979e" />
Delete Courses
<img width="1916" height="1017" alt="tp 8 delete courses" src="https://github.com/user-attachments/assets/2179c15e-28a7-4cbf-a401-faf8f15f9706" />






