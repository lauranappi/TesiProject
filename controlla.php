<?php
session_start();
include('functions.php');
$nomeDoc=$_POST["nomeDoc"];
$cognome=$_POST["cognome"];
$conn=connetti_al_database();
$s="SELECT nomeDoc, cognome FROM docente WHERE nomeDoc='$nomeDoc' and cognome='$cognome'";
$query=mysqli_query($conn,$s);
$n=mysqli_num_rows($query);
$errore=mysqli_error($conn);
if($errore)
{
    echo $errore;
}else{
if($n!=0)
{
    $_SESSION["nomeDoc"]=$nomeDoc;
    $_SESSION["cognome"]=$cognome;
    header("Location: docente.php");
}
else {
    $_SESSION['msg']="nome e/o cognome errati o mancanti";
    header("Location: docente.php");
} 
}

if(isset($conn))
{
    $close=mysqli_close($conn);
}
?>