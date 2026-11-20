<?php

include_once("config.php");
include_once("models/Department.php");
include_once("views/DepartmentView.php");

// Controller untuk halaman Departments.
class DepartmentController
{
    private $department;

    function __construct()
    {
        $this->department = new Department(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Menampilkan halaman. Jika $id_edit diisi, form berada dalam mode edit.
    function index($id_edit = null)
    {
        // Ambil semua departemen dari model, simpan ke array
        $this->department->getDepartment();
        $departments = array();
        while ($row = $this->department->getResult()) {
            array_push($departments, $row);
        }

        // Ambil data departemen yang mau diubah (jika ada)
        $edit = null;
        if ($id_edit != null) {
            $edit = $this->department->getDepartmentById($id_edit);
        }

        // Kirim ke view
        $view = new DepartmentView();
        $view->render($departments, $edit);
    }

    function add($data)
    {
        $this->department->addDepartment($data);
        header("location:department.php");
        exit;
    }

    function update($data)
    {
        $this->department->updateDepartment($data['id'], $data);
        header("location:department.php");
        exit;
    }

    function delete($id)
    {
        $this->department->deleteDepartment($id);
        header("location:department.php");
        exit;
    }
}
