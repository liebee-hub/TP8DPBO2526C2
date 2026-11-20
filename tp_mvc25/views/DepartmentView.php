<?php

include_once("views/Template.php");

// View untuk halaman Departments.
class DepartmentView
{
    // $departments : array semua departemen
    // $edit        : array data departemen yang sedang diubah (null jika mode tambah)
    function render($departments, $edit)
    {
        $page = new Template("templates/department.html");
        $page->setActiveMenu('department');

        // ----- Isi baris tabel -----
        $rows = "";
        foreach ($departments as $row) {
            $rows .= "<tr>
                <th>" . Template::safe($row['id']) . "</th>
                <td>" . Template::safe($row['name']) . "</td>
                <td>" . Template::safe($row['building']) . "</td>
                <td>
                    <a class='btn btn-success btn-sm' href='department.php?id_edit=" . $row['id'] . "'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='department.php?id_hapus=" . $row['id'] . "'
                       onclick=\"return confirm('Hapus department ini?')\">Delete</a>
                </td>
            </tr>";
        }

        // ----- Isi form (kosong jika tambah, terisi jika edit) -----
        if ($edit == null) {
            $title = "Add Department";
            $color = "bg-primary";
            $buttonName = "add";
            $buttonText = "Add";
            $cancel = "";
            $edit = array('id' => '', 'name' => '', 'building' => '');
        } else {
            $title = "Edit Department";
            $color = "bg-warning";
            $buttonName = "update";
            $buttonText = "Update";
            $cancel = "<a class='btn btn-info' href='department.php'>Cancel</a>";
        }

        // ----- Ganti placeholder pada template -----
        $page->replace("DATA_FORM_TITLE", $title);
        $page->replace("DATA_FORM_COLOR", $color);
        $page->replace("DATA_BUTTON_NAME", $buttonName);
        $page->replace("DATA_BUTTON_TEXT", $buttonText);
        $page->replace("DATA_CANCEL", $cancel);
        $page->replace("DATA_ID", Template::safe($edit['id']));
        $page->replace("DATA_NAME", Template::safe($edit['name']));
        $page->replace("DATA_BUILDING", Template::safe($edit['building']));
        $page->replace("DATA_TABEL", $rows);

        $page->write();
    }
}
