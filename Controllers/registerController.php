<?php
// registration.php

// Sertakan file-file yang diperlukan
require('../Function/connection.php');
require('../Function/ValidateFunction.php');
require('../Function/cryption.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir dan bersihkan input
    $newEmail = cleanInput($_POST["newEmail"]);
    $newUsername = cleanInput($_POST["newUsername"]);
    $newPassword = cleanInput($_POST["newPassword"]);
    $confirmPassword = cleanInput($_POST["confirmPassword"]);

    // Validasi username, password, dan email
    if (!validateUsername($newUsername)) {
        echo "Username tidak valid. Pastikan username memiliki panjang minimal 8 karakter dan mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.";
    } elseif (!validatePassword($newPassword)) {
        echo "Password harus memiliki panjang minimal 8 karakter.";
    } elseif ($newPassword !== $confirmPassword) {
        echo "Konfirmasi password tidak sesuai.";
    } elseif (!validateEmail($newEmail)) {
        echo "Email tidak valid.";
    } else {
        // Mulai sesi
        session_start();

        // Dapatkan ID sesi yang baru setelah sesi dimulai
        $newSessionId = generateUniqueSessionId();

        // Check apakah email atau username sudah ada dalam database
        $checkExistingQuery = "SELECT * FROM users WHERE email = ? OR username = ?";
        $checkExistingStmt = $conn->prepare($checkExistingQuery);
        $checkExistingStmt->bind_param("ss", $newEmail, $newUsername);
        $checkExistingStmt->execute();
        $checkExistingResult = $checkExistingStmt->get_result();

        if ($checkExistingResult->num_rows > 0) {
            // Email atau username sudah ada, berikan pesan kesalahan
            echo "Email atau username sudah digunakan. Silakan pilih yang lain.";
        } else {
            // Hash password menggunakan fungsi enkripsi/dekripsi
            $encryptedPassword = encryptData($newPassword, $encryptionKey);

            // Gunakan prepared statement untuk mencegah injeksi SQL
            $insertQuery = "INSERT INTO users (email, username, password, session_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $newEmail, $newUsername, $encryptedPassword, $newSessionId);

            // Eksekusi prepared statement
            if ($stmt->execute()) {
                // Registrasi berhasil
                $_SESSION['username'] = $newUsername; // Simpan informasi pengguna dalam sesi
                echo "Pendaftaran berhasil! Silakan login.";
                header("Location: ../login.php");
            } else {
                // Handle kesalahan eksekusi prepared statement
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }

            // Tutup statement
            $stmt->close();
        }

        // Tutup statement untuk pemeriksaan email dan username
        $checkExistingStmt->close();
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa melalui formulir
    header("Location: ../register.php");
    exit();
}

// Tutup koneksi database
$conn->close();
?>
