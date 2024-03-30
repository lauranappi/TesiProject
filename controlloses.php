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
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="segreteria.php">
        TORNA ALLA SEZIONE SEGRETERIA</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="sceltasessione.php">TORNA ALLA SEZIONE SCELTA SESSIONI</a></div>

</div>
<?php
if($_POST["dipartimenti"]!="" && $_POST["sessioni"]!="" && $_POST["datainizio"]!=""
&& $_POST["datafine"]!=""){

    $dipartimento=$_POST["dipartimenti"];
    $sessione=$_POST["sessioni"];
    $datai=$_POST["datainizio"];
    $dataf=$_POST["datafine"];

    $conn=connetti_al_database();

    $s1="SELECT dipartimento, nomeSes 
    FROM sessioni
    WHERE dipartimento='$dipartimento' and nomeSes='$sessione'";
    $query1=mysqli_query($conn,$s1);
    $n1=mysqli_num_rows($query1);
                 
    $errore1=mysqli_error($conn);
    if($errore1)
    {
    echo $errore1;
     }

if($n1!=0){

    if($datai<$dataf){
    $a="UPDATE sessioni
    SET inizio='$datai', fine='$dataf'
    WHERE dipartimento='$dipartimento' and nomeSes='$sessione'";

$query=mysqli_query($conn,$a);
$errore=mysqli_error($conn);

if($errore)
{
echo $errore;
}}else{
    $_SESSION['msg']="La data di inizio deve essere precedente dalla data di fine della sessione.";
    header("Location: sceltasessione.php");
}
}else{
    $_SESSION['msg']="Nel dipartimento che hai scelto, la sessione che hai selezionato non esiste.";
    header("Location: sceltasessione.php");
}

}else{
    $_SESSION['msg']="Dati mancanti. Compila tutti i campi proposti.";
    header("Location: sceltasessione.php");
}
?>
        <div style="background-color: #e9ecef; padding: 1%;">
<h1 class="centered">Informazioni registrate con successo.</h1></div>

<?php
include('footer.php');
?>