<?php
session_start();
include('functions.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <title>ESAMI UNITO - Sezione docenti</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css"/>
  <link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>""/>
</head>

<body>

<div>
        <img src="immagini/logo_unito.svg" style="width: 15%; heigth: 4%; 
        margin-top: 1%; margin-left: 1%;">
        </div>
    

    <div class="centered" style="font-size: 12px;
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a>

<?php
    if(isset($_SESSION["cognome"]) && isset($_SESSION["nomeDoc"]))
    {
        echo "&nbsp;&nbsp; | &nbsp;&nbsp; <a href=\"logout.php\">CAMBIA NOME E COGNOME</a></div>";
        $cognome=$_SESSION["cognome"];
        $cognome1=Ucwords($cognome);
        echo "<div style='background-color: #e9ecef; padding: 1%;'>
        <h1 class=\"centered\">Buongiorno, Prof.ssa/Prof. $cognome1</h1><br/>
        <p class='centered testo'>Di seguito, trova i corsi tenuti da Lei, di cui non ha ancora proposto le date degli esami, sui quali può 
        cliccare e poi proporre una data e orario per
        ogni appello.</p></div><br/>";
        
        $conn=connetti_al_database();

    $mat="SELECT matricola FROM docente WHERE cognome='$cognome'";
    $query1=mysqli_query($conn,$mat);
    $n=mysqli_num_rows($query1);

    foreach($query1 as $riga){
      $matricola=$riga["matricola"];
      $_SESSION["matricola"]=$matricola;
    }

    $s="SELECT nomeCorso 
    FROM corso INNER JOIN insegna ON corso.codCorso=insegna.codCorso
    INNER JOIN docente ON insegna.matricola=docente.matricola
     WHERE docente.matricola=$matricola";
        $query=mysqli_query($conn,$s);
        $n=mysqli_num_rows($query);


        $errore=mysqli_error($conn);
if($errore)
{
    echo $errore;
}else{
        if($n!=0)
        {

            foreach($query as $riga)
            {   $nomeCorso=$riga["nomeCorso"];

                $l="SELECT codCorso FROM corso WHERE nomeCorso='$nomeCorso'";
                $que=mysqli_query($conn,$l);
                $abc=mysqli_num_rows($que);
            
                foreach($que as $riga){
                  $idCorso=$riga["codCorso"];
                }

                $r="SELECT idCorso, matDocente
                FROM appello
                WHERE idCorso='$idCorso' AND matDocente='$matricola'";
        $quer=mysqli_query($conn,$r);
        $f=mysqli_num_rows($quer);

        $error=mysqli_error($conn);
        if($error)
        {
        echo $error;
        }else{
        if($f==0)
        {
                
                echo "<div style='padding-left: 2%; text-align: center;'>
                <form action='sessione.php' method='post'>
                <input type='hidden' name='nomeCorso' value='$nomeCorso'>
                <input type='submit' class='button2' style='width: 90%;' value='$nomeCorso'></form><br/></div>";
        }}
            }
        }    else{
            echo "<center><h3>Nessun corso disponibile</h3>
            <br><br><a href='index.php'>Indietro</a></center>" ;
        }

    }   

    }else{
            echo "<center><h2>Per poter procedere, devi inserire nome e cognome.</h2></center>";
    }
    if(isset($conn))
{
    $close=mysqli_close($conn);
}

	else{
        echo "<div class=\"areadoc\" style=\"text-align:center;\">";
        if(isset($_SESSION['msg'])){
            $msg = $_SESSION['msg'];
            echo "<p style='color: red;' class='testo'>$msg</p>";
            unset($_SESSION['msg']);
    }
        echo "<form action=\"controlla.php\" method=\"POST\">
		<label for=\"nome\">Nome:</label> <input type=\"text\" name=\"nomeDoc\" id=\"nome\"><br><br>
		<label for=\"cogn\">Cognome:</label> <input type=\"text\" name=\"cognome\" id=\"cogn\"><br><br>
		<input type=\"submit\" value=\"Accedi\" class=\"button1\" ></form></div><p>";
    }
    echo "</p>";

    include('footer.php');
    ?>
</body>
</html>
