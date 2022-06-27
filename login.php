<?php
// mulai session
session_start();
// cek apakah user sudah login atau belum
if (isset($_SESSION['username'])) {
   header("location:index.php");
}
include 'koneksi.php';

$username = "";
$password = "";
$err = "";
// jika tombol submit diklik
if (isset($_POST['login'])) {
   $username = $_POST['username'];
   $password = $_POST['password'];
   // cek username dan password jika kosong maka tampilkan error
   if ($username == '' or $password == '') {
      $err .= "Silahkan isi username dan password anda";
   }
   // jika tidak kosong maka cek username dan password di database
   if (empty($err)) {
      $sql1 = "SELECT * FROM akun WHERE username = '$username'";
      $q1 = mysqli_query($koneksi, $sql1);
      // cek username
      if (mysqli_num_rows($q1) == 0) {
         $err .= "Username tidak ditemukan";
      } else {
         // cek password
         $sql2 = "SELECT * FROM akun WHERE username = '$username'";
         $q2 = mysqli_query($koneksi, $sql2);
         $r2 = mysqli_fetch_array($q2);
         if ($r2['password'] != md5($password)) {
            $err .= "Password salah";
         }
      }
   }
   // jika tidak ada error maka cek level user
   if (empty($err)) {
      $login_id = $r2['login_id'];
      $sql1 = "SELECT * FROM akun WHERE login_id = '$login_id'";
      $q1 = mysqli_query($koneksi, $sql1);
      while ($r1 = mysqli_fetch_array($q1)) {
         $akses[] = $r1['akses_id'];
      }
      if (empty($akses)) {
         $err .= "Akun tidak memiliki akses";
      }
   }
   // jika tidak ada error maka buat session
   if (empty($err)) {
      $_SESSION['username'] = $username;
      // buat session Nama Lengkap user yang login
      $_SESSION['nama_lengkap'] = $r2['nama_lengkap'];
      $_SESSION['akun'] = $akses;
      header("location:index.php");
      exit();
   }
}; ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="css/bootstrap.css">
</head>
<style>
   .card {
      width: 450px;
      margin: auto;
   }
</style>

<body style="background-color: #ebecf8;">
   <div id="app">
      <br><br><br><br><br><br>
      <div class="card">
         <div class=" card-header bg-primary text-white">
            Masuk
         </div>
         <div class="card-body">
            <?php
            if ($err) {
            ?>
               <div class="alert alert-danger" role="alert">
                  <?php echo $err; ?>
                  <a href="" class="btn-close float-end"></a>
               </div>
            <?php
            }; ?>
            <form action="" method="post">
               <div class="form-group mb-3">
                  <label class="mb-1" for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username">
               </div>
               <div class="form-group mb-3">
                  <label class="mb-1" for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
               </div>
               <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="password" onclick="myFunction()">
                  <label class="form-check-label" for="show-password">Show Password</label>
               </div>
               <script>
                  // fungsi untuk menampilkan password
                  function myFunction() {
                     var x = document.getElementById("password");
                     if (x.type === "password") {
                        x.type = "text";
                     } else {
                        x.type = "password";
                     }
                  }
               </script>
               <div class="text-center mb-3">
                  <button type="submit" class="btn btn-primary px-4" name="login">Masuk</button>
               </div>
               <div>
                  <p>Belum mempunyai akun?<a class="ms-2" href="register.php">Daftar disini</a></p>
               </div>
               <?php include 'inc_footer.php'; ?>
            </form>
         </div>
      </div>
</body>

</html>