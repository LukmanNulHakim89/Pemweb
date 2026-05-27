<?php
    // Memulai session untuk menyimpan data antar request
    session_start();

    // Array pajak bandara asal beserta nominalnya (dalam rupiah)
    $asalTaxes = [
        "Abdul Rachman Saleh" => 40000,
        "Husein Sastranegara" => 50000,
        "Juanda" => 30000,
        "Soekarno Hatta" => 65000,
    ];

    // Array pajak bandara tujuan beserta nominalnya (dalam rupiah)
    $tujuanTaxes = [
        "Hasanuddin" => 70000,
        "Inanwatan" => 90000,
        "Ngurah Rai" => 85000,
        "Sultan Iskandar Muda" => 60000,
    ];

    // Mengurutkan array pajak asal berdasarkan key (nama bandara) secara alfabetis
    ksort($asalTaxes);
    // Mengurutkan array pajak tujuan berdasarkan key (nama bandara) secara alfabetis
    ksort($tujuanTaxes);

    // Mengambil hanya nama-nama bandara asal (keys dari array) untuk ditampilkan di dropdown
    $bandaraAsal = array_keys($asalTaxes);
    // Mengambil hanya nama-nama bandara tujuan (keys dari array) untuk ditampilkan di dropdown
    $bandaraTujuan = array_keys($tujuanTaxes);

    // Mengecek apakah variabel session noKeberangkatan sudah ada
    // Jika belum, inisialisasi dengan nilai 1 sebagai nomor pertama
    if (!isset($_SESSION['noKeberangkatan'])) {
        $_SESSION['noKeberangkatan'] = 1;
    }

    // Mengecek apakah form telah disubmit (tombol "kirim" ditekan)
    if (isset($_POST["kirim"])) {
        // Mengambil nomor keberangkatan saat ini dari session
        $noKeberangkatan = $_SESSION['noKeberangkatan'];
        // Menaikkan nomor keberangkatan di session sebesar 1 untuk pengisian berikutnya
        $_SESSION['noKeberangkatan']++;

        // Mengambil semua data yang dikirim dari form input
        $tanggalInput = $_POST["tanggalInput"];           // Tanggal dan waktu saat form disubmit
        $NamaMaskapai = $_POST["inputNamaMaskapai"];      // Nama maskapai penerbangan
        $asalPenerbangan = $_POST["inputAsalPenerbangan"]; // Bandara asal yang dipilih
        $tujuanPenerbangan = $_POST["inputTujuanPenerbangan"]; // Bandara tujuan yang dipilih
        $hargaTiket = $_POST["inputHarga"];               // Harga tiket dasar yang diinput

        // Mengambil nilai pajak bandara asal berdasarkan nama bandara yang dipilih
        // Jika nama bandara tidak ditemukan di array, nilai default-nya adalah 0
        $pajakAsal = $asalTaxes[$asalPenerbangan] ?? 0;
        // Mengambil nilai pajak bandara tujuan berdasarkan nama bandara yang dipilih
        // Jika nama bandara tidak ditemukan di array, nilai default-nya adalah 0
        $pajakTujuan = $tujuanTaxes[$tujuanPenerbangan] ?? 0;

        // Menghitung total pajak dengan menjumlahkan pajak asal dan pajak tujuan
        $totalPajak = $pajakAsal + $pajakTujuan;
        // Menghitung total harga tiket akhir (harga dasar + total pajak)
        $totalHargaTiket = $totalPajak + $hargaTiket;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,400;0,700;0,900;1,100&display=swap" rel="stylesheet">
    <title>Penghitung Harga Tiket</title>
</head>
<body>
    <div class="container">
        <!-- Input Form -->
        <section class="inputForm">
            <h3 class="title">INPUT FORM</h3>
            <div class="content">
                <form action="" method="post">
                    <!-- Input tersembunyi untuk menyimpan tanggal dan waktu saat form disubmit -->
                    <input type="hidden" name="tanggalInput" value="<?=date("l jS \of F Y h:i:s A")?>">

                    <label for="inputNamaMaskapai">Nama Maskapai</label>
                    <br>
                    <!-- Input teks untuk nama maskapai penerbangan -->
                    <input type="text" name="inputNamaMaskapai" id="inputNamaMaskapai">
                    <br>

                    <label for="inputAsalPenerbangan">Pilih Bandara Asal:</label>
                    <br>
                    <!-- Dropdown untuk memilih bandara asal, di-generate dari array $bandaraAsal -->
                    <select name="inputAsalPenerbangan" id="inputAsalPenerbangan">
                        <?php foreach ($bandaraAsal as $bA) {?>
                            <!-- Setiap opsi menggunakan nama bandara sebagai value dan teks yang ditampilkan -->
                            <option value="<?php echo $bA?>"><?php echo $bA?></option>
                            <?php } ?>
                        </select>
                    <br>

                    <label for="inputTujuanPenerbangan">Pilih Bandara Tujuan:</label>
                    <br>
                    <!-- Dropdown untuk memilih bandara tujuan, di-generate dari array $bandaraTujuan -->
                    <select name="inputTujuanPenerbangan" id="inputTujuanPenerbangan">
                        <?php foreach ($bandaraTujuan as $bT) {?>
                            <!-- Setiap opsi menggunakan nama bandara sebagai value dan teks yang ditampilkan -->
                            <option value="<?php echo $bT?>"><?php echo $bT?></option>
                        <?php } ?>
                    </select>
                    <br>

                    <label for="inputHarga">Harga Tiket</label>
                    <br>
                    <!-- Input angka untuk harga tiket dasar sebelum pajak -->
                    <input type="number" name="inputHarga" id="inputHarga">
                    <br>
                    <!-- Tombol submit untuk mengirim form dan memproses perhitungan -->
                    <button type="submit" name="kirim">Hitung</button>  
                </form>
            </div>

            <footer>
                <p>&copy;2026 Lukman Nul Hakim.</p>
            </footer>

        </section>
        <!-- endof Input Form -->

        <!-- Output -->
        <!-- Bagian informasi hanya ditampilkan jika form telah disubmit -->
        <?php if (isset($_POST["kirim"])) {?>
            <section class="information">
                <h3 class="title">INFORMASI</h3>
                <div class="content">
                    <!-- Menampilkan nomor keberangkatan yang diambil dari session -->
                    <label for="nomor">Nomor</label>
                    <br>
                    <input type="text" name="nomor" id="nomor" value="<?=htmlspecialchars($noKeberangkatan)?>" disabled>
                    <br>

                    <!-- Menampilkan tanggal dan waktu saat form disubmit -->
                    <label for="tanggal">Tanggal</label>
                    <br>
                    <input type="text" name="tanggal" id="tanggal" value="<?=htmlspecialchars($tanggalInput)?>" disabled>
                    <br>

                    <!-- Menampilkan nama maskapai yang diinput -->
                    <label for="maskapai">Maskapai</label>
                    <br>
                    <input type="text" name="maskapai" id="maskapai" value="<?=htmlspecialchars($NamaMaskapai)?>" disabled>
                    <br>

                    <!-- Menampilkan bandara asal yang dipilih -->
                    <label for="asal">Asal Penerbangan</label>
                    <br>
                    <input type="text" name="asal" id="asal" value="<?=htmlspecialchars($asalPenerbangan)?>" disabled>
                    <br>

                    <!-- Menampilkan bandara tujuan yang dipilih -->
                    <label for="tujuan">Tujuan Penerbangan</label>
                    <br>
                    <input type="text" name="tujuan" id="tujuan" value="<?=htmlspecialchars($tujuanPenerbangan)?>" disabled>
                    <br>

                    <!-- Menampilkan harga tiket dasar sebelum pajak dengan prefix "Rp" -->
                    <label for="hargaTiketAwal">Harga Tiket</label>
                    <br>
                    <input type="text" name="hargaTiketAwal" id="hargaTiketAwal" value="Rp<?=htmlspecialchars($hargaTiket)?>" disabled>
                    <br>

                    <!-- Menampilkan total pajak (pajak asal + pajak tujuan) dengan prefix "Rp" -->
                    <label for="pajak">Total Pajak</label>
                    <br>
                    <input type="text" name="pajak" id="pajak" value="Rp<?=htmlspecialchars($totalPajak)?>" disabled>
                    <br>

                    <!-- Menampilkan total harga tiket akhir (harga dasar + total pajak) dengan prefix "Rp" -->
                    <label for="totalHargaTiket">Total Harga Tiket</label>
                    <br>
                    <input type="text" name="totalHargaTiket" id="totalHargaTiket" value="Rp<?=htmlspecialchars($totalHargaTiket)?>" disabled>
                <br>
                </div>
            </section>
        <?php } ?>
        <!-- endof Output -->
    </div>
</body>
</html>