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
  <style>
form label {
        display: inline-block;
        text-align:left;
        width:100px;
        padding: 10px 0;
    }

    select:not(.aule), input[type=text], input[type=date]:not(.aule), input[type=time]:not(.aule), input[type=number]:not(.aule), textarea {
    width: 50%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
    </style>
</head>

<body>

<div>
        <img src="immagini/logo_unito.svg" style="width: 15%; heigth: 4%; margin-top: 1%; margin-left: 1%;">
        </div>
    

    <div class="centered" style="font-size: 12px;
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="sessione.php">TORNA ALLA SCELTA DELLA SESSIONE</a></div>

</div>
<?php

$conn=connetti_al_database();

$nomeCorso=$_SESSION["nomeCorso"];

$cognome=$_SESSION["cognome"];

if(isset($_POST["nomeSes"])){
  $sessione=$_POST["nomeSes"];
  $_SESSION["nomeSes"]=$sessione;
}

$sessione=$_SESSION["nomeSes"];

$durata="SELECT inizio, fine FROM sessioni WHERE nomeSes='$sessione'";
$query1=mysqli_query($conn,$durata);
$n=mysqli_num_rows($query1);

foreach($query1 as $riga){
  $inizio=$riga["inizio"];
  $fine=$riga["fine"];
}

$dip="SELECT dipartimento FROM corso WHERE nomeCorso='$nomeCorso'";
$query=mysqli_query($conn,$dip);
$n=mysqli_num_rows($query);

foreach($query as $riga){
  $dipartimento=$riga["dipartimento"];
  $_SESSION["dipartimento"]=$dipartimento;
}

$app="SELECT numAppelli FROM sessioni 
WHERE nomeSes='$sessione'";
$query1=mysqli_query($conn,$app);
$n=mysqli_num_rows($query1);

foreach($query1 as $riga){
  $appelli=$riga["numAppelli"];
  $_SESSION["numAppelli"]=$appelli;
}

$appelli=$_SESSION["numAppelli"];
$dipartimento=$_SESSION["dipartimento"];

?>
<div style="background-color: #e9ecef; padding: 1%;"><h1 class="centered">Proposta delle date</h1>
<p class="testo centered">Per ogni appello della sessione, <u>seleziona la modalità</u> (scritto e/o orale) e compila 
i dati <u>solo</u> per ogni opzione <u>selezionata.</u><br/>
Una volta premuto il tanto "Invia", non sarà più possibile modificare i dati inseriti.</p><br/>
<?php
echo "<p class=\"testo\"><strong>Corso:</strong> $nomeCorso <br/><strong>Sessione:</strong> $sessione - <strong>dal</strong> 
$inizio <strong>al</strong> $fine</p></div>";
?>
<p style="color: red; padding-left: 2%; padding-top: 1%;" class="testo">
<?php
if(isset($_SESSION['mex'])){
            echo $mex = $_SESSION['mex']; 
            unset($_SESSION['mex']);
        }
?>
</p>
<div style='padding-left: 2%;  padding-right: 2%;font-size: 13px;'>
<form action="inviodati.php" method="post">
<?php

//non ho fatto array in checkbox perché mi dava errore con []$i
//decidere range ora inizio e ora fine
for($i=1; $i<=$appelli; $i++){
    echo "<p style='background-color: #e9ecef; margin-bottom: 0px;'><strong>Appello numero $i</strong></p><br/>
    <input type='checkbox' name='tipoappello$i' id='myCheck$i' value='Scritto'>
    <strong>Scritto</strong><br/>
    <p id='text$i'>
    <input type='hidden' name='nappello$i' value='$i'>
    <label for='dataa$i'>Data:</label> <input type='date' name='data$i' id='dataa$i'><br/>
    <label for='orainizioo$i'>Ora Inizio:</label> <input type='time' name='orainizio$i' id='orainizioo$i'><br/>
    <label for='orafineee$i'>Ora Fine:</label> <input type='time' name='orafine$i' id='orafinee$i'><br/>
    <label for='tipoaulaa$i'>Tipo aula:</label>
    <select name='tipoaula$i' id='tipoaulaa$i'>
    <option value=''>--</option>
    <option value='Normale'>Normale</option>
    <option value='Informatica'>Informatica</option>
    <option value='Linguistica'>Linguistica</option>
    </select></br>
    <label for='postii$i'>Posti necessari:</label> <input type='number' name='posti$i'  id='postii$i'><br/>
    <label for='notee$i'>Note:</label> <textarea id='notee$i' name='note$i' placeholder='Scrivi qui le tue eventuali note per la segreteria'></textarea></p>
    
    <input type='checkbox' name='tipoappello1$i' id='myCheck1$i' 
    value='Orale'><strong> Orale</strong>
    <br/>
    <p id='text1$i'>
    <input type='hidden' name='nappello$i' value='$i'>
    <label for='dataa1$i'>Data:</label> <input type='date' name='data1$i' id='dataa1$i'><br/>
    <label for='orainizioo1$i'>Ora Inizio:</label> <input type='time' name='orainizio1$i' id='orainizioo1$i'><br/>
    <label for='orafinee1$i'>Ora Fine:</label> <input type='time' name='orafine1$i' id='orafinee1$i'><br/>
    <label for='tipoaulaa1$i'>Tipo aula:</label>
    <select name='tipoaula1$i' id='tipoaulaa1$i'>
    <option value=''>--</option>
    <option value='Normale'>Normale</option>
    <option value='Informatica'>Informatica</option>
    <option value='Linguistica'>Linguistica</option>
    </select></br>
    <label for='postii1$i'>Posti necessari:</label> <input type='number' name='posti1$i' id='postii1$i'><br/>
    <label for='notee1$i'>Note:</label> <textarea id='notee1$i' name='note1$i' placeholder='Scrivi qui le tue eventuali note per la segreteria'></textarea></p>
";
    
}
?>
<br/><input type="submit" class="button2" value="Invia">
</form></div><br/><br/><br/><br/><br/>
  <?php
include('footer.php');
?>
</body>
</html>