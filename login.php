<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>login</title>
    <style>
        .unRequired {
            display: none;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="phone">
            <div id="aFPhone" style="display:none ;">
                <h1 class="wbold">Login</h1>
                <h2 class="small-black">Indica il tuo ruolo</h2>
                <form action="login.php">
                    <div class="radio-container">
                        <label for="Aprivato">Privato</label>
                        <input type="radio" name="aTipo" id="Aprivato" value="privati" checked></td>
                        <label for="Arivenditore">Rivenditore</label>
                        <input type="radio" name="aTipo" id="Arivenditore" value="rivenditori"></td>
                        <label for="admin">Admin</label>
                        <input type="radio" name="aTipo" id="admin" value="admin"></td>
                    </div> <br>
                    <div class="texts-container">
                        <input type="text" name="Auser" placeholder="username" required> <br> <br>
                        <input type="password" name="Apassword" placeholder="password" required>
                    </div>
                    <input type="submit" value="Accedi" name="accBtn">
                </form>
                <p>Non sei registrato? <span><a href="#" id="switch_acc">Registrati</a></span></p>
            </div>
            <div id="rFPhone" style="display: '';">
                <h1 class="wbold">Register</h1>
                <h2 class="small-black">Indica il tuo ruolo</h2>
                <form action="login.php" id="rForm">
                    <div class="radio-container">
                        <label for="Rprivato">Privato</label>
                        <input type="radio" name="rTipo" id="Rprivato" value="privati" checked></td>
                        <label for="Rrivenditore">Rivenditore</label>
                        <input type="radio" name="rTipo" id="Rrivenditore" value="rivenditori"></td>

                    </div> <br>
                    <div class="texts-container">
                        <input type="text" name="nome" placeholder="Nome" required> <br>

                        <input type="email" name="Remail" placeholder="Email" required id="rEmail"><br>
                        <input type="text" name="pIva" placeholder="Partita IVA" id="rIVA" class="unRequired" minlength="11" maxlength="11"><br>
                        <input type="password" name="Rpsw" placeholder="Password" required minlength="8"> <br>
                        <input type="indirizzo" name="ind" placeholder="Indirizzo" required><br>
                    </div>
                    <input type="submit" value="Registrati" name="regBtn">
                </form>
                <p>Hai già un account? <span><a href="#" id="switch_reg">Accedi</a></span></p>
            </div>
        </div>
    </div>
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
    
    if (isset($_REQUEST['regBtn'])) {
        /*   echo' <script>alert("Istruzione eseguita correttamente")</script>'; DEBUG*/
        $rTipo = $_REQUEST['rTipo'];
        $user = $_REQUEST['nome'];
        $password = $_REQUEST['Rpsw'];
        $indirizzo = $_REQUEST['ind'];

        switch ($rTipo) {
            case 'privati':

                $email = $_REQUEST['Remail'];
            
                $sqlCheck = "SELECT * from  privati";
                $queryCheck = mysqli_query($con, $sqlCheck);
                $flag = 0;
                if ($queryCheck) {
                    $num = mysqli_num_rows($queryCheck);
                    for ($i = 0; $i < $num; $i++) {

                        $row = $queryCheck->fetch_array(MYSQLI_ASSOC);
                        if ($row['email'] === $email || $row['nome']===$user) {
                            echo ' <script>alert("Esiste già un Privato con la stessa email o nome utente")</script>';
                            $flag = 1;
                            break;
                        }
                    }
                }
                if ($flag === 0) {

                    $sql = 'INSERT INTO privati (nome,indirizzo,email,password) VALUES ("' . $user . '","' . $indirizzo . '","' . $email . '","' . $password . '")';
                    if ($query = mysqli_query($con, $sql)) {

                        echo ' <script>alert("Privato inserito correttamente ' .   '")</script>';
                    }
                }
                break;

            case 'rivenditori':
                $pIVA = $_REQUEST['pIva'];

                $sqlCheck = "SELECT * from  rivenditori";
                $queryCheck = mysqli_query($con, $sqlCheck);
                $flag = 0;
                if ($queryCheck) {
                    $num = mysqli_num_rows($queryCheck);
                    for ($i = 0; $i < $num; $i++) {

                        $row = $queryCheck->fetch_array(MYSQLI_ASSOC);
                        if ($row['partitaIva'] === $pIVA || $row['nome']===$user) {
                            echo ' <script>alert("Esiste già un Rivenditore con questa Partita IVA o nome utente")</script>';
                            $flag = 1;
                            break;
                        }
                    }
                }
                if ($flag === 0) {

                    $sql = 'INSERT INTO rivenditori (nome,indirizzo,partitaIva,password) VALUES ("' . $user . '","' . $indirizzo . '","' . $pIVA . '","' . $password . '")';
                    if ($query = mysqli_query($con, $sql)) {

                        echo ' <script>alert("Rivenditore inserito correttamente ' .   '")</script>';
                    }
                }

                break;
        }
    } else if (isset($_REQUEST['accBtn'])) {
        $aTipo = $_REQUEST['aTipo'];
      /*    if ($aTipo === 'admin') {
            die;
        }  */
        session_start();
        $user=$_REQUEST['Auser'];
        $pass=$_REQUEST['Apassword'];
        $_SESSION["tipo"] = $aTipo;
        $_SESSION["user"] = $user;
        $user=mysqli_real_escape_string( $con, $user);
        switch ($aTipo) {
            case 'privati':
               $sql="SELECT * FROM privati WHERE nome='".$user."' AND password= '".$pass."'";

            /*   echo $sql;  */
               $query = mysqli_query($con, $sql);
               if ($query) {
                   $num = mysqli_num_rows($query);
                   for ($i = 0; $i < $num; $i++) {
                       $row = $query->fetch_array(MYSQLI_ASSOC);
                    
                       if($row['nome']==$user && $row['password']==$pass){
                           $_SESSION['idPrivato']=$row['idPrivato'];
                           header('location:index.php');
                           break;
                       }
                   }
                   echo' <script>alert("Privato non riconosciuto")</script>';
               }
                break;
            case 'rivenditori':
                $sql="SELECT * FROM rivenditori WHERE nome='".$user."' AND password= '".$pass."'";

             /*    echo $sql; */
                $query = mysqli_query($con, $sql);
                if ($query) {
                    $num = mysqli_num_rows($query);
                    for ($i = 0; $i < $num; $i++) {
                        $row = $query->fetch_array(MYSQLI_ASSOC);
                        if($row['nome']==$user && $row['password']==$pass){
                            $_SESSION['idRivenditore']=$row['idRivenditore'];
                            header('location:index.php');
                            break;
                        }
                    }
                    echo' <script>alert("Rivenditore non riconosciuto")</script>';
                }
                break;
            case 'admin':
                if($user==="admin" && $pass==="admin"){
                    header('location:index.php');
                }
                break; 
        }
    }
    ?>

    <script>
        let sReg = $('#switch_reg');
        let aReg = $('#switch_acc');
        let inputsToD;
        let inputsToE;
        sReg.on('click', function() {
            rFPhone.style.display = 'none';
            aFPhone.style.display = '';
            inputsToD = $('#rFPhone>form>.texts-container :input');
            inputsToE = $('#aFPhone>form>.texts-container :input');
            console.log(inputsToD, inputsToE)
            inputsToD.prop('required', false);
            inputsToE.prop('required', true);
            $('.unRequired').prop('required', false);
            $('.unRequired').val('')
        })
        aReg.on('click', function() {

            aFPhone.style.display = 'none';
            rFPhone.style.display = '';
            inputsToE = $('#rFPhone>form>.texts-container :input');
            inputsToD = $('#aFPhone>form>.texts-container :input');
            console.log(inputsToD, inputsToE)
            inputsToD.prop('required', false);
            inputsToE.prop('required', true);
            $('.unRequired').prop('required', false);
            $('.unRequired').val('')
        })
        $('input[type=radio][name=rTipo]').change(function() {
            console.log('buongiorno')
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