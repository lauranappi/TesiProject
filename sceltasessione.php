<?php
session_start();
include('functions.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <title>ESAMI UNITO - Sezione segreteria</title>
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
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="segreteria.php">TORNA ALL'AREA SEGRETERIA</a></div>

</div>

<div style="background-color: #e9ecef; padding: 1%;" class="centered"><h1>Scelta delle date per le sessioni</h1>
<p class='testo'>
    Scegli il dipartimento, il nome della sessione e le date di inizio e fine sessione.
Le date scelte faranno da guida alla compilazione della sezione assegnazione aule e alla compilazione
delle proposte delle date da parte dei docenti.</p></div><br/><br/>
 
 <?php

 $conn=connetti_al_database();

$s="SELECT distinct dipartimento
FROM sessioni";
$query=mysqli_query($conn,$s);
$n=mysqli_num_rows($query);
             
$errore=mysqli_error($conn);
if($errore)
{
echo $errore;
 }

 $s1="SELECT distinct nomeSes
FROM sessioni";
$query1=mysqli_query($conn,$s1);
$n1=mysqli_num_rows($query1);
             
$errore1=mysqli_error($conn);
if($errore1)
{
echo $errore1;
 }

 ?>
<div style='padding-left: 2%;  padding-right: 2%;font-size: 13px;'>
<?php
if(isset($_SESSION['msg'])){
    $msg = $_SESSION['msg'];
    echo "<p style='color: red;' class='testo'>$msg</p>";
    unset($_SESSION['msg']);
}
?>
<form action="controlloses.php" method="post">
<label for="dip">Dipartimento:</label> <select name='dipartimenti' id="dip">
<option value=''>-</option>
    <?php
                    foreach($query as $riga){
                        $dipartimento=$riga["dipartimento"];
                        echo "<option value='$dipartimento'>$dipartimento</option>";
                    }
?>
</select><br/>
<label for="ses">Nome della sessione:</label> <select name='sessioni' id="ses">
<option value=''>-</option>
    <?php
                    foreach($query1 as $riga){
                        $sessione=$riga["nomeSes"];
                        echo "<option value='$sessione'>$sessione</option>";
                    }
?>
</select><br/>
<label for="datai">Data di inizio sessione:</label> <input type="date" name="datainizio" id="datai"><br/>
<label for="dataf">Data di fine sessione:</label> <input type="date" name="datafine" id="dataf"><br/><br/>
<input type="submit" class="button2" value="Invia">
</form>
</div>
<?php
    include('footer.php');
 ?>
</body>
</html>