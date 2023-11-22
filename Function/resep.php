<?php
// Simulasi data resep (contoh, seharusnya data diambil dari database)
$reseps = array(
    array('judul' => 'Nasi Goreng Spesial', 'gambar' => 'nasi babi.jpeg', 'rating' => 4.5, 'daerah_asal' => 'Indonesia', 'rasa' => 'Gurih', 'halal' => true, 'vegetarian' => false),
    array('judul' => 'Ayam Bakar Taliwang', 'gambar' => 'nasi babi.jpeg', 'rating' => 4.2, 'daerah_asal' => 'Lombok', 'rasa' => 'Pedas', 'halal' => true, 'vegetarian' => false),
    array('judul' => 'Ayam Bakar Taliwang', 'gambar' => 'nasi babi.jpeg', 'rating' => 4.2, 'daerah_asal' => 'Lombok', 'rasa' => 'Pedas', 'halal' => true, 'vegetarian' => false),
    array('judul' => 'Ayam Bakar Taliwang', 'gambar' => 'nasi babi.jpeg', 'rating' => 4.2, 'daerah_asal' => 'Lombok', 'rasa' => 'Pedas', 'halal' => true, 'vegetarian' => false),
    // Tambahkan resep lainnya sesuai kebutuhan
);

// Fungsi untuk menampilkan resep
function tampilkanResep($resep)
{
    echo '<div class="reseplist">';
    echo '<a href="resep ayam bakar taliwang.php?id=1">'; // Ganti 123 dengan ID resep yang sesuai
    echo '<img src="' . $resep['gambar'] . '" alt="' . $resep['judul'] . '" class="gambar-resep">';
    echo '<h2 class="judul-resep">' . $resep['judul'] . '</h2>';
    echo '</a>';
    echo '<div class="rating">Rating: ' . $resep['rating'] . '</div>';
    echo '<div class="detail">';
    echo '<p>Daerah Asal: ' . $resep['daerah_asal'] . '</p>';
    echo '<p>Rasa: ' . $resep['rasa'] . '</p>';
    echo '<p>Halal: ' . ($resep['halal'] ? 'Ya' : 'Tidak') . '</p>';
    echo '<p>Vegetarian: ' . ($resep['vegetarian'] ? 'Ya' : 'Tidak') . '</p>';
    echo '</div>';
    echo '</div>';
}
?>