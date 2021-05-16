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
            /* display: flex;
            justify-content: center; */
            margin: auto;
        }

        .toColor {
            background-color: orange;
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
                       <form action="index.php" >
                        <input type="submit" value="Log out" name="logOut" id="esci">
                        </form></div>';
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
                                echo '<tr id="checkboxColor" style="display:none"><td>Colore:</td>';
                                for ($k = 0; $k < $num; $k++) {
                                    $riga = $esegui->fetch_array(MYSQLI_ASSOC);
                                    echo '<td><input type="checkbox" id="colore' . $k . '" name="colore' . $k . '" value="' . $riga["idColorazione"] . '">' . $riga["denominazione"] . '|</td>';
                                }
                                echo '</tr>';
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
                        echo '<tr><td>Carica Immagine pianta:</td>
                         <td><input type="file" name="fileToUpload" id="fileToUpload">';
                        echo '<tr><td colspan="2"><input type="submit" value="Inserisci Specie" name="insertSpecie"></td></tr>';
                        echo '</table></form>';
                        echo '</div>';
                        if (isset($_POST['insertSpecie'])) {
                            $nomeS = $_POST["specieN"];
                            $nomeLatS = $_POST["specieLatinN"];
                            $uso = $_POST["specieUso"];
                            $esotica = $_POST["specieEsotica"];
                            $sTipo = $_POST["specieTipo"];
                            if ($sTipo === "fiorita") {
                                $insColori = $_POST["colore"];
                            }
                            $idFornitore = $_POST['idFornitore'];
                            $target_dir = "C:/xampp/htdocs/Fioraio/imgs/";
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            $uploadOk = 1;
                            $nomeFile= substr(  basename($_FILES["fileToUpload"]["name"]),0,-4);
                          
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if ($check !== false) {
                                /* echo "File is an image - " . $check["mime"] . "."; */
                                $uploadOk = 1;
                            } else {
                                echo "<p>Il file non è un immagine.</p>";
                                $uploadOk = 0;
                            }
                            if($nomeFile!=$nomeS){
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
                              } else {
                                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                  echo "<p>Il ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " è stato caricato.";
                                } else {
                                  echo "<p>C'è stato un errore nel caricamento dell'immagine.</p>";
                                }
                              }
                            echo $nomeS . $nomeLatS . $sTipo;
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
        console.log("ok")
        oBtn.on("click", function() {
            marketBtn.style.display = ""
            ordiniBtn.style.display = "none"
            orderscontainer.style.display = ""
            articlescontainer.style.display = "none"
            console.log("ok")
        })
        mBtn.on("click", function() {
            marketBtn.style.display = "none"
            ordiniBtn.style.display = ""
            orderscontainer.style.display = "none"
            articlescontainer.style.display = "grid"
        })
        $('input[type=radio][name=specieTipo]').change(function() {

            if (this.value == 'privati') {
                $('#rIVA').addClass('unRequired')
                $('#rIVA').prop('required', false);
                $('#rEmail').removeClass('unRequired');
                $('#rEmail').prop('required', true);
                $('.unRequired').val('')
                /* rIVA.style.display='none';
                rEmail.style.display=''; */

            }
            if (this.value == 'rivenditori') {
                $('#rEmail').addClass('unRequired')
                $('#rEmail').prop('required', false);
                $('#rIVA').removeClass('unRequired');
                $('#rIVA').prop('required', true);
                $('.unRequired').val('')
                /*  rIVA.style.display='';
                 rEmail.style.display='none'; */

            }
        })
    </script>
</body>

</html>