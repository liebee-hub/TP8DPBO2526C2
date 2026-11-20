<?php

// Halaman Courses.
include_once("controllers/CourseController.php");

$course = new CourseController();

if (isset($_POST['add'])) {
    $course->add($_POST);
} else if (isset($_POST['update'])) {
    $course->update($_POST);
} else if (!empty($_GET['id_hapus'])) {
    $course->delete($_GET['id_hapus']);
} else if (!empty($_GET['id_edit'])) {
    $course->index($_GET['id_edit']);
} else {
    $course->index();
}
