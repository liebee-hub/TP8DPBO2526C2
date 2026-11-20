<?php

include_once("models/DB.php");

// Model untuk tabel departments (tabel baru)
class Department extends DB
{
    // Ambil semua departemen
    function getDepartment()
    {
        $query = "SELECT * FROM departments ORDER BY id";
        return $this->execute($query);
    }

    // Ambil satu departemen berdasarkan id
    function getDepartmentById($id)
    {
        $id = (int) $id;
        $query = "SELECT * FROM departments WHERE id = $id";
        $this->execute($query);
        return $this->getResult();
    }

    // Tambah departemen
    function addDepartment($data)
    {
        $name = $this->escape($data['name']);
        $building = $this->escape($data['building']);
        $query = "INSERT INTO departments (name, building) VALUES ('$name', '$building')";
        return $this->execute($query);
    }

    // Ubah departemen
    function updateDepartment($id, $data)
    {
        $id = (int) $id;
        $name = $this->escape($data['name']);
        $building = $this->escape($data['building']);
        $query = "UPDATE departments SET name = '$name', building = '$building' WHERE id = $id";
        return $this->execute($query);
    }

    // Hapus departemen
    function deleteDepartment($id)
    {
        $id = (int) $id;
        $query = "DELETE FROM departments WHERE id = $id";
        return $this->execute($query);
    }
}
