
<?php  
    if(isset($_POST['szoveg'])){
        try{
            $dbh = new PDO('mysql:host=localhost;dbname=web2oland', 'web2oland', 'web2root',
                            array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');

            $sql = "select csaladi_nev, uto_nev from felhasznalok where csaladi_nev LIKE :nev OR uto_nev LIKE :nev";

            $sth = $dbh->prepare($sql);
            $sth->execute(array(":nev" => "%" .$_POST["szoveg"]. "%"));

            $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($rows);
            
        }catch (PDOException $e){
            echo json_encode($e->getMessage());
        }
    }
?>