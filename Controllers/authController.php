<?php
// authController.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Sertakan konfigurasi fungsi
require('../Function/connection.php');
require('../Function/ValidateFunction.php');
require('../Function/cryption.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    if (!validateUsername($username)) {
        echo "Format nama pengguna tidak valid. Gunakan hanya huruf, angka, dan garis bawah.";
        exit();
    }

    // Validasi password menggunakan fungsi yang baru ditambahkan
    if (!validatePassword($password)) {
        echo "Format kata sandi tidak valid. Kata sandi harus setidaknya 8 karakter.";
        exit();
    }

    $encryptedUsername = encryptData($username, $encryptionKey);
    $encryptedPassword = encryptData($password, $encryptionKey);

    // Persiapkan pernyataan SQL untuk mencari pengguna dengan username yang diberikan
    $stmt = $conn->prepare("SELECT id, username, password, session_id FROM users WHERE username=? AND password=?;");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($userId, $dbUsername, $dbPassword, $storedSessionId);
    $stmt->fetch();
    $stmt->close();

    // Verifikasi password
    if ($dbUsername && password_verify($password, $dbPassword)) {
        // Check if the stored session ID matches the current session ID
        if (!empty($storedSessionId) && $storedSessionId !== session_id()) {
            // Session ID berbeda, logout otomatis pengguna
            session_destroy();
            echo "Anda sudah login dari perangkat atau sesi yang berbeda. Silakan login kembali.";
            exit();
        }if (empty($storedSessionId)) {
            $newSessionId = session_id();
            $stmt = $conn->prepare("UPDATE users SET session_id=? WHERE id=?;");
            $stmt->bind_param("si", $newSessionId, $userId);
            $stmt->execute();
            $stmt->close();
        }

        // Login berhasil, atur sesi atau tindakan lainnya
        $_SESSION["username"] = $dbUsername;

        // Redirect ke halaman profil
        header("Location: /profile.php"); 
        exit();

    } else {
        // Login gagal, tampilkan pesan kesalahan
        echo "Login gagal. Periksa nama pengguna dan kata sandi Anda.";
    }

        // Tutup koneksi ke database
        $conn->close();

}
?>
