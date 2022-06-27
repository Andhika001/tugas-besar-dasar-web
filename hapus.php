<?php

include 'koneksi.php';
// proses hapus data
$sql = "DELETE FROM mahasiswa WHERE id_mahasiswa = '$_GET[id_mahasiswa]'";

$query = mysqli_query($koneksi, $sql);

if ($query) {
   echo "<script>location.href='riwayat.php';</script>";
} else {
   echo "<script>location.href='riwayat.php';</script>";
};
