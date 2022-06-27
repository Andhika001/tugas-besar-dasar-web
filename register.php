<?php
// mulai session
session_start();
// cek apakah user sudah login atau belum
if (isset($_SESSION['username'])) {
   header("location:index.php");
}
include 'koneksi.php';

$username = "";
$nama = "";
$email = "";
$password = "";
$err = "";
$sukses = "";
// jika tombol submit diklik
if (isset($_POST['register'])) {
   $username = $_POST['username'];
   $nama = $_POST['nama'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   // cek username dan password jika kosong maka tampilkan error
   if ($username == '' or $nama == '' or $email == '' or $password == '') {
      $err .= "Silahkan isi lengkap data anda";
   }

   // jika tidak kosong maka cek username apakah sudah ada atau belum
   if (empty($err)) {
      $sql1 = "SELECT * FROM akun WHERE username = '$username'";
      $q1 = mysqli_query($koneksi, $sql1);
      if (mysqli_num_rows($q1) > 0) {
         $err = "Pendaftaran gagal, Username sudah ada";
      } else {
         $sql = "INSERT INTO akun (username, nama_lengkap, email, password, akses_id) VALUES ('$username', '$nama', '$email', MD5('$password'), 'mahasiswa')";
         $query = mysqli_query($koneksi, $sql);
         if ($query) {
            $sukses = "Pendaftaran berhasil, silahkan login";
         } else {
            $err = "Pendaftaran gagal";
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
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
      <br><br><br><br>
      <div class="card">
         <div class=" card-header bg-primary text-white">
            Daftar
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
            <?php
            if ($sukses) {
            ?>
               <div class="alert alert-success" role="alert">
                  <?php echo $sukses; ?>
                  <a href="login.php" class="btn-close float-end"></a>
               </div>
            <?php
            }; ?>
            <form action="" method="post">
               <div class="form-group mb-3">
                  <label class="mb-1" for="username">Username (NIM)</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username">
               </div>
               <div class="form-group mb-3">
                  <label class="mb-1" for="nama">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
               </div>
               <div class="form-group mb-3">
                  <label class="mb-1" for="email">Email Aktif</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com">
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
                  <button type="submit" class="btn btn-primary px-4" name="register">Daftar</button>
               </div>
               <div>
                  <p>Sudah mempunyai akun?<a class="ms-2" href="login.php">Masuk disini</a></p>
               </div>
               <?php include 'inc_footer.php'; ?>

            </form>
         </div>
      </div>
</body>

</html>