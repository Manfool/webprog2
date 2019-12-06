<?php
//session_start();
  /*
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";
  */
  if(isset($_POST['belepes']) || isset($_POST['regisztracio']))
  {
    try
    {
      $dbh = new PDO('mysql:host=localhost;dbname=usermanagement', 'root', '',
                    array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

      if(isset($_POST['belepes'])) {
  
        $_POST['login'] = trim($_POST['login']);
        $_POST['jelszo'] = trim($_POST['jelszo']);
        echo "<script>
            alert('A hír rögzítve lett!');
            window.location.href='adding.php';
            </script>";
        // user name
        $sql = "select csaladi_nev, utonev from felhasznalok where bejelentkezes = :login and jelszo = sha1(:jelszo);";
        $sth = $dbh->prepare($sql);
        $sth->execute(Array(':login' => $_POST['login'], ':jelszo' => $_POST['jelszo']));
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        switch(count($rows))
        {
          // error
          case 0: $belepes_hiba = "Hibás login név - jelszó pár!"; break;
          case 1: $csaladinev = $rows[0]['csaladi_nev']; $utonev = $rows[0]['utonev']; break;
          default: $belepes_hiba = "Több felhsználó rendelkezik a megadott login név - jelszó párral!";
        }

      }
      else
      {
        // space minus
        $_POST['email_reg'] = trim($_POST['email_reg']);
        $_POST['csaladi_nev'] = trim($_POST['csaladi_nev']);
        $_POST['utonev'] = trim($_POST['utonev']);
        $_POST['login_nev'] = trim($_POST['login_nev']);
        $_POST['jelszo_reg'] = trim($_POST['jelszo_reg']);

        if($_POST['csaladi_nev'] == "" || $_POST['utonev'] == "" || $_POST['login_nev'] == "" || $_POST['jelszo_reg'] == "" || $_POST['email_reg'] == "")
        {
          $regisztracio_hiba = "A megadott adatok hiányosak!";
        }
        else
        {
          $sql = "insert into felhasznalok values (0, :csaladi_nev, :utonev, :login, sha1(:jelszo))";
          $sth = $dbh->prepare($sql);
          if($sth->execute(Array(':csaladi_nev' => $_POST['csaladi_nev'], ':utonev' => $_POST['utonev'],
                              ':login' => $_POST['login_nev'], ':jelszo' => $_POST['jelszo_reg'])))
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