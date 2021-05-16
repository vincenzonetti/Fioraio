<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Fioraio</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: 0;
            font-family: Montserrat;

        }

        html {
            min-height: 100%;
            position: relative;
        }

        body {
            height: 100%;
            margin: 0;
        }



        .body::after {
            content: "";
            background: url("sfondoLogIn.jpg") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            opacity: 0.5;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
            overflow: hidden;

        }

        #info {
            display: none;
        }

        #adminPanel {
            margin: auto;
            width: 80%;
            height: 100%;
            background-color: white;
        }

        .nav-bar {
            display: flex;
            justify-content: space-between;
            background: linear-gradient(90deg, rgba(223, 17, 241, 0.74) -0.69%, rgba(143, 90, 255, 0.8) -0.69%, rgba(164, 79, 253, 0.78125) -0.68%, rgba(255, 31, 246, 0.7) 100%);
            padding-top: 30px;
            padding-bottom: 30px;
            padding-left: 1.5%;
            padding-right: 1.5%;
        }

        .navbar-container {

            width: 100%;

            left: 0px;
            top: 0px;
        }

        .rigth-navElmt>form {
            display: inline;
        }

        #Info-container {
            /* display: inline; */
            display: none;
        }

        .article-img-container>img {

            width: 210px;
            height: 210px;

        }

        #articlescontainer {

            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            margin: 0 auto;
            width: fit-content;

        }
img{
    border-radius: 20px;
}
        .article-container {
            text-align: center;
            margin: 50px;
            background: rgba(255, 133, 249, 0.25);
            ;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 20px;
            border: solid rgba(168, 168, 168, 0.41);
        }

        #ordini-table,
        #ordini-table>tbody>th,
        #ordini-table>tbody>tr>td {

            border: 2px solid black;
            text-align: center;

        }

        #ordini-table>tbody>tr>td {
            padding: 10px;
        }

        #orderscontainer {

            text-align: center;
        }

        #table-container {
            background-color: rgba(255, 255, 255, 0.5);
            width: fit-content;
          
            margin: auto;
        }

        .toColor {
            background-color: orange;
        }
        #insSpecie-container{
         
           display: flex;
           justify-content: center;
           padding: 20px;
        }
        #insSpecie-container>form{
            border: solid black;
            padding: 20px;
        }
 
      #admin-nav{
          display: flex;
          justify-content: space-evenly;
      }
      input[type=submit],button {
     
    border-radius: 5px;
    border: 0;
    width: 80px;
    height:25px;
    font-weight: bold;
    background: #f4f4f4;
}

    </style>
</head>

<body>
    <div class="body">
        <div class="main">

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "my_vincenzonetti";

            $con = mysqli_connect($servername, $username, $password);
            if ($con == TRUE) {
            } else {
                echo ("<p>Errore nella connessione con il server MySQL.</p>");
            }
            $db = mysqli_select_db($con, $database);
            if ($db) {
            } else {
                echo ("<p>Errore nella selezione del database.</p>");
                exit();
            }
           
            session_start();
            if (isset($_REQUEST['logOut'])) {
                session_destroy();
                header('location:login.php');
                
            }
            if (isset($_SESSION['tipo'])) {
                $tipo = $_SESSION['tipo'];
                $nomeU = $_SESSION['user'];

                /* echo '<p>'.$tipo.'</p>'; */

                switch ($tipo) {
                    case 'privati':
                        $qInfo = "SELECT * FROM " . $tipo . " WHERE idPrivato=" . $_SESSION['idPrivato'];
                        $esegui = mysqli_query($con, $qInfo);
                        if ($esegui) {

                            $row = $esegui->fetch_array(MYSQLI_ASSOC);
                            echo '<div class="navbar-container"><div class="nav-bar">';

                            echo '<div><h1>Benvenuto ' . $row['nome'] . '</h1><p>privato</p></div>';
                            echo '<div class="rigth-navElmt">';
                            echo '
                            <div id="Info-container" >
                           <span> <a href="#">Account</a></span>
                            <div id="info">
                            <table>
                            <tr>
                            <td>ID: </td>
                            <td>' . $row['idPrivato'] . ' </td>
                            </tr>
                            <tr>
                            <td>Nome: </td>
                            <td>' . $row['nome'] . ' </td>
                            </tr>
                            <tr>
                            <td>Email: </td>
                            <td>' . $row['email'] . ' </td>
                            </tr>
                            <tr>
                            <td>Indirizzo: </td>
                            <td>' . $row['indirizzo'] . ' </td>
                            </tr>
                          
                            </table>
                            </div>
                            </div>';
                            /*   echo '  <form action="index.php">
                          <input type="submit" value="Ordini">
                          </form>
                          '; */
                            echo '<button id="ordiniBtn">Ordini</button>';
                            echo '<button id="marketBtn" style="display:none">Negozio</button>';
                            echo '  <form action="index.php">
                          <input type="submit" value="Log out" name="logOut" id="esci">
                          </form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            if (isset($_REQUEST['logOut'])) {
                                session_destroy();
                                header('location:login.php');
                            }
                        } else {
                            echo '<p class="error">' . $con->error . '</p>';
                        }
                        break;
                    case 'rivenditori':
                        $qInfo = "SELECT * FROM " . $tipo . " WHERE idRivenditore=" . $_SESSION['idRivenditore'];
                        $esegui = mysqli_query($con, $qInfo);
                        if ($esegui) {

                            $row = $esegui->fetch_array(MYSQLI_ASSOC);
                            echo '<div class="navbar-container"><div class="nav-bar">';

                            echo '<div><h1>Benvenuto ' . $row['nome'] . '</h1><p>rivenditore</p></div>';
                            echo '<div class="rigth-navElmt">';
                            echo '
                            <div id="Info-container">
                           <span> <a href="#">Account</a></span>
                            <div id="info">
                            <table>
                            <tr>
                            <td>ID: </td>
                            <td>' . $row['idRivenditore'] . ' </td>
                            </tr>
                            <tr>
                            <td>Nome: </td>
                            <td>' . $row['nome'] . ' </td>
                            </tr>
                            <tr>
                            <td>Email: </td>
                            <td>' . $row['indirizzo'] . ' </td>
                            </tr>
                            <tr>
                            <td>Indirizzo: </td>
                            <td>' . $row['partitaIva'] . ' </td>
                            </tr>
                          
                            </table>
                            </div>
                            </div>';
                            echo '<button id="ordiniBtn">Ordini</button>';
                            echo '<button id="marketBtn" style="display:none">Negozio</button>';
                            echo '  <form action="index.php">
                          <input type="submit" value="Log out" name="logOut" id="esci">
                          </form>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<p class="error">' . $con->error . '</p>';
                        }




                        break;

                    case 'admin':
                        /* SEZIONE ADMIN */
                        echo '<div id="adminPanel">';
                        echo '<div id="admin-nav"><h3>Benvenuto Dipendente</h3>  
                        <form action="index.php">
                        <input type="submit" value="Aggiorna">
                        </form> 
                       <form action="index.php" >
                        <input type="submit" value="Log out" name="logOut" id="esci">
                        </form>
                    
                        </div>';
                        /* FORM INBSERIMENTO SPECIE */
                        echo '<div id="insSpecie-container">
                        <form action="index.php"  method="post" enctype="multipart/form-data">
                        <h3>Inserimento specie</h3>
                     <table>
                         <tr>
                             <td>Nome</td>
                             <td><input type="text" name="specieN" id="" maxlength="30" required></td>
                         </tr>
                         <tr>
                             <td>Nome Latino</td>
                             <td><input type="text" name="specieLatinN" id="" maxlength="30" required></td>
                         </tr>
                         <tr>
                             <td>Uso</td>
                             <td><select name="specieUso" id="">
                                 <option value="Appartamento">Appartamento</option>
                                 <option value="Giardino">Giardino</option>
                             </select></td>
                         </tr>
                         <tr>
                             <td>Esotica</td>
                           <td>  <select name="specieEsotica" id="">
                                 <option value="Si">Si</option>
                                 <option value="No">No</option>
                             </select></td>
                         </tr>
                         <tr>
                             <td>Tipo</td>
                             <td><input type="radio" name="specieTipo" id="" value="verde" checked>Verde <input type="radio" name="specieTipo"  value="fiorita" id="">Fiorita</td>

                         </tr>';
                        $DsqlColori = 'SELECT * FROM Colorazioni ';
                        $esegui = mysqli_query($con, $DsqlColori);
                        if ($esegui) {
                            $num = mysqli_num_rows($esegui);
                            if ($num > 0) {
                                echo '<tr id="checkboxColor" style="display:none"><td>Colore:</td><td class="checkbox-group required">';
                                for ($k = 0; $k < $num; $k++) {
                                    $riga = $esegui->fetch_array(MYSQLI_ASSOC);
                                    echo '<input type="checkbox" id="colore' . $k . '" name="colore[]" value="' . $riga["idColorazione"] . '">' . $riga["denominazione"] . '|';
                                }
                                echo '</td></tr>';
                            }
                        }
                        echo '<tr><td>Fornitore</td>
                    <td> <select name="idFornitore"';
                        $qFornitori = "SELECT * FROM fornitori";
                        $esegui = mysqli_query($con, $qFornitori);
                        if ($esegui) {
                            $num = mysqli_num_rows($esegui);
                            if ($num > 0) {

                                for ($k = 0; $k < $num; $k++) {
                                    $riga = $esegui->fetch_array(MYSQLI_ASSOC);
                                    echo '<option value="' . $riga["idFornitore"] . '">' . $riga["Nome"] . ' | ' . $riga["codiceFiscale"] . '</option>';
                                }
                            }
                        }
                        echo '</select></td></tr>';
                        echo '<tr>
                        <td>Prezzo:</td>
                        <td><input type="number" name="costo" id="" min="10" max="99999"></td>
                        </tr>';
                        echo '<tr><td>Carica Immagine pianta:</td>
                         <td><input type="file" name="fileToUpload" id="fileToUpload" required>';
                        echo '<tr><td colspan="2"><input type="submit" value="Inserisci Specie" name="insertSpecie"></td></tr>';
                        echo '</table></form>';
                        echo '</div>';
                        if (isset($_POST['insertSpecie'])) {
                            $flagForm = 0;
                            $nomeS = $_POST["specieN"];
                            $nomeLatS = $_POST["specieLatinN"];
                            $uso = $_POST["specieUso"];
                            $esotica = $_POST["specieEsotica"];
                            $sTipo = $_POST["specieTipo"];
                            if ($sTipo === "fiorita") {
                                if (isset($_POST['colore'])) {
                                    $insColori = $_POST["colore"];
                                } else {
                                    $flagForm = 1;
                                }
                            }
                            $costo = $_POST['costo'];
                            $idFornitore = $_POST['idFornitore'];
                            /*   if ($sTipo === "fiorita") {
                                if (is_array($insColori)) {
                                    foreach($insColori as $value){
                                      echo $value . '<br>';
                                    }
                                  } else {
                                    $value = $insColori;
                                    echo $value. 'ds';
                                  }
                            } */
                            $target_dir = "C:/xampp/htdocs/Fioraio/imgs/";
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            $uploadOk = 1;
                            $nomeFile = substr(basename($_FILES["fileToUpload"]["name"]), 0, -4);

                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if ($check !== false) {
                                /* echo "File is an image - " . $check["mime"] . "."; */
                                $uploadOk = 1;
                            } else {
                                echo "<p>Il file non è un immagine.</p>";
                                $uploadOk = 0;
                            }
                            if ($nomeFile != $nomeS) {
                                echo '<p>Il nome del file deve coincidere con il nome della specie</p>';
                                $uploadOk = 0;
                            }
                            if (file_exists($target_file)) {
                                echo "<p>Il file è già esistente.</p>";
                                $uploadOk = 0;
                            }
                            if ($imageFileType != "jpg") {
                                echo "<p>L'immagine puo essere esclusivamente in formato jpg.</p>";
                                $uploadOk = 0;
                            }

                            if ($uploadOk == 0) {
                                echo "<p>L'immagine non è stata caricata.</p>";
                                // if everything is ok, try to upload file
                            } else if ($flagForm === 1) {
                                echo "<p>Una specie fiorita deve avere almeno una colorazione.</p>";
                            } else {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                    /* In questo caso il file viene correttamente caricato */
                                    /* echo "<p>L'immagine " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " è stata caricato.";
                                    echo $nomeS . '<br>';
                                    echo $nomeLatS . '<br>';
                                    echo $uso . '<br>';
                                    echo $esotica . '<br>';
                                    echo $sTipo . '<br>';
                                    echo $idFornitore . '<br>';

                                  
                                    echo $costo . '<br>'; */
                                    $sqlInsert1 = 'INSERT INTO specie (nome, nomeLatino, uso, esotica, tipo, idFornitore)
                                    VALUES ("' . $nomeS . '","' . $nomeLatS . '","' . $uso . '","' . $esotica . '","' . $sTipo . '","' . $idFornitore . '")';
                                    $esegui = mysqli_query($con, $sqlInsert1);
                                    if ($esegui) {
                                       
                                        $sqlidSpecie="SELECT * FROM specie WHERE nome='".$nomeS."'";
                                        $esegui2 = mysqli_query($con, $sqlidSpecie);
                                        if ($esegui2) {
                                            $riga = $esegui2->fetch_array(MYSQLI_ASSOC);
                                            echo $riga['idSpecie'];
                                    if ($sTipo === "fiorita") {
                                            
                                          
                                               
                                                foreach ($insColori as $value) {
                                                   $sql='INSERT INTO specie_colorazioni (idColorazione, idSpecie)
                                                   VALUES ('.$value.','.$riga["idSpecie"].')';
                                                    $esegui = mysqli_query($con, $sql);
                                                
                                                }
                                            }
                                            $oggi = getdate();
                                            $dataT = $oggi['year'] . '-' . $oggi['mon'] . '-' . $oggi['mday'];
                                            $sqlCost='INSERT INTO prezzi (dataInizio, dataFine, prezzo, idSpecie)
                                            VALUES ("'.$dataT.'", NULL,"' . $costo . '","' . $riga["idSpecie"]. '" )';
                                             $eseguiCost = mysqli_query($con, $sqlCost);
                                             
                                              if($eseguiCost){
                                                echo '<script>alert("Specie Inserita con Successo") </script>';
                                              }  
                                    }
                                    
                                }
                                } else {
                                    echo "<p>C'è stato un errore nel caricamento dell'immagine.</p>";
                                }
                            }
                        }
                        echo '<div id=alterPrice-container"  style="display: flex;
                        justify-content: center;
                        padding: 20px;">';

                        echo '<form action="index.php" style="  border: solid black;
                        padding: 20px;">
                        <h3>Aggiorna Listino</h3>
                        <table><tr>
                        <td>Prezzo da modificare</td><td><select name="newPrice">';
                        $sql="SELECT p.*,s.* 
                        FROM prezzi as p 
                        INNER JOIN specie as s
                        ON s.idSpecie=p.idSpecie AND p.dataFine IS NULL";
                        $exe= mysqli_query($con, $sql);
                        $nums = mysqli_num_rows($exe);
                        for($k=0;$k<$nums;$k++){
                            $riga = $exe->fetch_array(MYSQLI_ASSOC);
                            echo'<option value="'.$riga['idPrezzo'].' | '.$riga["idSpecie"].'">Specie: '.$riga['nome'].' |P. Attuale: '.$riga['prezzo'].' | id P. Attuale: '.$riga['idPrezzo'].'</option>';
                        }
                      echo'<td>  </tr>
                      <tr>
                      <td>Nuovo prezzo</td>
                      <td><input type="number" name="prezzo" id="" min="10" max="99999" required></td>
                      </tr>
                      <tr>
                      <td>
                      <input type="submit" value="Modfica Prezzo" name="modPrice">
                      </td>
                      </tr>
                      ';
                      
                      echo '</table></form></div>';
                      if (isset($_REQUEST['modPrice'])) {
                        $pieces = explode("|", $_REQUEST['newPrice']);
                        $idPrezzo=$pieces[0];
                        $idSpecie=$pieces[1];
                        $newP=$_REQUEST['prezzo'];
                        $oggi = getdate();
                        $dataT = $oggi['year'] . '-' . $oggi['mon'] . '-' . $oggi['mday'];
                        $sqlUpdate='UPDATE prezzi
                        SET dataFine = "'.$dataT.'"
                        WHERE idPrezzo='.$idPrezzo;
                    /*     echo $sqlUpdate . '<br>';
                        echo $idPrezzo . '<br>';
                        echo $idSpecie . '<br>'; */
                        
                         $exe= mysqli_query($con, $sqlUpdate);
                        if($exe){
                            $sqlIns='INSERT INTO prezzi (dataInizio, dataFine, prezzo, idSpecie)
                            VALUES ("'.$dataT.'", NULL,"' . $newP . '","' . $idSpecie. '" )';
                            $exe2= mysqli_query($con, $sqlIns);
                           /*  echo $sqlIns; */
                            if($exe2){
                                echo '<script>alert("Prezzo aggiornato con successo") </script>';
                               
                     
                            }
                        }
                      }
                      echo '<div  style="display: flex;
                      justify-content: center;
                      padding: 20px;"
                      >';
                      echo '<form action="index.php" style="  border: solid black;
                        padding: 20px;">
                        <h3>Inserisci Fornitore</h3>
                        <table><tr>
                        <td>Nome</td><td><input type="text" name="nomeForn" maxlength="30" id="" required></td><tr>';
                        echo '<tr>
                        <td>Codice Fiscale</td>
                        <td><input type="text" name="codiceFiscale" id="" maxlength="16" minlength="16" required></td>
                        </tr>
                        <tr>
                        <td>
                        <input type="submit" value="Inserisci fornitore" name="insForn">
                        </td>
                        ';
                        echo '</table></form></div>';
                        if (isset($_REQUEST['insForn'])) {
                            $nomeF=ucfirst($_REQUEST["nomeForn"]);
                            $CF= strtoupper($_REQUEST["codiceFiscale"]);
                           
                          /*   echo $nomeF . '<br>';
                            echo $CF . '<br>';         */
                            $sqlInsertF= 'INSERT INTO fornitori (Nome, codiceFiscale)
                            VALUES ("'.$nomeF.'","'.$CF.'")';
                            $exeIF= $exe2= mysqli_query($con, $sqlInsertF);
                            if($exeIF){
                                echo '<script>alert("Fornitore inserito con successo") </script>';
                            }
                        }
                        echo '<div  style="display: flex;
                      justify-content: center;
                      padding: 20px;"
                      >';
                      echo '<form action="index.php" style="  border: solid black;
                        padding: 20px;">
                        <h3>Inserisci Colorazione</h3>
                        <table><tr>
                        <td>Nome</td><td><input type="text" name="nomeColor" maxlength="30" id="" required></td><tr>';
                        echo '<tr>
                        <td>Codice Esadecimale</td>
                        <td><input type="text" name="hexCode" id="" maxlength="6"  required></td>
                        </tr>
                        <tr>
                        <td>
                        <input type="submit" value="Inserisci Colorazione" name="insColor">
                        </td>
                        ';
                        echo '</table></form></div>';
                        if (isset($_REQUEST['insColor'])) {
                            $nomeCol=ucfirst($_REQUEST["nomeColor"]);
                            $hexCol= $_REQUEST["hexCode"];
                           
                        
                            $sqlInsertC= 'INSERT INTO colorazioni (denominazione, hex)
                            VALUES ("'.$nomeCol.'","'.$hexCol.'")';
                            $exeIC= $exe2= mysqli_query($con, $sqlInsertC);
                            if($exeIC){
                                echo '<script>alert("Colorazione inserita con successo") </script>';
                            }
                        }
                        echo '</div>'; /* <- DIV bianco */
                    
                        /* Operazioni dopo il submit */

                        break;
                }

                switch ($tipo) {
                    case 'rivenditori':
                    case 'privati':
                        $sql = "SELECT * from specie";
                        $esegui = mysqli_query($con, $sql);
                        $num = mysqli_num_rows($esegui);

                        echo '<div id= "articlescontainer">';
                        for ($i = 0; $i < $num; $i++) {
                            /*  echo $num; */
                            $row = $esegui->fetch_array(MYSQLI_ASSOC);
                            $qPrezzo = "SELECT * from prezzi where dataFine IS NULL AND idSpecie=" . $row['idSpecie'];
                            /*  echo $qPrezzo; */
                            $exePrezzo = mysqli_query($con, $qPrezzo);
                            if ($exePrezzo) {
                                $pInfo = $exePrezzo->fetch_array(MYSQLI_ASSOC);
                                echo '<div class="article-container">
                            <form action="index.php">
                                <div class="article-img-container">
                                <img src="/Fioraio/imgs/' . $row['nome'] . '.jpg" alt="' . $row['nome'] . '">
                                </div>
                                <div class="article-info-container">
                                <p>Denominazione : ' . $row['nome'] . '</p>
                                <p>Prezzo : ' . $pInfo['prezzo'] . '€</p>
                                <p>Nome Latino : ' . $row['nomeLatino'] . '</p>
                                <p>Uso : ' . $row['uso'] . '</p>
                                <p>Esotica: ' . $row['esotica'] . '</p>
                                <p>Tipo: ' . $row['tipo'] . '</p>';
                                if ($row['tipo'] === 'Fiorita') {
                                    $sqlColor = 'SELECT sc.*, c.* FROM specie_colorazioni AS sc
                                    INNER JOIN colorazioni as c
                                    ON sc.idColorazione=c.idColorazione AND sc.idSpecie=' . $row['idSpecie'];
                                    $exeColori = mysqli_query($con, $sqlColor);

                                    /*  echo $sqlColor; */

                                    echo 'Colore: <select name="colore">';
                                    if ($exeColori) {
                                        $numr = mysqli_num_rows($exeColori);

                                        for ($j = 0; $j < $numr; $j++) {
                                            $colori = $exeColori->fetch_array(MYSQLI_ASSOC);
                                            echo '<option value=' . $colori['idColorazione'] . '>' . $colori['denominazione'] . '</option>';
                                        }
                                        echo '</select>';
                                    }
                                }
                                echo '<input type="text" name="idSpecie" id="" value =' . $row['idSpecie'] . ' style="display:none">
                                <br>Quantità: <input type="number" name="quantita" id="" min="1" max="100" value=1> <br>
                                <input type="submit" value="Acquista" name="AcquistaA">';
                                echo '</div>
                            </div></form>';
                            }
                        }

                        echo '</div>';

                        echo '<div id="orderscontainer" style="display:none">
                       ';
                        echo '<form action="index.php">
                       <input type="submit" value="Aggiorna">
                       </form> ';
                        echo '<h3>Ordini effetuati</h3>';
                        switch ($tipo) {
                            case 'privati':
                                $qOrdini = "SELECT sc.* , s.*
                               FROM specie_privati as sc 
                               INNER JOIN specie as s
                               ON s.idSpecie=sc.idSpecie WHERE sc.idPrivato=" . $_SESSION['idPrivato'] . ' ORDER BY sc.data DESC, idSP DESC';

                                break;

                            case 'rivenditori':
                                $qOrdini = "SELECT sc.* , s.*
                                FROM specie_rivenditori as sc 
                                INNER JOIN specie as s
                                ON s.idSpecie=sc.idSpecie WHERE sc.idRivenditore=" . $_SESSION['idRivenditore'] . ' ORDER BY sc.data DESC, idSR DESC';

                                break;
                        }
                        /*  echo $qOrdini; */
                        $exeOrdini = mysqli_query($con, $qOrdini);
                        $nums = mysqli_num_rows($exeOrdini);
                        if ($exeOrdini) {
                            if ($nums == 0) {
                                echo '<h4>Non ci sono ordini da te effettuati</h4>';
                            }
                            echo '<div id="table-container">';
                            echo '<table id="ordini-table">
                            <tr>
                            <td class="toColor">Data ordine</td>
                            <td class="toColor">Articolo</td>
                            <td class="toColor">Quantità</td>
                            <tr>
                            ';
                            for ($k = 0; $k < $nums; $k++) {
                                $row = $exeOrdini->fetch_array(MYSQLI_ASSOC);
                                echo '<tr>
                            <td>' . $row["data"] . '</td>
                            <td>' . $row["nome"] . '</td>
                            <td>' . $row["quantita"] . '</td>
                            </tr>
                            ';
                            }
                        }
                        echo '</table>';
                        echo '</div>';
                        /*  echo $qOrdini; */
                        echo '</div>';
                        break;
                    case 'admin':

                        # code...
                        break;
                }
                if (isset($_REQUEST['AcquistaA'])) {
                    $colore = "NULL";

                    if (isset($_REQUEST['colore'])) {
                        $colore = $_REQUEST['colore'];
                    }
                    $tipo = $_SESSION['tipo'];
                    switch ($tipo) {
                        case 'privati':
                            $queryRegAcc = "INSERT INTO specie_privati (idPrivato,";
                            $id = $_SESSION['idPrivato'];
                            break;

                        case 'rivenditori':
                            $queryRegAcc = "INSERT INTO specie_rivenditori (idRivenditore,";
                            $id = $_SESSION['idRivenditore'];
                            break;
                    }
                    $qnt = $_REQUEST['quantita'];
                    $oggi = getdate();
                    $dataT = $oggi['year'] . '-' . $oggi['mon'] . '-' . $oggi['mday'];
                    $idSpecie = $_REQUEST['idSpecie'];
                    $queryRegAcc = $queryRegAcc . 'idSpecie,data,quantita,idColorazione)
                    VALUES ("' . $id . '","' . $idSpecie . '","' . $dataT . '","' . $qnt . '",' . $colore . ')';
                    /* echo $queryRegAcc; */

                    $exequeryRA = mysqli_query($con, $queryRegAcc);
                    if ($exequeryRA) {

                        echo '<script>alert("Acquisto registrato con successo") </script>';
                    } else {
                        echo '<script>alert("' . $con->error . '")</script>';
                    }
                    /* echo' alert("Acquisto")</script>'; */
                } else {
                }
            } else {
                header('location:login.php');
            }
            ?>
        </div>
    </div>

    <script>
        let oBtn = $('#ordiniBtn');
        let mBtn = $('#marketBtn');

        oBtn.on("click", function() {
            marketBtn.style.display = ""
            ordiniBtn.style.display = "none"
            orderscontainer.style.display = ""
            articlescontainer.style.display = "none"

        })
        mBtn.on("click", function() {
            marketBtn.style.display = "none"
            ordiniBtn.style.display = ""
            orderscontainer.style.display = "none"
            articlescontainer.style.display = "grid"
        })

        $('input[type=radio][name=specieTipo]').change(function() {
            console.log("ok")
            if (this.value == 'verde') {
                checkboxColor.style.display = "none"

            }
            if (this.value == 'fiorita') {
                checkboxColor.style.display = ""

            }
        })
        /*         if(!$('div.checkbox-group.required :checkbox:checked').length > 0){
                    
                } */
    </script>
</body>

</html>