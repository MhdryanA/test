<?php
// Buat koneksi ke database, gantilah 'hostname', 'username', 'password', dan 'nama_database' sesuai dengan informasi koneksi Anda
$koneksi = new mysqli('localhost', 'root', '', 'newproject');
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Periksa apakah parameter 'username' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data berdasarkan username dari tabel (gantilah 'nama_tabel' sesuai dengan nama tabel Anda dan 'username' dengan kolom unik di tabel)
    $query = "SELECT * FROM laporanmingguan WHERE id = '$id'";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        // Tampilkan detail data di sini sesuai kebutuhan Anda
        $row = $result->fetch_assoc();
        echo "<h1>Detail Data:</h1>";
        echo "<p>Nama: " . $row['username'] . "</p>";
        echo "<p>Aktivitas: " . $row['aktivitas'] . "</p>";
    } else {
        echo "Data tidak ditemukan.";
    }

    // Tutup koneksi setelah selesai
    $koneksi->close();
} else {
    echo "Username tidak valid atau tidak ditemukan.";
}
?>