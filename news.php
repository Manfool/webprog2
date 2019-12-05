<?php
session_start();
if(!isset($_SESSION['username'])){
   echo "Még nem vagy bejelentkezve";
}
 else {
    echo  "<h1>"."Bejelentkezve mint: ".$_SESSION['username']."</h1>";
}
?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="UTF-8" />
    <link rel="stylesheet" href="css.css">
    <title> Oland Kft. </title>
	
</head>

<body>
    <div class="topnav">
    	<a href="index.php">Főoldal</a>
        <a href="signlogin.php">Bejelentkezés/Regisztráció</a>
        <a class="active" href="news.php">Hírek</a>
        <a href="adding.php">Új Hír</a>
        <a href="reviews.php">Vélemények</a>
        <a href="addingr.php">Új Vélemény</a>
        <a href="contact.php">Kapcsolat</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
    <h1>Hírek</h1>
<p>
    <?php
    $myfile = fopen("news.txt", "r");
    echo fread($myfile,filesize("news.txt"));
    fclose($myfile);
    ?>
</p>
</body>

</html>