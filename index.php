<?php
// mulai session
session_start();
// jika session ada maka include inc_header.php dan jika tidak maka include index_header.php
if (isset($_SESSION['username'])) {
   include 'inc_header.php';
} else {
   include 'index_header.php';
}
?>
<br><br>
<div class="container-fluid" style="width: 100%; height: 100%; margin: auto;">
   <br><br>
   <div class="card-body text-center" style="width: 800px; margin: auto;">
      <h2>Selamat Datang di Web Pengaduan Kampus</h2>
      <p>Penjaminan mutu (quality assurance) pendidikan tinggi sebagai proses penetapan dan pemenuhan standar mutu pendidikan secara konsisten dan berkelanjutan dimaksudkan agar pelanggan memperoleh kepuasan serta menghasilkan pengembangan berkelanjutan (continous improvement) di perguruan tinggi.</p>
      <a href=" isi_data.php"><button class="btn btn-primary px-4 py-2">Ajukan Pengaduan</button></a>
   </div>
   <br><br>

   <br><br>
</div>
<div class="col-sm-11" style="margin: auto;">
   <div class="card">
      <div class="card-header text-white bg-primary">
         Riwayat Pengaduan
      </div>
      <div class="card-body tableFixHead padding">
         <table class="table">
            <colgroup>
               <col span="1" style="width: 10%;">
               <col span="1" style="width: 20%;">
               <col span="1" style="width: 10%;">
               <col span="1" style="width: 15%;">
               <col span="1" style="width: 5%;">
               <col span="1" style="width: 30%;">
               <col span="1" style="width: 10%;">
            </colgroup>
            <thead>
               <tr>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Identitas Pengadu</th>
                  <th scope="col">No WA</th>
                  <th scope="col">Unit</th>
                  <th scope="col">Kategori</th>
                  <th scope="col">Isi Pengaduan</th>
                  <th scope="col">Status</th>
               </tr>
            </thead>
            <tbody>
               <?php
               include 'koneksi.php';
               // query untuk menampilkan data dari tabel pengaduan
               $sql = mysqli_query($koneksi, "SELECT * FROM mahasiswa, unit, kategori WHERE mahasiswa.id_unit = unit.id_unit AND mahasiswa.id_kategori = kategori.id_kategori ORDER BY mahasiswa.id_mahasiswa DESC");
               while ($data = mysqli_fetch_array($sql)) {
                  echo "<tr>";
                  echo "<td>" . $data['tanggal'] . "</td>";
                  echo "<td>" . $data['nama'] . "<br>" . $data['nim'] . "</td>";
                  echo "<td>" . $data['no_wa'] . "</td>";
                  echo "<td>" . $data['nama_unit'] . "</td>";
                  echo "<td>" . $data['nama_kategori'] . "</td>";
                  echo "<td>" . $data['isi_pengaduan'] . "</td>";
                  if ($data['status'] == "Solved") {
                     echo "<td><button class='badge rounded-pill text-bg-success' disabled>Solved</button></td>";
                  } else if ($data['status'] == "Pending") {
                     echo "<td><button class='badge rounded-pill text-bg-secondary' disabled>Pending</button></td>";
                  }
               }; ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<br><br>
<?php
include "inc_footer.php";
?>