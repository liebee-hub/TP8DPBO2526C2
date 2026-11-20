<?php

// Class Template: membaca file .html dari folder templates/,
// mengganti penanda (placeholder) seperti DATA_TABEL dengan data asli,
// lalu menampilkannya ke browser.
class Template
{
    private $content;

    // Baca file html, lalu pasang navbar ke dalamnya
    function __construct($filename)
    {
        $this->content = file_get_contents($filename);

        $navbar = file_get_contents("templates/navbar.html");
        $this->content = str_replace("DATA_NAVBAR", $navbar, $this->content);
    }

    // Ganti satu placeholder dengan nilai baru
    function replace($old, $new)
    {
        $this->content = str_replace($old, $new, $this->content);
    }

    // Tandai menu navbar yang sedang aktif: 'lecturer', 'department', atau 'course'
    function setActiveMenu($page)
    {
        $menus = array('lecturer', 'department', 'course');

        foreach ($menus as $menu) {
            $placeholder = "DATA_ACTIVE_" . strtoupper($menu);
            if ($menu == $page) {
                $this->replace($placeholder, "active");
            } else {
                $this->replace($placeholder, "");
            }
        }
    }

    // Tampilkan hasil akhir ke browser
    function write()
    {
        echo $this->content;
    }

    // Mengamankan teks sebelum ditampilkan di HTML (mencegah XSS)
    static function safe($text)
    {
        return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
    }
}
