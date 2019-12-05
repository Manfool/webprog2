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
    <script src='https://code.jquery.com/jquery-3.3.1.min.js'>
    </script>
    <style type="text/css">
    </style>

</head>

<body>
    <div class="topnav">
        <a href="index.php">Kezdőlap</a>
        <a href="signlogin.php">Bejelentkezés/Regisztráció</a>
        <a href="news.php">Hírek</a>
        <a href="adding.php">Új Hír</a>
        <a href="reviews.php">Vélemények</a>
        <a href="addingr.php">Új Vélemény</a>
        <a class="active" href="contact.php">Kapcsolat</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>

    <h1 class="erzekeny">Elérhetőségek:</h1>
    <p align="center" style="font-size:120%"> Telefon: +3690555555</p>
    <p align="center" style="font-size:120%"> email: oland@atomceg.hu</p>


    <div class="footer">
    
    <p> &copy; Ölei András </p>
    
    </div>    
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
