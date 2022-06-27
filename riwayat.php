<?php
// mulai session
session_start();
// cek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
   header("location:index.php");
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

// ubah status menjadi solved ketika tombol solve diklik
if (isset($_GET['solve'])) {
   $id = $_GET['solve'];
   $sql = "UPDATE mahasiswa SET status='solved' WHERE id_mahasiswa='$id'";
   $q = mysqli_query($koneksi, $sql);
   if ($q) {
      header("location:riwayat.php");
   }
}

?>
<!-- link bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery.js"></script>

<head>
   <title>Pengaduan</title>
   <style>
      .padding {
         padding-top: 0;
      }
   </style>
</head>

<br><br><br><br>
<div class="col-sm-11" style="margin: auto;">
   <div class="card">
      <div class="card-header text-white bg-primary">
         Riwayat Pengaduan
      </div>
      <div class="card-body tableFixHead padding">
         <table class="table">
            <colgroup>
               <col span="1" style="width: 5%;">
               <col span="1" style="width: 10%;">
               <col span="1" style="width: 20%;">
               <col span="1" style="width: 10%;">
               <col span="1" style="width: 10%;">
               <col span="1" style="width: 5%;">
               <col span="1" style="width: 25%;">
               <col span="1" style="width: 15%;">
            </colgroup>
            <thead>
               <tr>
                  <th scope="col">Status</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Identitas Pengadu</th>
                  <th scope="col">No WA</th>
                  <th scope="col">Unit</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Isi Pengaduan</th>
                  <th scope="col">Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php
               include 'koneksi.php';
               $sql = mysqli_query($koneksi, "SELECT * FROM mahasiswa, unit, kategori WHERE mahasiswa.id_unit = unit.id_unit AND mahasiswa.id_kategori = kategori.id_kategori ORDER BY mahasiswa.id_mahasiswa DESC");
               while ($data = mysqli_fetch_array($sql)) {
                  echo "<tr>";
                  echo "<td>";
                  if ($data['status'] == "Pending") {
                     // tombol untuk solve data (jika status pending)
                     echo "<a href='riwayat.php?solve=" . $data['id_mahasiswa'] . "' class='btn btn-success btn-sm'>Solve</a>";
                  }
                  if ($data['status'] == "Solved") {
                     echo $data['status'] . "</td>";
                  }
                  echo "<td>" . $data['tanggal'] . "</td>";
                  echo "<td>" . $data['nama'] . "<br>" . $data['nim'] . "</td>";
                  echo "<td>" . $data['no_wa'] . "</td>";
                  echo "<td>" . $data['nama_unit'] . "</td>";
                  echo "<td>" . $data['nama_kategori'] . "</td>";
                  echo "<td>" . $data['isi_pengaduan'] . "</td>";
                  // edit data
                  echo "<td><a class='btn btn-warning me-1' href='edit.php?id_mahasiswa=" . $data['id_mahasiswa'] . "'>Edit</a>";
                  // delete data
                  echo "<a class='btn btn-danger' href='hapus.php?id_mahasiswa=" . $data['id_mahasiswa'] . "' onclick=\"return confirm('Apakah yakin ingin menghapus?')\">Hapus</a></td>";
                  echo "</tr>";
               }; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>
<br><br>
<?php
include "inc_footer.php";; ?>