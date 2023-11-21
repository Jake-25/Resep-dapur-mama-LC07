<?php
// authController.php

session_start();

 // Sertakan konfigurasi database
require('connection.php');
require('ValidateFUnction.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    // Persiapkan pernyataan SQL untuk mencari pengguna dengan username yang diberikan
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?;");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($dbUsername, $dbPassword);
    $stmt->fetch();
    $stmt->close();

    // Verifikasi password
    if ($dbUsername && password_verify($password, $dbPassword)) {
        // Login berhasil, atur sesi atau tindakan lainnya
        $_SESSION["username"] = $dbUsername;
        header("Location: /profile.php"); // Redirect ke halaman profil
        exit();
    } else {
        // Login gagal, tampilkan pesan kesalahan
        echo "Login failed. Check your username and password.";
    }

    // Tutup koneksi ke database
    $conn->close();
}
?>
