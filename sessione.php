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
</head>
<body>
<div>
        <img src="immagini/logo_unito.svg" style="width: 15%; heigth: 4%; margin-top: 1%; margin-left: 1%;">
        </div>
    

    <div class="centered" style="font-size: 12px;
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="docente.php">TORNA AI TUOI CORSI</a></div>

</div>

<div style="background-color: #e9ecef; padding: 1%;" class="centered"><h1>
Scelta della sessione
</h1>
<p class='testo'>Scegli la sessione per cui vuoi compilare gli appelli del corso.</p></div><br/><br/>
 <?php
$conn=connetti_al_database();

$matricola=$_SESSION["matricola"];

if(isset($_POST["nomeCorso"])){
$nomeCorso=$_POST["nomeCorso"];
$_SESSION["nomeCorso"]=$nomeCorso;
}
$nomeCorso=$_SESSION["nomeCorso"];

$dip="SELECT dipartimento FROM docente
WHERE matricola='$matricola'";
    $query1=mysqli_query($conn,$dip);
    $n=mysqli_num_rows($query1);

    foreach($query1 as $riga){
      $dipartimento=$riga["dipartimento"];
    }

$s="SELECT nomeSes 
    FROM sessioni
    WHERE dipartimento='$dipartimento'";
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
            {   $sessioni=$riga["nomeSes"];
                echo "<div style='padding-left: 2%; text-align: center;'>
                <form action='corsi.php' method='post'>
                <input type='hidden' name='nomeSes' value='$sessioni'>
                <input type='submit' class='button2' style='width: 90%;' value='$sessioni'></form><br/></div>";

            }
        }    else{
            echo "<center><h3>Nessuna sessione disponibile</h3>
            <br><br><a href='index.php'>Home</a></center>" ;
        }
    }

    include('footer.php');

        ?>




</body>
</html>