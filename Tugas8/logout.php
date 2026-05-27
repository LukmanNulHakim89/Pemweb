<?php
session_start();

// hapus semua data session, bukan hanya $_SESSION['name']
session_unset();
session_destroy();

// Buat session baru untuk pesan notifikasi
session_start();
$_SESSION['danger'] = "Logout Successful";

header("Location: login.php"); // tambah spasi setelah Location:
exit(); // hentikan eksekusi setelah redirect
