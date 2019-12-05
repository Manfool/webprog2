   <?php   
   session_start();
if(!isset($_SESSION['username'])){
echo "<script>alert('Nem lehet bejelentkezés nélkül véleményt írni!!!');document.location='reviews.php'</script>";
}
 else {
    echo  "<h1>"."Bejelentkezve mint: ".$_SESSION['username']."</h1>";
}
   ?>


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
        <a href="news.php">Hírek</a>
        <a href="adding.php">Új Hír</a>
        <a href="reviews.php">Vélemények</a>
        <a class="active" href="addingr.php">Új Vélemény</a>
        <a href="contact.php">Kapcsolat</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
    <h1>Vélemény hozzáadása</h1>
    <div class="adding-page">
    <div class="form">
        <form action="addReviews.php" method="post">
            <input type="text" name="title" placeholder="vélemény címe"/>
			<textarea type="text" name="desc" placeholder="vélemény kifejtése" rows="10" cols="35"></textarea>            
            <button name="Submit" type="submit">Új vélemény</button>
           </form>
        </div>
        </div>
</body>

</html>