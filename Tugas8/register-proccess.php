<?php
if (isset($_POST['register'])) {
    include "koneksi.php";
    session_start();

    $name             = $_POST['name'];
    $email            = $_POST['email'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Hashing password
    $password         = sha1($password);
    $confirm_password = sha1($confirm_password);

    $query = mysqli_query($koneksi, "SELECT email FROM user WHERE email='$email'");
    $data  = mysqli_fetch_array($query);

    // Cek email sudah terdaftar
    if ($email == $data['email']) {
        $_SESSION['danger'] = "E-mail already used";
        header("Location: register.php"); // tambah spasi setelah Location:
        exit(); // hentikan eksekusi setelah redirect
    } else {
        if ($password === $confirm_password) {
            mysqli_query($koneksi, "INSERT INTO user VALUES(null,'$name','$email','$password')");
            $_SESSION['success'] = "Congratulations $name, your registration was successful. Please login to enter";
            header("Location: login.php"); // tambah spasi setelah Location:
            exit(); // hentikan eksekusi setelah redirect
        } else {
            $_SESSION['danger'] = "Password doesn't match";
            header("Location: register.php"); // tambah spasi setelah Location:
            exit(); // hentikan eksekusi setelah redirect
        }
    }
}
