<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_mahasiswa";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    echo "Koneksi berhasil!";
}

// Menutup koneksi
mysqli_close($conn);
?>
