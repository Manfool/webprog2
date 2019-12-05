<?php
session_start();
if(!isset($_SESSION['username'])){
echo "Bejelentkezés szükséges ! ";
}
 else {
    echo  "<h1>"."Sikeresen bejelentkeztél mint: ".$_SESSION['username']."</h1>";
}

  // Kaptuk adatokat?
  if(isset($_POST['belepes']) || isset($_POST['regisztracio']))
  {
    try
    {
      // Connect
      $dbh = new PDO('mysql:host=localhost;dbname=web2oland', 'web2oland', 'web2root',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
      $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

      // Login
      if(isset($_POST['belepes'])) {
       
        $_POST['login'] = trim($_POST['login']);
        $_POST['jelszo'] = trim($_POST['jelszo']);
        $username= $_POST['login'];
        $password= $_POST['jelszo'];
        
        // Login Check
        $sql = "select csaladi_nev, uto_nev from felhasznalok where bejelentkezes = :login and jelszo = sha1(:jelszo);";
        $sth = $dbh->prepare($sql);
        $sth->execute(Array(':login' => $_POST['login'], ':jelszo' => $_POST['jelszo']));
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        switch(count($rows))
        {
          case 0: $belepes_hiba = "Hibás login név - jelszó pár!"; break;
          case 1: $csaladinev = $rows[0]['csaladi_nev']; $utonev = $rows[0]['uto_nev']; break;
          default: $belepes_hiba = "Több felhsználó rendelkezik a megadott login név - jelszó párral!";
        }
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        echo "<script>alert('Sikeres bejelentkezés!');document.location='signlogin.php'</script>";
        

      }
      // Registration
      else
      {
        
        $_POST['csaladi_nev'] = trim($_POST['csaladi_nev']);
        $_POST['utonev'] = trim($_POST['utonev']);
        $_POST['login_nev'] = trim($_POST['login_nev']);
        $_POST['jelszo_reg'] = trim($_POST['jelszo_reg']);
 
        $sql = "select csaladi_nev, uto_nev from felhasznalok where bejelentkezes = :login and jelszo = sha1(:jelszo);";
        $sth = $dbh->prepare($sql);
        $sth->execute(Array(':login' => $_POST['login_nev'], ':jelszo' => $_POST['jelszo_reg']));
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        switch(count($rows))
        {
          case 0: $belepes_hiba = true; break;
          case 1: $belepes_hiba = false; break;
          default: $belepes_hiba = true;
        }

        if($_POST['csaladi_nev'] == "" || $_POST['utonev'] == "" || $_POST['login_nev'] == "" || $_POST['jelszo_reg'] == "" ||  $belepes_hiba == true)
        {
          echo "<script>alert('Már létezik ilyen felhasználó/jelszó páros');document.location='signlogin.psp'</script>";
          $regisztracio_hiba = "Hiányzó adatok!";
        }
        else
        {
          $sql = "insert into felhasznalok values (0, :csaladi_nev, :uto_nev, :bejelentkezes, sha1(:jelszo))";
          $sth = $dbh->prepare($sql);
          if($sth->execute(Array(':csaladi_nev' => $_POST['csaladi_nev'], ':uto_nev' => $_POST['utonev'],
                              ':bejelentkezes' => $_POST['login_nev'], ':jelszo' => $_POST['jelszo_reg'])))
          {
            $regisztracio_eredmeny = true;
            
          }
          else
          {
            $regisztracio_eredmeny = false;            
          }
        }
      }
    }
    catch (PDOException $e)
    {
      echo "Hiba: ".$e->getMessage();
    }
  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css.css" />
	<script type = "text/javascript" src = "signlogin.js"></script>
    <title> Oland Kft. </title>
</head>

<body>
    <?php
    if(isset($csaladinev) && isset($utonev) || isset($regisztracio_eredmeny))
    {
    echo "<div id=\"eredmeny\">
        ";
        if(isset($csaladinev) && isset($utonev))
        {
        echo "Bejelentkezett a felhasználó: ".$csaladinev." ".$utonev." (".$_POST['login'].")";
        }
        if(isset($regisztracio_eredmeny) && $regisztracio_eredmeny)
        {
        echo "Sikeresen regisztrált felhasználó: ".$_POST['csaladi_nev']." ".$_POST['utonev']." (".$_POST['login_nev'].")";
        }
        elseif(isset($regisztracio_eredmeny) && ! $regisztracio_eredmeny)
        {
        echo "Sikertelen regisztráció: ".$_POST['csaladi_nev']." ".$_POST['utonev']." (".$_POST['login_nev'].")";
        }
        echo "
    </div>";
    }
    ?>
    <div class="topnav">
        <a href="index.php">Főoldal</a>
        <a class="active" href="signlogin.php">Bejelentkezés/Regisztráció</a>
        <a href="news.php">Hírek</a>
        <a href="adding.php">Új Hír</a>
		<a href="reviews.php">Vélemények</a>
        <a href="addingr.php">Új Vélemény</a>
		<a href="contact.php">Kapcsolat</a>
        <a href="logout.php">Kijelentkezés</a>
    </div>
    <h1>Bejelentkezés/Regisztráció</h1>
    <div class="login-page">
        <div class="form">
            <form action="signlogin.php" method="post" name="login-form">
                <p style="color:white">Bejelentkezés</p>
                <input name="login" id="login" placeholder="felhasználónév" type="text" class="Input" />
                <input name="jelszo" type="password" id="password" placeholder="jelszó" class="Input" />
                <button name="belepes" type="submit">Belejelntkezés</button>
            </form> 
            <?php if(isset($belepes_hiba) && strlen(trim($belepes_hiba)) > 0) echo "<div class=\"uzenet\">".$belepes_hiba."</div>"; ?>

            <form action="signlogin.php" method="post" name="register-form">
                <p style="color:white">Regisztráció</p>
                
                <input type="text" name="csaladi_nev" id="csaladi_nev" placeholder="családnév" value="" />
                <input type="text" name="utonev" id="utonev" placeholder="utónév" value="" />
                <input type="text" name="login_nev" id="login_nev" placeholder="felhasználónév" value="" />
                <input type="password" name="jelszo_reg" id="jelszo_reg" placeholder="jelszó" value="" />

                <button name="regisztracio" type="submit">Létrehozás</button>  
            </form>   
            <?php if(isset($regisztracio_hiba) && strlen(trim($regisztracio_hiba)) > 0) echo "<div class=\"uzenet\">".$regisztracio_hiba."</div>"; ?>    
        </div>
    </div>
  
    <script src='https://code.jquery.com/jquery-3.3.1.min.js'>
    </script>
    <script>
        $('.message a').click(function () {
            $('form').animate({ height: "toggle", opacity: "toggle" }, "slow");
        });
    </script>
    <div class="footer">

        <p> &copy; Ölei András </p>

    </div>
    
    <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>

</html>