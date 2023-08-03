<!DOCTYPE html>
<html>
<head>
    <title>History Bulanan</title>
    <link rel="stylesheet" type="text/css" href="css/historyharian.css">
    <link rel="stylesheet" type="text/css" href="css/Header&Footer/Headerry.css">
    <link rel="stylesheet" type="text/css" href="css/Header&Footer/navbar.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="wrapper1">
    <div class="header">
         <div class="isiheader"><img src="img/header/medan.png"></div>
        <div class="isiteks">Dinas Komunikasi dan Informatika Pemerintah Kota Medan</div>
        <div class="isiheaderkanan"><img src="img/header/profile.png"></div>
    </div>
    <div class="navbar">
        <ul>
            <li class="na"><a href="Home.php" class="isinavbar"><img src="img/navbar/aboutme.png">Profile</a></li>
            <li class="na"><a href="Laporan.html" class="isinavbar"><img src="img/navbar/report.png">Laporan</a></li>
            <li class="na"><a href="history.html" class="isinavbar"><img src="img/navbar/history.png">History</a></li>
        </ul>
        <br>
</div>
    <br><br>
    <h1>History Laporan Bulanan</h1>
    <br><br><div class="judul">
        <a class="back" href="Laporan.html"><br><img src="img/report/back.png"></a><h1>History Laporan </h1>
    </div>
    <div class="isi">
          <?php
// Memastikan akun telah login sebelum mengakses data dari database
session_start(); // Pastikan session_start() telah dijalankan sebelum mengakses $_SESSION
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Lakukan koneksi ke database Anda
    $host_db = "localhost";
    $user_db = "root";
    $pass_db = "";
    $nama_db = "newproject";

    $conn = new mysqli($host_db, $user_db, $pass_db, $nama_db);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk mendapatkan data laporan harian berdasarkan username yang sedang login
    $query = "SELECT * FROM laporanbulanan WHERE username = '$username'";
    $result = $conn->query($query);

   if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>
                <th>Nama</th>
                <th>Tanggal & Waktu</th>
                <th>Verify</th>
                <th>Details</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['Waktu_Upload'] . "</td>";
            echo "<td>" . $row['Verify'] . "</td>";
            echo "<td><a href='DetailHistoryB.php?id=" . $row['id'] . "'>More</a></td>"; // Ganti 'detail_data.php' dengan nama halaman yang akan menampilkan detail data, 'username' adalah kolom unik di tabel
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Tidak ada data laporan Bulanan";
    }

    $conn->close();
} else {
    echo "Harap login terlebih dahulu.";
}
?>
        </table>
    </div>
</body>
</html>
