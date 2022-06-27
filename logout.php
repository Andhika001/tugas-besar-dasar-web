<?php
// mulai session
session_start();
// akhiri session
session_destroy();
// redirect ke login.php
header("location:login.php");;
