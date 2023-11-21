<?php
// registration.php

// Sertakan file-file yang diperlukan
require('./Function/connection.php');
require('./Function/ValidateFunction.php');
require('./Function/cryption.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir dan bersihkan input
    $newUsername = cleanInput($_POST["newUsername"]);
    $newPassword = cleanInput($_POST["newPassword"]);
    $confirmPassword = cleanInput($_POST["confirmPassword"]);

    // Validasi username
    if (!validateUsername($newUsername)) {
        echo "Username tidak valid. Pastikan username memiliki panjang minimal 8 karakter dan mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.";
        // Handle kesalahan lebih lanjut jika diperlukan
    } elseif (!validatePassword($newPassword)) {
        echo "Password harus memiliki panjang minimal 8 karakter.";
        // Handle kesalahan lebih lanjut jika diperlukan
    } elseif ($newPassword !== $confirmPassword) {
        echo "Konfirmasi password tidak sesuai.";
        // Handle kesalahan lebih lanjut jika diperlukan
    } else {
        // Mulai sesi
        session_start();

        // Dapatkan ID sesi yang baru setelah sesi dimulai
        $newSessionId = session_id();

        // Hash password menggunakan fungsi enkripsi/dekripsi
        $encryptedPassword = encryptData($newPassword, $encryptionKey);

        // Gunakan prepared statement untuk mencegah injeksi SQL
        $stmt = $conn->prepare("INSERT INTO users (username, password, session_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $newUsername, $encryptedPassword, $newSessionId);

        // Eksekusi prepared statement
        if ($stmt->execute()) {
            // Registrasi berhasil
            $_SESSION['username'] = $newUsername; // Simpan informasi pengguna dalam sesi
            echo "Pendaftaran berhasil! Silakan login.";
        } else {
            // Handle kesalahan eksekusi prepared statement
            echo "Terjadi kesalahan. Silakan coba lagi.";
        }

        // Tutup statement
        $stmt->close();
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa melalui formulir
    header("Location: ../index.html");
    exit();
}

// Tutup koneksi database
$conn->close();
?>
