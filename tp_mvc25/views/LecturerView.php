<?php

include_once("views/Template.php");

// View untuk halaman Lecturers.
// Tugas view hanya menampilkan data yang dikirim oleh controller.
class LecturerView
{
    // $lecturers   : array semua dosen
    // $departments : array semua departemen (untuk pilihan dropdown)
    // $edit        : array data dosen yang sedang diubah (null jika mode tambah)
    function render($lecturers, $departments, $edit)
    {
        $page = new Template("templates/lecturer.html");
        $page->setActiveMenu('lecturer');

        // ----- Isi baris tabel -----
        $rows = "";
        foreach ($lecturers as $row) {
            $department = $row['department_name'];
            if ($department == null) {
                $department = "-";
            }

            $rows .= "<tr>
                <th>" . Template::safe($row['id']) . "</th>
                <td>" . Template::safe($row['name']) . "</td>
                <td>" . Template::safe($row['nidn']) . "</td>
                <td>" . Template::safe($row['phone']) . "</td>
                <td>" . Template::safe($row['join_date']) . "</td>
                <td>" . Template::safe($department) . "</td>
                <td>
                    <a class='btn btn-success btn-sm' href='index.php?id_edit=" . $row['id'] . "'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='index.php?id_hapus=" . $row['id'] . "'
                       onclick=\"return confirm('Hapus data dosen ini?')\">Delete</a>
                </td>
            </tr>";
        }

        // ----- Isi form (kosong jika tambah, terisi jika edit) -----
        if ($edit == null) {
            $title = "Add Lecturer";
            $color = "bg-primary";
            $buttonName = "add";
            $buttonText = "Add";
            $cancel = "";
            $edit = array('id' => '', 'name' => '', 'nidn' => '', 'phone' => '',
                          'join_date' => '', 'department_id' => '');
        } else {
            $title = "Edit Lecturer";
            $color = "bg-warning";
            $buttonName = "update";
            $buttonText = "Update";
            $cancel = "<a class='btn btn-info' href='index.php'>Cancel</a>";
        }

        // ----- Pilihan dropdown departemen -----
        $options = "<option value=''>-- Pilih Department --</option>";
        foreach ($departments as $dept) {
            $selected = "";
            if ($dept['id'] == $edit['department_id']) {
                $selected = "selected";
            }
            $options .= "<option value='" . $dept['id'] . "' $selected>"
                . Template::safe($dept['name']) . "</option>";
        }

        // ----- Ganti placeholder pada template -----
        $page->replace("DATA_FORM_TITLE", $title);
        $page->replace("DATA_FORM_COLOR", $color);
        $page->replace("DATA_BUTTON_NAME", $buttonName);
        $page->replace("DATA_BUTTON_TEXT", $buttonText);
        $page->replace("DATA_CANCEL", $cancel);
        $page->replace("DATA_ID", Template::safe($edit['id']));
        $page->replace("DATA_NAME", Template::safe($edit['name']));
        $page->replace("DATA_NIDN", Template::safe($edit['nidn']));
        $page->replace("DATA_PHONE", Template::safe($edit['phone']));
        $page->replace("DATA_JOIN_DATE", Template::safe($edit['join_date']));
        $page->replace("DATA_DEPARTMENT_OPTIONS", $options);
        $page->replace("DATA_TABEL", $rows);

        $page->write();
    }
}
