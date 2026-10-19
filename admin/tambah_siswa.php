<?php
include_once "../src/koneksi.php";

// Array bulan untuk membuat tagihan otomatis
$arraybulan = array(
    "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember",
    "Januari", "Februari", "Maret", "April", "Mei", "Juni"
);

// =====================================================
// SKRIP TOMBOL SIMPAN
// =====================================================
if (isset($_POST['btnSimpan'])) {

    $nisn     = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $nis      = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_telp  = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $id_spp   = mysqli_real_escape_string($koneksi, $_POST['id_spp']);

    // Validasi
    $pesanError = array();

    if (trim($nisn) == "") {
        $pesanError[] = "Data <b>NISN</b> tidak boleh kosong!";
    }

    if (trim($nis) == "") {
        $pesanError[] = "Data <b>NIS</b> tidak boleh kosong!";
    }

    if (trim($nama) == "") {
        $pesanError[] = "Data <b>NAMA</b> tidak boleh kosong!";
    }

    if ($id_kelas == "" || $id_kelas == "Kosong") {
        $pesanError[] = "Data <b>KELAS</b> harus dipilih!";
    }

    if (trim($alamat) == "") {
        $pesanError[] = "Data <b>ALAMAT</b> tidak boleh kosong!";
    }

    if (trim($no_telp) == "") {
        $pesanError[] = "Data <b>NOMOR TELEPON</b> tidak boleh kosong!";
    }

    if ($id_spp == "" || $id_spp == "Kosong") {
        $pesanError[] = "Data <b>SPP</b> harus dipilih!";
    }

    // =====================================================
    // JIKA ADA ERROR
    // =====================================================
    if (count($pesanError) >= 1) {

        $noPesan = 0;

        foreach ($pesanError as $pesan_tampil) {
            $noPesan++;
            echo "&nbsp; $noPesan. $pesan_tampil<br>";
        }

        echo "<br>";

    } else {

        // =====================================================
        // SIMPAN DATA SISWA
        // =====================================================
        $sql = mysqli_query(
            $koneksi,
            "INSERT INTO siswa
            (nisn, nis, nama, id_kelas, alamat, no_telp, id_spp)
            VALUES
            ('$nisn', '$nis', '$nama', '$id_kelas', '$alamat', '$no_telp', '$id_spp')"
        );

        if ($sql) {

            // =====================================================
            // MEMBUAT TAGIHAN OTOMATIS 12 BULAN
            // =====================================================

            // Tahun ajaran dimulai dari bulan Juli
            $tahunsekarang = date('Y');

            // Jika sekarang Januari-Juni, berarti tahun ajaran
            // dimulai dari tahun sebelumnya
            if (date('n') <= 6) {
                $tahunsekarang--;
            }

            for ($i = 0; $i < 12; $i++) {

                $bulan = $arraybulan[$i];

                // Januari-Juni menggunakan tahun berikutnya
                if ($i >= 6) {
                    $tahun_tagihan = $tahunsekarang + 1;
                } else {
                    $tahun_tagihan = $tahunsekarang;
                }

                mysqli_query(
                    $koneksi,
                    "INSERT INTO pembayaran
                    (nisn, bulan_tagihan, tahun_tagihan, id_spp)
                    VALUES
                    ('$nisn', '$bulan', '$tahun_tagihan', '$id_spp')"
                );
            }

            echo "
            <center>
                <b>
                    <font color='red' size='4'>
                        <p>Data Berhasil Disimpan</p>
                    </font>
                </b>
            </center>
            ";

            echo "<meta http-equiv='refresh' content='2; url=?open=data_siswa'>";

        } else {

            echo "
            <center>
                <b>
                    <font color='red' size='4'>
                        <p>Data Gagal Disimpan!</p>
                    </font>
                </b>
            </center>
            ";

            echo "<meta http-equiv='refresh' content='2; url=?open=data_siswa'>";
        }

        exit;
    }
}
?>

<!-- =====================================================
     FORM TAMBAH SISWA
===================================================== -->

<form action="" method="post">

    <table cellspacing="1" cellpadding="3">

        <tr>
            <td colspan="3" bgcolor="#CCCCCC">
                <strong>TAMBAH DATA SISWA</strong>
            </td>
        </tr>

        <tr>
            <td>NISN</td>
            <td>:</td>
            <td>
                <input
                    name="nisn"
                    type="text"
                    size="10"
                    maxlength="10"
                    value="<?php echo isset($_POST['nisn']) ? htmlspecialchars($_POST['nisn']) : ''; ?>"
                />
            </td>
        </tr>

        <tr>
            <td>NIS</td>
            <td>:</td>
            <td>
                <input
                    name="nis"
                    type="text"
                    size="20"
                    maxlength="10"
                    value="<?php echo isset($_POST['nis']) ? htmlspecialchars($_POST['nis']) : ''; ?>"
                />
            </td>
        </tr>

        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td>
                <input
                    name="nama"
                    type="text"
                    size="50"
                    maxlength="50"
                    value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>"
                />
            </td>
        </tr>

        <tr>
            <td>KELAS</td>
            <td>:</td>
            <td>
                <select name="id_kelas">

                    <option value="Kosong">. . . . .</option>

                    <?php
                    $tampilkanKelas = mysqli_query(
                        $koneksi,
                        "SELECT * FROM kelas ORDER BY nama_kelas ASC"
                    );

                    while ($bacaData = mysqli_fetch_assoc($tampilkanKelas)) {

                        $selected = "";

                        if (
                            isset($_POST['id_kelas']) &&
                            $_POST['id_kelas'] == $bacaData['id_kelas']
                        ) {
                            $selected = "selected";
                        }

                        echo "
                        <option
                            value='" . htmlspecialchars($bacaData['id_kelas']) . "'
                            $selected
                        >
                            " . htmlspecialchars($bacaData['nama_kelas']) . "
                        </option>
                        ";
                    }
                    ?>

                </select>
            </td>
        </tr>

        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>
                <input
                    name="alamat"
                    type="text"
                    size="50"
                    maxlength="50"
                    value="<?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?>"
                />
            </td>
        </tr>

        <tr>
            <td>No. Telepon</td>
            <td>:</td>
            <td>
                <input
                    name="no_telp"
                    type="text"
                    size="50"
                    maxlength="50"
                    value="<?php echo isset($_POST['no_telp']) ? htmlspecialchars($_POST['no_telp']) : ''; ?>"
                />
            </td>
        </tr>

        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td>

                <select name="id_spp">

                    <option value="Kosong">. . . . .</option>

                    <?php
                    $tampilkanSPP = mysqli_query(
                        $koneksi,
                        "SELECT * FROM spp ORDER BY id_spp ASC"
                    );

                    while ($bacaData = mysqli_fetch_assoc($tampilkanSPP)) {

                        $selected = "";

                        if (
                            isset($_POST['id_spp']) &&
                            $_POST['id_spp'] == $bacaData['id_spp']
                        ) {
                            $selected = "selected";
                        }

                        /*
                         * Sesuaikan nama kolom berikut dengan struktur
                         * tabel spp Anda.
                         *
                         * Umumnya:
                         * - id_spp
                         * - tahun
                         * - nominal
                         */

                        echo "
                        <option
                            value='" . htmlspecialchars($bacaData['id_spp']) . "'
                            $selected
                        >
                            Rp " . number_format($bacaData['nominal'], 0, ',', '.') . "
                        </option>
                        ";
                    }
                    ?>

                </select>

            </td>
        </tr>

        <tr>
            <td colspan="3">

                <input
                    type="submit"
                    name="btnSimpan"
                    value="Simpan"
                />

                <input
                    type="reset"
                    value="Reset"
                />

            </td>
        </tr>

    </table>

</form>
