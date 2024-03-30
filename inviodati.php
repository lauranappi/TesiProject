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
<?php

$nomeCorso=$_SESSION["nomeCorso"];
$cognome=$_SESSION["cognome"];
$appelli=$_SESSION["numAppelli"];
$dipartimento=$_SESSION["dipartimento"];

  $sessione=$_SESSION["nomeSes"];

$ore8="08:00:00";
$ore20="20:00:00";


$conn=connetti_al_database();

$duratases="SELECT inizio,fine FROM sessioni 
WHERE dipartimento='$dipartimento' and nomeSes='$sessione'";
$query2=mysqli_query($conn,$duratases);
$n2=mysqli_num_rows($query2);

foreach($query2 as $riga){
  $inizio=$riga["inizio"];
  $fine=$riga["fine"];
}

$cor="SELECT codCorso FROM corso WHERE nomeCorso='$nomeCorso'";
$query=mysqli_query($conn,$cor);
$n=mysqli_num_rows($query);

if($n!=0)
        {

            foreach($query as $riga){
                $corso=$riga["codCorso"];

        }
}else{
    echo "errore";
}

$doc="SELECT matricola FROM docente WHERE cognome='$cognome'";
$query=mysqli_query($conn,$doc);
$n=mysqli_num_rows($query);

if($n!=0)
        {

            foreach($query as $riga){
                $docente=$riga["matricola"];

        }
}else{
    echo "errore";
}


$scritto=0;
$orale=1;

for($i=1; $i<=$appelli; $i++){

    if(isset($_POST["tipoappello$i"]) || isset($_POST["tipoappello1$i"])){

        $nappello=$_POST["nappello$i"];

if(isset($_POST["tipoappello$i"])){


    if($_POST["data$i"]!="" && isset($_POST["orainizio$i"]) && 
    isset($_POST["orafine$i"]) && isset($_POST["tipoaula$i"]) && isset($_POST["posti$i"]) ){


    $scritto=1;

$data=$_POST["data$i"];
$orainizio=$_POST["orainizio$i"];
$orafine=$_POST["orafine$i"];
$tipoaula=$_POST["tipoaula$i"];
$posti=$_POST["posti$i"];
$note=$_POST["note$i"];

if($data>=$inizio && $data<=$fine){

    if($tipoaula!=''){

        if($orainizio<$orafine){

            if($posti>0 && $posti!=""){
    
                if($orainizio>=$ore8 && $orafine<=$ore20){

$s="INSERT INTO appello (idCorso,data,nappello,oraInizio,oraFine,matDocente,tipoAula,scritto,posti, sessione,note)
VALUES ('$corso','$data','$nappello','$orainizio','$orafine','$docente','$tipoaula','$scritto','$posti','$sessione','$note')";
$risp=mysqli_query($conn,$s);
$errore=mysqli_error($conn);

if($errore)
{
    echo $errore;
}

}else{
    $_SESSION['mex']="Gli esami non possono iniziare prima delle 8 e finire dopo le 20.";
     header('Location: corsi.php');
}

            }else{
                $_SESSION['mex']="Il numero di posti deve essere compilato e maggiore di 0.";
                header("Location: corsi.php");   
            }

    }else{
        $_SESSION['mex']="L'ora di inizio deve essere precedente all'ora di fine.";
        header("Location: corsi.php");
    }
}else{
    $_SESSION['mex']="Tipologia di aula mancante.";
        header("Location: corsi.php");
}
    }else{
        $_SESSION['mex']="La data deve essere compresa tra la data di inizio e di fine sessione.";
        header("Location: corsi.php");
    }
    }else{
        $_SESSION['mex']="Dati mancanti. Compila tutti i campi di cui hai selezionato l'opzione scritto/orale.";
        header("Location: corsi.php");
    }


}

if(isset($_POST["tipoappello1$i"])){
    
    if($_POST["data1$i"]!="" && isset($_POST["orainizio1$i"]) && 
    isset($_POST["orafine1$i"]) && isset($_POST["tipoaula1$i"]) && isset($_POST["posti1$i"]) ){
    $orale=1;

$data1=$_POST["data1$i"];
$orainizio1=$_POST["orainizio1$i"];
$orafine1=$_POST["orafine1$i"];
$tipoaula1=$_POST["tipoaula1$i"];
$posti1=$_POST["posti1$i"];
$note1=$_POST["note1$i"];

if($data1>=$inizio && $data1<=$fine){

    if($tipoaula1!=''){

        if($orainizio1<$orafine1){

            if($posti1>0 && $posti1!=""){

                if($orainizio1>=$ore8 && $orafine1<=$ore20){

$s1="INSERT INTO appello (idCorso,data,nappello,oraInizio,oraFine,matDocente,tipoAula,orale,posti,sessione,note)
VALUES ('$corso','$data1','$nappello','$orainizio1','$orafine1','$docente','$tipoaula1','$orale','$posti1','$sessione','$note1')";
$risp1=mysqli_query($conn,$s1);
$errore1=mysqli_error($conn);

if($errore1)
{
    echo $errore1;
}

}else{
    $_SESSION['mex']="Gli esami non possono iniziare prima delle 8 e finire dopo le 20.";
     header('Location: corsi.php');
}

}else{
    $_SESSION['mex']="Il numero di posti deve essere compilato e maggiore di 0.";
    header("Location: corsi.php");   
}

        }else{
            $_SESSION['mex']="L'ora di inizio deve essere precedente all'ora di fine.";
            header("Location: corsi.php");
        }

}else{
    $_SESSION['mex']="Tipologia di aula mancante.";
        header("Location: corsi.php");
}
}else{
    $_SESSION['mex']="La data deve essere compresa tra la data di inizio e di fine sessione.";
    header("Location: corsi.php");
}
}else{
    $_SESSION['mex']="Dati mancanti. Compila tutti i campi di cui hai selezionato l'opzione scritto/orale.";
    header("Location: corsi.php");
}
}
}else{
    $_SESSION['mex']="Per ogni appello, devi selezionare almeno un opzione tra scritto e orale.";
    header("Location: corsi.php");
}
}
?>
        <div style="background-color: #e9ecef; padding: 1%;">
<h1 class="centered">Informazioni registrate con successo.</h1></div>

<?php
include('footer.php');
?>