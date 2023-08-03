<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, alihkan ke halaman login atau tampilkan pesan kesalahan
    header("Location: login.php");
    echo "Silahkan Login terlebih dahulu";
    exit;
}

// Ambil data koneksi MySQL
$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "newproject";

$conn = new mysqli($host_db, $user_db, $pass_db, $nama_db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari sesi
    $username = $_SESSION['username'];

    // Ambil data dari form
    $namalengkap = $_POST['namalengkap'];
    $nip = $_POST['nip'];
    $jurusan = $_POST['jurusan'];
    $universitas = $_POST['universitas'];
    $nohp = $_POST['nohp'];

    // Pengelolaan upload file (diasumsikan file disimpan di direktori 'uploads')
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["fotodiri"]["name"]);
    move_uploaded_file($_FILES["fotodiri"]["tmp_name"], $targetFile);

    // Periksa apakah data pengguna sudah ada dalam tabel datadiri berdasarkan username
    $check_user_query = "SELECT * FROM datadiri WHERE username = '$username'";
    $result = $conn->query($check_user_query);

    if ($result->num_rows > 0) {
        // Data pengguna sudah ada dalam tabel, maka lakukan UPDATE data
        $update_query = "UPDATE datadiri SET namalengkap = '$namalengkap', nip = '$nip', jurusan = '$jurusan', universitas = '$universitas', fotodiri = '$targetFile', nohp = '$nohp' WHERE username = '$username'";

        if ($conn->query($update_query) === TRUE) {
            echo "Data berhasil diperbarui.";
        } else {
            echo "Error: " . $update_query . "<br>" . $conn->error;
        }
    } else {
        // Data pengguna belum ada dalam tabel, maka lakukan INSERT data baru
        $insert_query = "INSERT INTO datadiri (username, namalengkap, nip, jurusan, universitas, fotodiri, nohp)
            VALUES ('$username', '$namalengkap', '$nip', '$jurusan', '$universitas', '$targetFile','$nohp')";

        if ($conn->query($insert_query) === TRUE) {
            echo "Data berhasil dimasukkan.";
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
     header("Location: home.php");
    exit;
}

$conn->close();
?>
