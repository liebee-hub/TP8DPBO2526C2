<?php

// Halaman utama (Lecturers).
// File ini hanya memilih aksi yang dijalankan controller berdasarkan request.
include_once("controllers/LecturerController.php");

$lecturer = new LecturerController();

if (isset($_POST['add'])) {
    // Form tambah dikirim
    $lecturer->add($_POST);
} else if (isset($_POST['update'])) {
    // Form ubah dikirim
    $lecturer->update($_POST);
} else if (!empty($_GET['id_hapus'])) {
    // Tombol Delete ditekan
    $lecturer->delete($_GET['id_hapus']);
} else if (!empty($_GET['id_edit'])) {
    // Tombol Edit ditekan
    $lecturer->index($_GET['id_edit']);
} else {
    // Buka halaman biasa
    $lecturer->index();
}
