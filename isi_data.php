<?php
// mulai session
session_start();
// cek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
   header("location:login.php");
}
include "inc_header.php";
$error = "";
$sukses = "";
// jika tombol submit diklik
if (isset($_POST['submit'])) {
   include 'koneksi.php';

   $nama = $koneksi->real_escape_string($_POST['nama']);
   $nim = $koneksi->real_escape_string($_POST['nim']);
   $no_wa = $koneksi->real_escape_string($_POST['no_wa']);
   $id_unit = $koneksi->real_escape_string($_POST['id_unit']);
   $id_kategori = $koneksi->real_escape_string($_POST['id_kategori']);
   $isi_pengaduan = $koneksi->real_escape_string($_POST['isi_pengaduan']);
   $tanggal = $koneksi->real_escape_string($_POST['tanggal']);


   // insert data ke database
   $sql = "INSERT INTO mahasiswa (nama, nim, no_wa, id_unit, id_kategori, isi_pengaduan, tanggal, status) VALUES ('$nama', '$nim', '$no_wa', '$id_unit', '$id_kategori', '$isi_pengaduan', '$tanggal', 'Pending')";

   $query = mysqli_query($koneksi, $sql);
   if ($query) {
      $sukses = "Pengaduan berhasil terkirim";;
   } else {
      $error = "Pengaduan gagal terkirim";
   }
}; ?>
<html>
<link rel="stylesheet" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery.js"></script>

<head>
   <title>Pengaduan</title>
</head>

<br><br><br><br>
<div class="card" style="width: 700px; margin: auto;">
   <div class="card-header bg-primary text-white">
      Data Pengaduan
   </div>
   <div class="card-body">
      <form action="" method="POST">
         <?php
         if ($error) {
         ?>
            <div class="alert alert-danger" role="alert">
               <?php echo $error; ?>
               <a href="" class="btn-close float-end"></a>
            </div>
         <?php
         };
         if ($sukses) {
         ?>
            <div class="alert alert-success" role="alert">
               <?php echo $sukses; ?>
               <a href="" class="btn-close float-end"></a>
            </div>
         <?php
         }; ?>
         <h5 class="card-title">Isikan Data Lengkap</h5>
         <div class="mb-3">
            <?php if (in_array("mahasiswa", $_SESSION['akun'])) { ?>
               <label for="nama" class="form-label">Nama Lengkap</label>
               <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly>
            <?php }; ?>
            <?php if (in_array("admin", $_SESSION['akun'])) { ?>
               <label for="nama" class="form-label">Nama Lengkap</label>
               <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly>
            <?php }; ?>
         </div>
         <div class="mb-3">
            <?php if (in_array("mahasiswa", $_SESSION['akun'])) { ?>
               <label for="nim" class="form-label">NIM</label>
               <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $_SESSION['username']; ?>" readonly>
            <?php }; ?>
            <?php if (in_array("admin", $_SESSION['akun'])) { ?>
               <label for="nim" class="form-label">NIM</label>
               <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $_SESSION['username']; ?>" readonly>
            <?php }; ?>
         </div>
         <div class="mb-3">
            <label for="no_wa" class="form-label">No WA</label>
            <input type="text" class="form-control" name="no_wa" id="no_wa" required>
         </div>
         <div class="mb-3">
            <label for="id_unit" class="form-label">Unit</label>
            <select class="form-control" name="id_unit" required>
               <option disabled selected hidden value="">-- Pilih Unit --</option>
               <?php
               include 'koneksi.php';
               $sql = mysqli_query($koneksi, "SELECT * FROM unit");
               while ($data = mysqli_fetch_array($sql)) {
                  echo "<option value='" . $data['id_unit'] . "'>" . $data['nama_unit'] . "</option>";
               }; ?>
            </select>
         </div>
         <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-control" name="id_kategori" required>
               <option disabled selected hidden value="">-- Pilih Kategori --</option>
               <?php
               include 'koneksi.php';
               $sql = mysqli_query($koneksi, "SELECT * FROM kategori");
               while ($data = mysqli_fetch_array($sql)) {
                  echo "<option value='" . $data['id_kategori'] . "'>" . $data['nama_kategori'] . "</option>";
               }; ?>
            </select>
         </div>
         <div class="mb-3">
            <label for="isi_pengaduan" class="form-label">Isi Pengaduan</label>
            <textarea class="form-control" name="isi_pengaduan" id="isi_pengaduan" rows="3" required></textarea>
         </div>
         <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pengaduan</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
         </div>
         <input class="btn btn-primary" type="submit" name="submit" value="Submit">
         <input class="btn btn-primary float-end" type="reset" name="reset" value="Reset">
      </form>
   </div>
</div>
<br><br>

<?php include 'inc_footer.php'; ?>