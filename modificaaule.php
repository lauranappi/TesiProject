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
    <?php
    $conn=connetti_al_database();

$appello=$_POST["appello"];

$ses="SELECT sessione FROM appello WHERE idAppello='$appello'";
$query=mysqli_query($conn,$ses);
$n=mysqli_num_rows($query);

foreach($query as $riga){
    $sessione=$riga["sessione"];
  }

    $dipp="SELECT dipartimento FROM appello JOIN corso ON idCorso=codCorso
    WHERE idAppello='$appello'";
        $query3=mysqli_query($conn,$dipp);
        $n2=mysqli_num_rows($query3);

        foreach($query3 as $riga){
            $dipartimento=$riga["dipartimento"];
          }

if($_POST["dataDef"]=="" || $_POST["oraInizioDef"]=="" || $_POST["oraFineDef"]=="" 
|| $_POST["aula"]=="-"){
    $_SESSION['mess']="Id appello numero $appello: Dati mancanti. 
    Compila tutti i campi del form.";
    header('Location: aule.php');
}else{
    $data=$_POST["dataDef"];
    $orai=$_POST["oraInizioDef"];
    $oraf=$_POST["oraFineDef"];
    $aula=$_POST["aula"];

    $duratases="SELECT inizio,fine FROM sessioni 
    WHERE nomeSes='$sessione'";
    $query2=mysqli_query($conn,$duratases);
    $n2=mysqli_num_rows($query2);
    
    foreach($query2 as $riga){
      $inizio=$riga["inizio"];
      $fine=$riga["fine"];
    }

    $aulaa="SELECT tipoAula, posti FROM appello 
WHERE idAppello='$appello'";
    $query4=mysqli_query($conn,$aulaa);
    $n3=mysqli_num_rows($query4);

    foreach($query4 as $riga){
        $tipoAula=$riga["tipoAula"];
        $posti=$riga["posti"];
      }

    $aula1="SELECT tipoAula, posti FROM aule 
        WHERE nomeAula='$aula'";
            $query5=mysqli_query($conn,$aula1);
            $n4=mysqli_num_rows($query5);
        
            foreach($query5 as $riga){
                $tipoAula1=$riga["tipoAula"];
                $posti1=$riga["posti"];
              }

    if($data>=$inizio && $data<=$fine){

        if($orai<$oraf){

            $ore8="08:00:00";
            $ore20="20:00:00";

            if($orai>=$ore8 && $oraf<=$ore20){

            if($tipoAula==$tipoAula1 && $posti<=$posti1){

        $a="UPDATE appello
        SET dataDef='$data', oraInizioDef='$orai',  oraFineDef='$oraf', aula='$aula'
        WHERE idAppello='$appello'";

$query=mysqli_query($conn,$a);
$errore=mysqli_error($conn);

if($errore)
{
    echo $errore;
}

$_SESSION['mess']="Id appello numero $appello: Operazione eseguita con successo!";
header("Location: aule.php");


}else{
    $_SESSION['mess']="Id appello numero $appello: Il tipo di aula o il numero di posti
     non è adatto alle richieste del docente";
     header('Location: aule.php');
}}else{
    $_SESSION['mess']="Id appello numero $appello: Gli esami non possono iniziare prima delle 8 e finire dopo le 20.";
     header('Location: aule.php');
}
}else{
    $_SESSION['mess']="Id appello numero $appello: L'ora di inizio deve essere precedente all'ora di fine.";
    header('Location: aule.php');

}}else{
        $_SESSION['mess']="Id appello numero $appello: La data deve essere compresa tra l'inizio e la fine della sessione $sessione.";
        header('Location: aule.php');

    }

}

    ?>
    </body>
    </html>