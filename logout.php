﻿<?php session_start();
if (!isset($_SESSION['username'])) {
echo "<script>alert('Bejelentkezés nélkül nem lehet Kijelentkezni!');document.location='signlogin.php'</script>";
}else{
session_destroy();
echo "<script>alert('Kijelentkezés sikeres!');document.location='index.html'</script>";
exit;
}
?>