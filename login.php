<?php
session_start();
$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "newproject";

$err        = "";
$username   = "";

// Fungsi untuk memeriksa login
function cekLogin($username, $password, $host, $user, $pass, $db)
{
    // Koneksi ke database
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    
    // Melakukan query untuk memeriksa username dan password
    $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Login berhasil
        return true;
    } else {
        // Login gagal
        return false;
    }
    
    
    mysqli_close($conn);
}

// Memproses form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    if (cekLogin($username, $password, $host_db, $user_db, $pass_db, $nama_db)) {
        // Set the session variable
        $_SESSION["username"] = $username;
        // Redirect to laporanharian.php or any other page
        header("Location: Home.php");
        exit();
    } else {
        $err = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Web Pelaporan</title>
  <link rel="stylesheet" type="text/css" href="css/Login/loading.css">
  <link rel="stylesheet" type="text/css" href="css/Login/login.css">
  <style>
    .loading-animation {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to top, #08478c, #5f88b4, #FFFFFF);
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 1;
      transition: opacity 1s ease-in-out;
      z-index: 9999;
    }

    .loading-animation.hide {
      opacity: 0;
      pointer-events: none;
    }

    .loading-animation img {
      width: 200px;
      height: auto;
    }
    
    .boxform {
      display: none;
    }
    
    .loading-animation.hide + .boxform {
      display: block;
    }
  </style>
  <script>
    // Menghilangkan animasi load setelah halaman selesai dimuat
    window.addEventListener("load", function() {
      var loadingAnimation = document.getElementById("loading-animation");
      loadingAnimation.classList.add("hide");
      var boxForm = document.querySelector(".boxform");
      boxForm.style.display = "block";
    });
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <!-- Animasi load -->
  <div id="loading-animation" class="loading-animation">
    <img src="img/login/komincut.png">
  </div>

  <!-- Konten halaman -->
  <div class="n"></div>
  <br><br>
  <div class="boxform">
    <br>
      
    <div class="logo"></div>
    <h2><b>Login</b></h2>
    
    <form method="post">
      <div class="box">
        <input type="text" name="username" id="username" placeholder="Username" required>
      </div>
      <div class="box">
        <input type="password" name="password" id="password" placeholder="Password" required>
      </div>
      <br><br>
      <div class="boxlgn">
        <button type="submit">Login</button>
      </div>
      <br>
    </form>
    <br>
      
    <div class="lp">Lupa Password? Harap Lapor Pembimbing Kamu</div>
    
    <?php if ($err !== "") { ?>
    <div class="error"><?php echo $err; ?></div>
    <?php } ?>
  </div>
</body>
</html>
