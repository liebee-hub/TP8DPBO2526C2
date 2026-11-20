<?php

include_once("views/Template.php");

// View untuk halaman Courses.
class CourseView
{
    // $courses   : array semua mata kuliah
    // $lecturers : array semua dosen (untuk pilihan dropdown)
    // $edit      : array data mata kuliah yang sedang diubah (null jika mode tambah)
    function render($courses, $lecturers, $edit)
    {
        $page = new Template("templates/course.html");
        $page->setActiveMenu('course');

        // ----- Isi baris tabel -----
        $rows = "";
        foreach ($courses as $row) {
            $rows .= "<tr>
                <th>" . Template::safe($row['id']) . "</th>
                <td>" . Template::safe($row['code']) . "</td>
                <td>" . Template::safe($row['name']) . "</td>
                <td>" . Template::safe($row['credits']) . "</td>
                <td>" . Template::safe($row['lecturer_name']) . "</td>
                <td>
                    <a class='btn btn-success btn-sm' href='course.php?id_edit=" . $row['id'] . "'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='course.php?id_hapus=" . $row['id'] . "'
                       onclick=\"return confirm('Hapus mata kuliah ini?')\">Delete</a>
                </td>
            </tr>";
        }

        // ----- Isi form (kosong jika tambah, terisi jika edit) -----
        if ($edit == null) {
            $title = "Add Course";
            $color = "bg-primary";
            $buttonName = "add";
            $buttonText = "Add";
            $cancel = "";
            $edit = array('id' => '', 'code' => '', 'name' => '', 'credits' => '', 'lecturer_id' => '');
        } else {
            $title = "Edit Course";
            $color = "bg-warning";
            $buttonName = "update";
            $buttonText = "Update";
            $cancel = "<a class='btn btn-info' href='course.php'>Cancel</a>";
        }

        // ----- Pilihan dropdown dosen -----
        $options = "<option value=''>-- Pilih Lecturer --</option>";
        foreach ($lecturers as $lecturer) {
            $selected = "";
            if ($lecturer['id'] == $edit['lecturer_id']) {
                $selected = "selected";
            }
            $options .= "<option value='" . $lecturer['id'] . "' $selected>"
                . Template::safe($lecturer['name']) . "</option>";
        }

        // ----- Ganti placeholder pada template -----
        $page->replace("DATA_FORM_TITLE", $title);
        $page->replace("DATA_FORM_COLOR", $color);
        $page->replace("DATA_BUTTON_NAME", $buttonName);
        $page->replace("DATA_BUTTON_TEXT", $buttonText);
        $page->replace("DATA_CANCEL", $cancel);
        $page->replace("DATA_ID", Template::safe($edit['id']));
        $page->replace("DATA_CODE", Template::safe($edit['code']));
        $page->replace("DATA_NAME", Template::safe($edit['name']));
        $page->replace("DATA_CREDITS", Template::safe($edit['credits']));
        $page->replace("DATA_LECTURER_OPTIONS", $options);
        $page->replace("DATA_TABEL", $rows);

        $page->write();
    }
}
