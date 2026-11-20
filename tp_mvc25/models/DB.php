<?php

// Class DB: mengurus koneksi dan eksekusi query ke database.
// Semua class model (Lecturer, Department, Course) mewarisi class ini.
class DB
{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_link;
    private $result;

    // Constructor: menyimpan data koneksi dan langsung membuka koneksi
    function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->open();
    }

    // Membuka koneksi ke database
    function open()
    {
        $this->db_link = mysqli_connect(
            $this->db_host,
            $this->db_user,
            $this->db_pass,
            $this->db_name
        );

        if (!$this->db_link) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    // Menjalankan query, hasilnya disimpan di $this->result
    function execute($query)
    {
        $this->result = mysqli_query($this->db_link, $query);

        if (!$this->result) {
            die("Invalid query: " . mysqli_error($this->db_link));
        }

        return $this->result;
    }

    // Mengambil satu baris hasil query (array asosiatif), false jika sudah habis
    function getResult()
    {
        return mysqli_fetch_assoc($this->result);
    }

    // Membersihkan teks agar aman dimasukkan ke query (mencegah SQL injection)
    function escape($text)
    {
        return mysqli_real_escape_string($this->db_link, $text);
    }

    // Menutup koneksi
    function close()
    {
        mysqli_close($this->db_link);
    }
}
