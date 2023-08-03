<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="css/Home/Home.css">
    <link rel="stylesheet" type="text/css" href="css/Header&Footer/Headerry.css">
    <link rel="stylesheet" type="text/css" href="css/Header&Footer/navbar.css">

</head>

<?php include 'update.php'; ?>

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
                <li class="na"><a href="Home.php" class="isinavbar"><img src="img/navbar/aboutme.png">Profile</a></li>
                <li class="na"><a href="Laporan.html" class="isinavbar"><img src="img/navbar/report.png">Laporan</a></li>
                <li class="na"><a href="history.html" class="isinavbar"><img src="img/navbar/history.png">History</a></li>
            </ul>
            <br>
        </div>
    </div>
    <div class="wrapper2">
        <div class="resume"><b>BIODATA</b></div><br><br>
        <div class="box1">
            <div class="detail"><b>DATA MAHASISWA</b></div>
            <div class="foto">
    <?php
    // Memastikan akun telah login sebelum mengakses data dari database
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Lakukan koneksi ke database Anda
        $host_db    = "localhost";
        $user_db    = "root";
        $pass_db    = "";
        $nama_db    = "newproject";

        $conn = new mysqli($host_db, $user_db, $pass_db, $nama_db);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mendapatkan nama file foto dari database sesuai dengan username yang sedang login
        $query = "SELECT fotodiri FROM datadiri WHERE username = '$username'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $foto = $data['fotodiri'];

            // Tampilkan foto dari database sesuai dengan akun yang login menggunakan elemen <img>
            echo '<img src="' . $foto . '" alt="" class="profil-picture">';
        } else {
            // Jika data tidak ditemukan atau foto tidak ada, Anda dapat menampilkan gambar default atau pesan lainnya
            echo '<img src="img/Default.png" alt="" class="profil-picture">';
        }

        $conn->close();
    } else {
        // Jika belum login, tampilkan gambar default atau pesan lainnya
        echo '<img src="img/Default.png" alt="" class="profil-picture">';
    }
    ?>
</div>

           <div class="databox">
    <?php
    // Memastikan akun telah login sebelum mengakses data dari database
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Lakukan koneksi ke database Anda
        $host_db    = "localhost";
        $user_db    = "root";
        $pass_db    = "";
        $nama_db    = "newproject";

        $conn = new mysqli($host_db, $user_db, $pass_db, $nama_db);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk mendapatkan data sesuai dengan username yang sedang login
        $query = "SELECT divisi, namalengkap, nip, jurusan, mentor, universitas, nohp FROM datadiri WHERE username = '$username'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $divisi = $data['divisi'];
            $namalengkap = $data['namalengkap'];
            $nip = $data['nip'];
            $jurusan = $data['jurusan'];
            $mentor = $data['mentor'];
            $universitas = $data['universitas'];
            $nohp = $data['nohp'];

            // Tampilkan data dari database sesuai dengan akun yang login
            echo '<div class="thedata"><b> Divisi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b> <div class="long">' . $divisi . '</div></div>';
            echo '<div class="thedata"><b> Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b><div class="long">' . $namalengkap . '</div></div>';
            echo '<div class="thedata"><b> NIP/NPM &nbsp;&nbsp;&nbsp;&nbsp; :</b><div class="long">' . $nip . '</div></div>';
            echo '<div class="thedata"><b> Jurusan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b><div class="long">' . $jurusan . '</div></div>';
            echo '<div class="thedata"><b> Mentor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b><div class="long">' . $mentor . '</div></div>';
            echo '<div class="thedata"><b> No HP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :</b><div class="long">' . $nohp . '</div></div>';
            echo '<div class="thedata"><b> Universitas &nbsp;&nbsp; :</b> <div class="long">'. $universitas .'</div> </div>';
            
        } else {
            // Jika data tidak ditemukan, Anda dapat menampilkan pesan atau mengambil tindakan lainnya
            echo "Data tidak ditemukan";
        }

        $conn->close();
    } else {
        // Jika belum login, tampilkan pesan atau alihkan ke halaman login
        echo "Silakan login terlebih dahulu";
    }
    ?>
</div>
        </div>
        <div class="box2">
            <div class="aboutme"><b>ABOUT ME</b></div>
            <div class="strip"></div><br>
           <form method="post" enctype="multipart/form-data" action="update.php" onsubmit="return validateForm()">
                <div class="data">Nama <br>
                    <input type="text" name="namalengkap" placeholder="Masukkan Nama lengkap" required=""></div>
                <div class="data">NIM/NIP <br>
                    <input type="text" name="nip" placeholder="Masukkan NIP" required=""></div>
                <div class="data">Jurusan <br>
                    <input type="text" name="jurusan" placeholder="Masukkan Jurusan" required=""></div>
                <div class="data">Universitas <br>
                    <input type="text" name="universitas" placeholder="Asal Instansi (sekolah/universitas)" required=""></div>
                 <div class="data">No HP <br>
                    <input type="text" name="nohp" placeholder="Nomor HP" required=""></div>
                <br>
                <div class="poto">Foto <br>
                    <input type="file" name="fotodiri"></div>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
    <script>
        function validateForm() {
            // Get the form inputs
            var name = document.forms[0].namalengkap.value;
            var nip = document.forms[0].nip.value;
            var jurusan = document.forms[0].jurusan.value;
            var universitas = document.forms[0].universitas.value;

            var nohp = document.forms[0].nohp.value;

            // Check if any of the required fields is empty
            if (name === "" || nip === "" || jurusan === "" || universitas === "" || nohp ==="") {
                alert("Mohon lengkapi semua field yang bertanda '*'");
                return false; // Prevent form submission
            }

            // If all required fields are filled, show the confirmation pop-up
            var isConfirmed = confirm("Apakah kamu yakin ingin mengupdate data diri?");
            return isConfirmed; // Allow form submission if user clicks "OK" on the pop-up
        }
    </script>
</body>
</html>
