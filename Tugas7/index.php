<?php
include 'koneksi.php';

// menentukan halaman aktif
$hal = isset($_GET['hal']) ? $_GET['hal'] : 'mahasiswa';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem KRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-dark bg-dark">
<div class="container">
    <span class="navbar-brand">Sistem KRS</span>

    <!-- navigasi -->
    <div>
        <a href="?hal=mahasiswa" class="btn btn-light btn-sm">Mahasiswa</a>
        <a href="?hal=matakuliah" class="btn btn-light btn-sm">Matakuliah</a>
        <a href="?hal=krs" class="btn btn-light btn-sm">KRS</a>
    </div>
</div>
</nav>

<div class="container mt-4">

<?php
// routing halaman

    if($hal == 'mahasiswa'){
        include 'mahasiswa.php';
        } elseif($hal == 'matakuliah'){
        
        include 'matakuliah.php';
        } elseif($hal == 'krs'){
            
        include 'krs.php';
        } else {
        
        echo "Halaman tidak ditemukan";
    }
?>
</div>
</body>
</html>