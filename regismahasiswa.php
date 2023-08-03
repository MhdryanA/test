<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Jika mentor belum login, bisa melakukan redirect ke halaman login atau tampilkan pesan error
    header("Location: logintest.php"); // Ganti dengan halaman login mentor
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah mengarahkan pengguna
}

// Lakukan koneksi ke database
$host = "localhost"; // Ganti sesuai dengan host database Anda
$username_db = "root"; // Ganti dengan username database Anda
$password_db = ""; // Ganti dengan password database Anda
$database = "newproject"; // Ganti dengan nama database Anda

$koneksi = mysqli_connect($host, $username_db, $password_db, $database);

// Cek apakah form telah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $divisi = $_POST["divisi"];

    // Ambil nama mentor dari sesi (session) yang telah disimpan saat akun mentor login
    $pembimbing = $_SESSION['username'];

    // Query untuk memeriksa apakah username sudah ada dalam tabel login
    $query_check_username = "SELECT * FROM login WHERE username = '$username'";
    $result_check_username = mysqli_query($koneksi, $query_check_username);

    // Periksa jumlah baris hasil query
    if (mysqli_num_rows($result_check_username) > 0) {
        // Jika username sudah ada, berikan pesan kesalahan dan tolak registrasi
        $pesan = "Username sudah digunakan. Silakan gunakan username lain.";
    } else {
        // Jika username belum ada, lakukan proses registrasi

        // Query untuk menyimpan data ke dalam tabel login
        $query_register = "INSERT INTO login (username, password, role, pembimbing) VALUES ('$username', '$password', 'mahasiswa', '$pembimbing')";
    
        // Jalankan query registrasi
        if (mysqli_query($koneksi, $query_register)) {
            // Jika registrasi berhasil, simpan juga data divisi ke tabel "datadiri"

            // Ambil ID dari user yang baru saja diregistrasi
            $user_id = mysqli_insert_id($koneksi);

            // Query untuk menyimpan data divisi ke dalam tabel "datadiri"
            $query_save_divisi = "INSERT INTO datadiri (username, divisi, mentor) VALUES ('$username', '$divisi','$pembimbing')";


            // Jalankan query untuk menyimpan data divisi
            if (mysqli_query($koneksi, $query_save_divisi)) {
                $pesan = "Akun berhasil didaftarkan dan data divisi tersimpan.";
            } else {
                $pesan = "Terjadi kesalahan saat menyimpan data divisi: " . mysqli_error($koneksi);
            }
        } else {
            $pesan = "Terjadi kesalahan saat mendaftarkan akun: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/mahasiswamentor.css">
    <link rel="stylesheet" type="text/css" href="css/Header&Footer/Headerry.css">
    <link rel="stylesheet" type="text/css" href="css/Header&Footer/navbar.css">
    <link rel="stylesheet" type="text/css" href="css/regismahasiswa.css">

</head>

<body>

    <div class="wrapper1">
       <div class="header">
    <div class="isiheaderkiri">
        <img src="img/header/medan.png">
    </div>
    <div class="isiteks">Dinas Komunikasi dan Informatika Pemerintah Kota Medan</div>
    <div class="isiheaderkanan">
        <img src="img/header/profile.png">
    </div>
</div>
        <div class="navbar">
            <ul>
                <h3>Tambah Akun Mahasiswa</h3>
            </ul>
            <br>
        </div>
    </div>
    <div class="wrapperk">
        <div class="box1">
            <div class="picture"><img src="img/kominfo.png"></div>
            <p><b>Mentor Name</b></p>
            <div class="box1">
                <div class="navsamping"><a href="#">My Profile</a></div>
                <div class="navsamping"><a href="mahasiswamentor.php">Data Mahasiswa</a></div>
                <div class="navsamping"><a href="#">Verifikasi Laporan Mahasiswa</a></div>
                <div class="navsamping"><a href="#">Tambahkan Akun</a></div>
        </div>

        </div>
        <div class="boxed">
        <div class="formregist"><h3>Register Mahasiswa</h3><br>
            <form method="post">
                <div class="data">Username</div>
            <input type="text" name="username" placeholder="Username"><br><br>
            <div class="data">Password</div>
            <input type="text" name="password" placeholder="Password"><br><br>
            <div class="data">Divisi</div>
            <select name="divisi" required="">
                <option value="" disabled selected>Pilih Divisi</option>
                <option value="Aplikasi Informatika">Aplikasi Informatika</option>
                <option value="Teknologi Informatika">Teknologi Informatika</option>
                <option value="Komunikasi Publik">Komunikasi Publik</option>
                <option value="Statistik dan Informasi Publik">Statistik dan Informasi Publik</option>
                <option value="Keamanan Data">Keamanan Data</option>
            </select><br>
            <button type="submit">Register</button> <br>
            
        </form>
        <br>
        <?php if (!empty($pesan)) { ?>
                <div class="pesan"><?php echo $pesan; ?></div>
            <?php } ?>
        </div>
        </div>
    </div>
</body>
</html>
