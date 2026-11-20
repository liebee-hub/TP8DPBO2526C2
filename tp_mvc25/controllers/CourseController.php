<?php

include_once("config.php");
include_once("models/Course.php");
include_once("models/Lecturer.php");
include_once("views/CourseView.php");

// Controller untuk halaman Courses.
class CourseController
{
    private $course;
    private $lecturer;

    function __construct()
    {
        $this->course = new Course(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->lecturer = new Lecturer(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    // Menampilkan halaman. Jika $id_edit diisi, form berada dalam mode edit.
    function index($id_edit = null)
    {
        // Ambil semua mata kuliah dari model, simpan ke array
        $this->course->getCourse();
        $courses = array();
        while ($row = $this->course->getResult()) {
            array_push($courses, $row);
        }

        // Ambil semua dosen (untuk dropdown)
        $this->lecturer->getLecturer();
        $lecturers = array();
        while ($row = $this->lecturer->getResult()) {
            array_push($lecturers, $row);
        }

        // Ambil data mata kuliah yang mau diubah (jika ada)
        $edit = null;
        if ($id_edit != null) {
            $edit = $this->course->getCourseById($id_edit);
        }

        // Kirim ke view
        $view = new CourseView();
        $view->render($courses, $lecturers, $edit);
    }

    function add($data)
    {
        $this->course->addCourse($data);
        header("location:course.php");
        exit;
    }

    function update($data)
    {
        $this->course->updateCourse($data['id'], $data);
        header("location:course.php");
        exit;
    }

    function delete($id)
    {
        $this->course->deleteCourse($id);
        header("location:course.php");
        exit;
    }
}
