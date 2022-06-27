<?php
// mulai session
session_start();
// cek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
   header("location:login.php");
}
include "inc_header.php";
// cek level user untuk mengakses halaman ini
if (!in_array("admin", $_SESSION['akun'])) { ?>
   <br><br><br>
   <?php
   $err = "Anda tidak berhak mengakses halaman ini!"; ?>
   <div class="alert alert-danger text-center" role="alert">
      <?php echo $err; ?>
   </div>
<?php
   include "inc_footer.php";
   exit();
}
$error = "";
$sukses = "";

// jika tombol submit diklik
$id = $_GET['id_mahasiswa'];
$data = mysqli_query($koneksi, "SELECT * FROM mahasiswa, unit, kategori WHERE mahasiswa.id_unit = unit.id_unit AND mahasiswa.id_kategori = kategori.id_kategori AND mahasiswa.id_mahasiswa = '$id'");
$row = mysqli_fetch_array($data);
$row_k = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori = '$row[id_kategori]'"));
$row_u = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM unit WHERE id_unit = '$row[id_unit]'"));

// proses update data
if (isset($_POST['submit'])) {
   include 'koneksi.php';

   // ambil data dari form
   $nama = $koneksi->real_escape_string($_POST['nama']);
   $nim = $koneksi->real_escape_string($_POST['nim']);
   $no_wa = $koneksi->real_escape_string($_POST['no_wa']);
   $id_unit = $koneksi->real_escape_string($_POST['id_unit']);
   $id_kategori = $koneksi->real_escape_string($_POST['id_kategori']);
   $isi_pengaduan = $koneksi->real_escape_string($_POST['isi_pengaduan']);
   $tanggal = $koneksi->real_escape_string($_POST['tanggal']);

   // update data ke database
   $sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim', no_wa='$no_wa', id_unit='$id_unit', id_kategori='$id_kategori', isi_pengaduan='$isi_pengaduan', tanggal='$tanggal', status='pending' WHERE id_mahasiswa='$id'";
   $query = mysqli_query($koneksi, $sql);
   if ($query) {
      $sukses = "Data berhasil diedit";;
   } else {
      $error = "Data gagal diedit";
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
      Edit Data Pengaduan
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
            <label for="nama" class="form-label">Nama Lengkap</label>
            <!-- tampilkan data sebelumnya -->
            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
         </div>
         <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <!-- tampilkan data sebelumnya -->
            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $row['nim']; ?>" required>
         </div>
         <div class="mb-3">
            <label for="no_wa" class="form-label">No WA</label>
            <!-- tampilkan data sebelumnya -->
            <input type="text" class="form-control" id="no_wa" name="no_wa" value="<?php echo $row['no_wa']; ?>" required>
         </div>
         <div class="mb-3">
            <label for="id_unit" class="form-label">Unit</label>
            <!-- tampilkan data sebelumnya -->
            <select class="form-control" id="id_unit" name="id_unit" required>
               <option selected hidden value="<?php echo $row_u['id_unit']; ?>"><?php echo $row_u['nama_unit']; ?></option>
               <?php
               $data_u = mysqli_query($koneksi, "SELECT * FROM unit");
               while ($row_u = mysqli_fetch_array($data_u)) {
               ?>
                  <option value="<?php echo $row_u['id_unit']; ?>"><?php echo $row_u['nama_unit']; ?></option>
               <?php
               }
               ?>
            </select>
         </div>
         <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <!-- tampilkan data sebelumnya -->
            <select class="form-control" name="id_kategori" required>
               <option selected hidden value="<?php echo $row_k['id_kategori']; ?>"><?php echo $row_k['nama_kategori']; ?></option>
               <?php
               include 'koneksi.php';
               $data_k = mysqli_query($koneksi, "SELECT * FROM kategori");
               while ($row_k = mysqli_fetch_array($data_k)) {
               ?>
                  <option value="<?php echo $row_k['id_kategori']; ?>"><?php echo $row_k['nama_kategori']; ?></option>
               <?php
               }; ?>
            </select>
         </div>
         <div class="mb-3">
            <label for="isi_pengaduan" class="form-label">Isi Pengaduan</label>
            <!-- tampilkan data sebelumnya -->
            <textarea class="form-control" id="isi_pengaduan" name="isi_pengaduan" required><?php echo $row['isi_pengaduan']; ?></textarea>
         </div>
         <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Pengaduan</label>
            <!-- tampilkan data sebelumnya -->
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>
         </div>
         <input class="btn btn-primary" type="submit" name="submit" value="Edit">
         <input class="btn btn-primary float-end" type="reset" name="reset" value="Reset">
      </form>
   </div>
</div>
<br><br>

<?php include 'inc_footer.php'; ?>