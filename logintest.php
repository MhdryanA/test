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
    
    // Melakukan query untuk memeriksa username, password, dan role
    $query = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        // Login berhasil
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $user_data["role"]; // Simpan role di session
        return true;
    } else {
        // Login gagal
        return false;
    }
    
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="logintest.css">
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
</head>
<body>
  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 class="mb-0 pb-3"><span>Mahasiswa </span><span>Mentor</span></h6>
            <!-- Tambahkan ID "reg-log-mahasiswa" pada checkbox login mahasiswa -->
            <input class="checkbox" type="checkbox" id="reg-log-mahasiswa" name="reg-log"/>
            <label for="reg-log-mahasiswa"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <?php
                      // Memproses form login mahasiswa
                      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login-mahasiswa"])) {
                          $username = $_POST["username"];
                          $password = $_POST["password"];

                          if (cekLogin($username, $password, $host_db, $user_db, $pass_db, $nama_db)) {
                              if ($_SESSION["role"] === "mahasiswa") {
                                  // Redirect ke halaman HomeMahasiswa.php jika pengguna adalah mahasiswa
                                  header("Location: home.php");
                                  exit();
                              }
                          } else {
                              $err = "Username atau password salah!";
                          }
                      }
                      ?>
                      <h4 class="mb-4 pb-3">Login Mahasiswa</h4>
                      <form method="post">
                          <div class="form-group">
                              <input type="text" class="form-style" name="username" placeholder="Email">
                              <i class="input-icon"><img src="img/user.png"></i>
                          </div>	
                          <div class="form-group mt-2">
                              <input type="password" class="form-style" name="password" placeholder="Password">
                              <i class="input-icon"><img src="img/lock2.png"></i>
                          </div>
                          <button type="submit" name="login-mahasiswa">Login</button>
                          <p class="mb-0 mt-4 text-center"><a href="https://www.web-leb.com/code" class="link">Forgot your password?</a></p>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <?php
                      // Memproses form login mentor
                      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login-mentor"])) {
                      $username = $_POST["username"];
                       $password = $_POST["password"];

              if (cekLogin($username, $password, $host_db, $user_db, $pass_db, $nama_db)) {
        if ($_SESSION["role"] === "mentor") {
            // Simpan nama mentor ke dalam sesi jika login mentor berhasil
            $_SESSION["nama_mentor"] = $username;

            // Redirect ke halaman regismahasiswa.php jika pengguna adalah mentor
            header("Location: regismahasiswa.php");
            exit();
        }
    } else {
        $err = "Username atau password salah!";
    }
}

                      ?>
                      <h4 class="mb-4 pb-3">Login Mentor</h4>
                      <form method="post">
                          <div class="form-group">
                              <input type="text" class="form-style" name="username" placeholder="Email">
                              <i class="input-icon"><img src="img/user.png"></i>
                          </div>	
                          <div class="form-group mt-2">
                              <input type="password" class="form-style" name="password" placeholder="Password">
                              <i class="input-icon"><img src="img/lock2.png"></i>
                          </div>
                          <button type="submit" name="login-mentor">Login</button>
                          <p class="mb-0 mt-4 text-center"><a href="https://www.web-leb.com/code" class="link">Forgot your password?</a></p>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ... (Kode JavaScript sebelumnya) ... -->
  <script>
    // Menghilangkan animasi load setelah halaman selesai dimuat
    window.addEventListener("load", function() {
      var loadingAnimation = document.getElementById("loading-animation");
      loadingAnimation.classList.add("hide");
      var boxForm = document.querySelector(".boxform");
      boxForm.style.display = "block";

      // Mengambil elemen checkbox dan card-3d-wrapper
      var checkboxMahasiswa = document.getElementById("reg-log-mahasiswa");
      var cardWrapper = document.querySelector(".card-3d-wrapper");

      // Tambahkan event listener untuk mengubah tampilan ketika checkbox di-klik
      checkboxMahasiswa.addEventListener("change", function() {
        if (checkboxMahasiswa.checked) {
          // Jika checkbox di-klik dan menjadi checked (login mahasiswa)
          cardWrapper.style.transform = "rotateY(0deg)";
        } else {
          // Jika checkbox di-klik dan menjadi unchecked (login mentor)
          cardWrapper.style.transform = "rotateY(180deg)";
        }
      });
    });
  </script>
</body>
</html>
