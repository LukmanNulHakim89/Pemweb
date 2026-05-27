<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "student";

$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($koneksi->connect_error) {
    $response = array(
        'status'  => 0,
        'message' => 'Koneksi database gagal: ' . $koneksi->connect_error
    );
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

$koneksi->set_charset("utf8");
?>
