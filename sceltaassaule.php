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
  <link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>""/>
</head>
<body>
<div>
        <img src="immagini/logo_unito.svg" style="width: 15%; heigth: 4%; margin-top: 1%; margin-left: 1%;">
        </div>
    

    <div class="centered" style="font-size: 12px;
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a> &nbsp;&nbsp;| &nbsp;&nbsp;<a href="segreteria.php">TORNA ALL'AREA SEGRETERIA</a></div>

</div>

<div style="background-color: #e9ecef; padding: 1%;" class="centered">
<h1>Filtri per l'assegnazione delle aule</h1>
<p class="testo">Seleziona un filtro e premi invio per visualizzare l'assegnazione delle aule filtrata, 
oppure clicca sul bottone per vederla senza filtri.</p>
</div><br/><br/>
 
<div style='padding-left: 2%;  padding-right: 2%;font-size: 13px;'>
<?php
if(isset($_SESSION['mexx'])){
    $mexx = $_SESSION['mexx'];
    echo "<p style='color: red;'>$mexx</p>";
    unset($_SESSION['mexx']);
}
?><div class="centered">
<form  action='aule.php' method='post'>
<input type="submit" class="button2" value="Vai all'assegnazione aule senza filtri">
</form><br/></div>
<form action='aule.php' method='post'>
<p style='background-color: #e9ecef; margin-bottom: 0px;'><strong>Filtro per numero appello (primo, secondo ecc...)</strong></p><br/>
<label for='appello'></label><select name='nappelli' id='appello'>
    <option value="-">-</option>
    <?php
    $conn=connetti_al_database();

    $s="SELECT distinct nappello 
    FROM appello";
    $query=mysqli_query($conn,$s);
    $n=mysqli_num_rows($query);
                    
    $errore=mysqli_error($conn);
    if($errore)
    {
        echo $errore;
    }
                    
                    foreach($query as $riga){
                        $nappello=$riga["nappello"];
                        echo "<option value='$nappello'>$nappello</option>";
                    }
?>
</select> 
<input type="submit" class="button2" value="Invia">

</form>

<form action='aule.php' method='post'>
<p style='background-color: #e9ecef; margin-bottom: 0px;'><strong>Filtro per corso di laurea</strong></p><br/>
<label for='corso'></label><select name='corsi' id='corso'>
    <option value="-">-</option>
    <?php
    $conn=connetti_al_database();

    $s="SELECT distinct corsodiLaurea 
FROM appello JOIN corso 
ON idCorso=codCorso";
    $query=mysqli_query($conn,$s);
    $n=mysqli_num_rows($query);
                    
    $errore=mysqli_error($conn);
    if($errore)
    {
        echo $errore;
    }
                    
                    foreach($query as $riga){
                        $corsodiLaurea=$riga["corsodiLaurea"];
                        echo "<option value='$corsodiLaurea'>$corsodiLaurea</option>";
                    }
?>
</select> 
<input type="submit" class="button2" value="Invia">

</form>

<form action='aule.php' method='post'>
<p style='background-color: #e9ecef; margin-bottom: 0px;'><strong>Filtro per tipo di aula e dimensioni</strong></p><br/>
<label for='aula'>Aula:</label> <select name='tipo' id='aula'>
    <option value="-">-</option>
    <?php
    $conn=connetti_al_database();

    $s="SELECT distinct tipoAula 
FROM appello";
    $query=mysqli_query($conn,$s);
    $n=mysqli_num_rows($query);
                    
    $errore=mysqli_error($conn);
    if($errore)
    {
        echo $errore;
    }
                    
                    foreach($query as $riga){
                        $tipoaula=$riga["tipoAula"];
                        echo "<option value='$tipoaula'>$tipoaula</option>";
                    }
?>
</select> 
<br/><label for='postii'>Posti:</label> <select name='posti' id='postii'>
<option value='-'>-</option>
    <option value='posti>200'>più di 200</option>
    <option value='posti<=200 and posti>=100'>tra 100 e 200</option>
    <option value='posti<=100 and posti>=50'>tra 50 e 100</option>
    <option value='posti<50'>meno di 50</option>
</select>
<input type="submit" class="button2" value="Invia">

</form>

<form action='aule.php' method='post'>
<p style='background-color: #e9ecef; margin-bottom: 0px;'><strong>Filtro per data proposta</strong></p><br/>
<label for='dataa'></label><select name='data' id='dataa'>
    <option value="-">-</option>
    <?php
    $conn=connetti_al_database();

    $s="SELECT distinct data 
FROM appello";
    $query=mysqli_query($conn,$s);
    $n=mysqli_num_rows($query);
                    
    $errore=mysqli_error($conn);
    if($errore)
    {
        echo $errore;
    }
                    
                    foreach($query as $riga){
                        $data=$riga["data"];
                        echo "<option value='$data'>$data</option>";
                    }
?>
</select> 
<input type="submit" class="button2" value="Invia">

</form>

<form action='aule.php' method='post'>
<p style='background-color: #e9ecef; margin-bottom: 0px;'><strong>Filtro per docente</strong></p><br/>
<label for='docenti'></label><select name='docente' id='docenti'>
    <option value="-">-</option>
    <?php
    $conn=connetti_al_database();

    $s="SELECT distinct matDocente, cognome, nomeDoc 
    FROM appello JOIN docente 
    ON matDocente=matricola";
    $query=mysqli_query($conn,$s);
    $n=mysqli_num_rows($query);
                    
    $errore=mysqli_error($conn);
    if($errore)
    {
        echo $errore;
    }
                    
                    foreach($query as $riga){
                        $matricola=$riga["matDocente"];
                        $nome=$riga["nomeDoc"];
                        $cognome=$riga["cognome"];
                        echo "<option value='$matricola'>$nome $cognome</option>";
                    }
?>
</select> 
<input type="submit" class="button2" value="Invia">

</form>
                </div><br/><br/><br/><br/>
<?php
    include('footer.php');
 ?>
</body>
</html>