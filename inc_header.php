<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Website Pengaduan</title>
   <link rel="stylesheet" href="css/bootstrap.css">
   <style>
      li:hover {
         background-color: #f5f5f5;
      }

      .tableFixHead {
         overflow: auto;
         height: 600px;
      }

      .tableFixHead thead th {
         position: sticky;
         top: 0;
         z-index: 1;
      }

      .table thead tr th {
         background-color: white;
         border-collapse: collapse;
         padding-top: 15px;
      }

      .padding {
         padding-top: 0;
      }
   </style>
</head>

<body style="background-color: #ebecf8;">
   <script src="js/bootstrap.js"></script>
   <script src="js/jquery.js"></script>
   <div id="app">
      <nav class="navbar navbar-expand-lg fixed-top" style="background-color: white;">
         <div class="container-fluid">
            <h1 class="navbar-brand" href="index.php">Pengaduan Kampus</h1>
            <ul class="nav nav-pills">
               <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
               </li>
               <!-- jika ada session mahasiswa tampilkan nav ajukan -->
               <?php if (in_array("mahasiswa", $_SESSION['akun'])) { ?>
                  <li class="nav-item"><a class="nav-link" href="isi_data.php">Ajukan</a></li>
               <?php }; ?>
               <!-- jika ada session admin tampilkan nav riwayat -->
               <?php if (in_array("admin", $_SESSION['akun'])) { ?>
                  <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
               <?php }; ?>
               <li class="nav-item">
                  <a class="nav-link" href="logout.php">Logout</a>
               </li>
            </ul>
         </div>
      </nav>