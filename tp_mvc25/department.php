<?php

// Halaman Departments.
include_once("controllers/DepartmentController.php");

$department = new DepartmentController();

if (isset($_POST['add'])) {
    $department->add($_POST);
} else if (isset($_POST['update'])) {
    $department->update($_POST);
} else if (!empty($_GET['id_hapus'])) {
    $department->delete($_GET['id_hapus']);
} else if (!empty($_GET['id_edit'])) {
    $department->index($_GET['id_edit']);
} else {
    $department->index();
}
