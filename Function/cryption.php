<?php
$envFile = '..\Assets\Styles\secret\key.env';

if (!file_exists($envFile)) {
    die('File .env tidak ditemukan. Pastikan file .env.example sudah disalin dan diatur.');
}

// Baca nilai variabel dari file .env
$envConfig = parse_ini_file($envFile);

// Ambil kunci enkripsi dan dekripsi dari variabel lingkungan
$encryptionKey = $envConfig['ENCRYPTION_KEY'];
$decryptionKey = $envConfig['DECRYPTION_KEY'];

if (!$encryptionKey || !$decryptionKey) {
    die('Kunci enkripsi atau dekripsi tidak ditemukan. Pastikan variabel lingkungan ENCRYPTION_KEY dan DECRYPTION_KEY sudah diatur di file .env.');
}

function encryptData($data, $key)
{
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivSize);
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    if ($encryptedData === false) {
        // Handle error saat enkripsi
        return false;
    }

    return base64_encode($iv . $encryptedData);
}

function decryptData($data, $key)
{
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $ivSize);
    $encryptedData = substr($data, $ivSize);

    if ($iv === false || $encryptedData === false) {
        // Gagal mendapatkan IV atau data yang dienkripsi
        return false;
    }

    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);

    if ($decryptedData === false) {
        // Handle error saat dekripsi
        return false;
    }

    return $decryptedData;
}

function generateUniqueSessionId() {
    // Generate a unique session ID using a combination of current timestamp and random number
    $sessionId = md5(uniqid(mt_rand(), true));

    return $sessionId;
}


?>
