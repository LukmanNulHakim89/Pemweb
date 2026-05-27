<?php
if (isset($_POST['login'])) {
    include "koneksi.php";
    session_start();

    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Hashing password sebelum dicocokkan ke database
    $password = sha1($password);

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND password='$password'");
    $data  = mysqli_fetch_array($query);

    if (mysqli_num_rows($query) > 0) {
        $_SESSION['name'] = $data['name'];
        $_SESSION['success'] = "Welcome " . $_SESSION['name'] . " to the Dashboard Page";
        header("Location: index.php"); // tambah spasi setelah Location:
        exit(); // hentikan eksekusi setelah redirect
    } else {
        $_SESSION['danger'] = "Login failed, wrong email or password";
        header("Location: login.php"); // tambah spasi setelah Location:
        exit(); // hentikan eksekusi setelah redirect
    }
}
