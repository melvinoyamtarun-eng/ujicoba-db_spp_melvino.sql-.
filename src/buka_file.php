<?php

if (isset($_GET['open'])) {

    // Jika mendapatkan variable URL ?open
    switch ($_GET['open']) {

        case 'informasi_utama':
            if (!file_exists("informasi_utama.php")) {
                die("File tidak ada !");
            }

            include "informasi_utama.php";
            break;


        // =========================
        // DATA SPP
        // =========================

        case 'data_spp':
            if (!file_exists("data_spp.php")) {
                die("File tidak ada !");
            }

            include "data_spp.php";
            break;


        // =========================
        // TAMBAH SPP
        // =========================

        case 'tambah_spp':
            if (!file_exists("tambah_spp.php")) {
                die("File tidak ada !");
            }

            include "tambah_spp.php";
            break;


        // =========================
        // HAPUS SPP
        // =========================

        case 'hapus_spp':
            if (!file_exists("hapus_spp.php")) {
                die("File tidak ada !");
            }

            include "hapus_spp.php";
            break;


        // =========================
        // EDIT SPP
        // =========================

        case 'edit_spp':
            if (!file_exists("edit_spp.php")) {
                die("File tidak ada !");
            }

            include "edit_spp.php";
            break;


        // =========================
        // HALAMAN DEFAULT
        // =========================

        default:
            if (!file_exists("informasi_utama.php")) {
                die("File tidak ada !");
            }

            include "informasi_utama.php";
            break;
    }

} else {

    // Jika tidak ada ?open=
    if (!file_exists("informasi_utama.php")) {
        die("File tidak ada !");
    }

    include "informasi_utama.php";
}

?>