<?php

include_once("models/DB.php");

// Model untuk tabel courses (tabel baru)
// Relasi: setiap mata kuliah diajar oleh satu dosen (courses.lecturer_id -> lecturers.id)
class Course extends DB
{
    // Ambil semua mata kuliah beserta nama dosen pengajarnya (JOIN)
    function getCourse()
    {
        $query = "SELECT courses.*, lecturers.name AS lecturer_name
                  FROM courses
                  JOIN lecturers ON courses.lecturer_id = lecturers.id
                  ORDER BY courses.id";
        return $this->execute($query);
    }

    // Ambil satu mata kuliah berdasarkan id
    function getCourseById($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM courses WHERE id = $id";
        $this->execute($query);
        return $this->getResult();
    }

    // Tambah mata kuliah
    function addCourse($data)
    {
        $code = $this->escape($data['code']);
        $name = $this->escape($data['name']);
        $credits = (int) $data['credits'];
        $lecturer_id = (int) $data['lecturer_id'];

        $query = "INSERT INTO courses (code, name, credits, lecturer_id)
                  VALUES ('$code', '$name', $credits, $lecturer_id)";
        return $this->execute($query);
    }

    // Ubah mata kuliah
    function updateCourse($id, $data)
    {
        $id = (int) $id;
        $code = $this->escape($data['code']);
        $name = $this->escape($data['name']);
        $credits = (int) $data['credits'];
        $lecturer_id = (int) $data['lecturer_id'];

        $query = "UPDATE courses
                  SET code = '$code', name = '$name', credits = $credits, lecturer_id = $lecturer_id
                  WHERE id = $id";
        return $this->execute($query);
    }

    // Hapus mata kuliah
    function deleteCourse($id)
    {
        $id = (int) $id;
        $query = "DELETE FROM courses WHERE id = $id";
        return $this->execute($query);
    }
}
