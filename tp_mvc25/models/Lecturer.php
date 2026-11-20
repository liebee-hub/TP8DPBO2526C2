<?php

include_once("models/DB.php");

// Model untuk tabel lecturers (tabel yang sudah ada dari kode awal)
// Atribut baru: department_id (relasi ke tabel departments)
class Lecturer extends DB
{
    // Ambil semua dosen beserta nama departemennya (JOIN)
    function getLecturer()
    {
        $query = "SELECT lecturers.*, departments.name AS department_name
                  FROM lecturers
                  LEFT JOIN departments ON lecturers.department_id = departments.id
                  ORDER BY lecturers.id";
        return $this->execute($query);
    }

    // Ambil satu dosen berdasarkan id
    function getLecturerById($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM lecturers WHERE id = $id";
        $this->execute($query);
        return $this->getResult();
    }

    // Tambah dosen
    function addLecturer($data)
    {
        $name = $this->escape($data['name']);
        $nidn = $this->escape($data['nidn']);
        $phone = $this->escape($data['phone']);
        $join_date = $this->escape($data['join_date']);
        $department_id = $this->getDepartmentValue($data['department_id']);

        $query = "INSERT INTO lecturers (name, nidn, phone, join_date, department_id)
                  VALUES ('$name', '$nidn', '$phone', '$join_date', $department_id)";
        return $this->execute($query);
    }

    // Ubah dosen
    function updateLecturer($id, $data)
    {
        $id = (int) $id;
        $name = $this->escape($data['name']);
        $nidn = $this->escape($data['nidn']);
        $phone = $this->escape($data['phone']);
        $join_date = $this->escape($data['join_date']);
        $department_id = $this->getDepartmentValue($data['department_id']);

        $query = "UPDATE lecturers
                  SET name = '$name', nidn = '$nidn', phone = '$phone',
                      join_date = '$join_date', department_id = $department_id
                  WHERE id = $id";
        return $this->execute($query);
    }

    // Hapus dosen
    function deleteLecturer($id)
    {
        $id = (int) $id;
        $query = "DELETE FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }

    // Jika departemen tidak dipilih, simpan NULL. Jika dipilih, simpan angkanya.
    private function getDepartmentValue($department_id)
    {
        if ($department_id === '' || $department_id === null) {
            return "NULL";
        }
        return (int) $department_id;
    }
}
