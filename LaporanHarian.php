<?php
session_start();

$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "newproject";

// Koneksi ke database
$conn = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);

// Periksa koneksi database
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION["username"])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit();
}

// Pesan laporan berhasil disimpan
$pesan = "";

// Memproses form laporan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aktivitas = $_POST["aktivitas"];
    $foto_dokumentasi = $_FILES["photos"]["name"];
    $username = $_SESSION["username"]; // Mengambil username dari sesi
    $target_dir = "uploads/laporanharian/";
    $target_file = $target_dir . basename($_FILES["photos"]["name"]);
    move_uploaded_file($_FILES["photos"]["tmp_name"], $target_file);

    // Menyimpan data laporan ke tabel
    $sql = "INSERT INTO laporanharian (Username, Aktivitas, Foto_Dokumentasi, Waktu_Upload, Verify)
            VALUES ('$username', '$aktivitas', '$foto_dokumentasi', NOW(), '')";
    if (mysqli_query($conn, $sql)) {
        $pesan = "Laporan berhasil disimpan.";
    } else {
        $pesan = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Harian</title>
    <link rel="stylesheet" type="text/css" href="css/Laporanharian/laporanharian.css">
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
    <h1>Laporan Harian</h1>
    <br><br><div class="judul">
        <a class="back" href="Laporan.html"><br><img src="img/report/back.png"></a><h1>REPORT </h1>
    </div>
    <div class="isi">
    
        <div class="boxcontent1">
            <div class="content1judul">SILAHKAN ISI LAPORAN KALIAN DISINI UNTUK MENTOR MENGETAHUI AKTIVITAS YANG KALIAN LAKUKAN SELAMA MAGANG DI SINI</div>
            <div class="date">Tanggal : <?php echo date('d-m-Y'); ?></div><br>
            <?php if (!empty($pesan)) { ?>
                <div class="pesan"><?php echo $pesan; ?></div>
            <?php } ?>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="boxcontent2">
                <br>
                <a>Activities</a><br>
                <textarea name="aktivitas"></textarea>
                <br><br>
                <a>Documentation</a><br>
                <input type="file" name="photos" placeholder="Select Photos">
                <br><br>
                <button type="submit">Upload</button>  
            </div>
        </form>
    </div>
</div>
</body>
</html>
