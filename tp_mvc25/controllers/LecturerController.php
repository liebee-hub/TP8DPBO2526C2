<?php

include_once("config.php");
include_once("models/Lecturer.php");
include_once("models/Department.php");
include_once("views/LecturerView.php");

// Controller untuk halaman Lecturers.
// Controller menerima request, memanggil model untuk mengolah data,
// lalu mengirim hasilnya ke view.
class LecturerController
{
    private $lecturer;
    private $department;

    function __construct()
    {
        $this->lecturer = new Lecturer(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->department = new Department(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Menampilkan halaman. Jika $id_edit diisi, form berada dalam mode edit.
    function index($id_edit = null)
    {
        // Ambil semua dosen dari model, simpan ke array
        $this->lecturer->getLecturer();
        $lecturers = array();
        while ($row = $this->lecturer->getResult()) {
            array_push($lecturers, $row);
        }

        // Ambil semua departemen (untuk dropdown)
        $this->department->getDepartment();
        $departments = array();
        while ($row = $this->department->getResult()) {
            array_push($departments, $row);
        }

        // Ambil data dosen yang mau diubah (jika ada)
        $edit = null;
        if ($id_edit != null) {
            $edit = $this->lecturer->getLecturerById($id_edit);
        }

        // Kirim ke view
        $view = new LecturerView();
        $view->render($lecturers, $departments, $edit);
    }

    function add($data)
    {
        $this->lecturer->addLecturer($data);
        header("location:index.php");
        exit;
    }

    function update($data)
    {
        $this->lecturer->updateLecturer($data['id'], $data);
        header("location:index.php");
        exit;
    }

    function delete($id)
    {
        $this->lecturer->deleteLecturer($id);
        header("location:index.php");
        exit;
    }
}
