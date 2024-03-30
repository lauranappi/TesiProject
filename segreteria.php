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
  <link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>""/>

  <style>
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {background-color: #e9ecef;}


</style>
</head>
<body>
<?php
include('header.html')
?>
<div style="background-color: #e9ecef; padding: 1%;">
<h1 class="centered">Area segreteria</h1>
<p class="centered testo">In questa sezione, puoi visionare le proposte dei docenti scegliendo una vista a sinistra e 
    premendo il pulsante "Invia", oppure assegnare le aule premendo il pulsante "Clicca qui" 
    a destra.</p></div>
    <div class="container-fluid">
    <div class="col-sm-4 areadoc">
<form action="segreteria.php" method="post">
    Vista per:
    <select name="vista">
    <option value="">Seleziona tipo di vista</option>
<option value="nomeCorso">Corso</option>
<option value="corsodiLaurea, anno, semestre">Corso di laurea, anno e semestre</option>
<option value="data, tipoAula">Giorno proposto e tipo di aula</option>
<option value="dataDef, tipoAula">Giorno definitivo e tipo di aula</option>
<option value="tipoAula">Tipo di aula</option>
    </select>
    <input type="submit" class="button2" value="Invia">
</form>
</div>
    <div class="col-sm-3 areadoc">
        <h2>Assegnazione aule</h2>
        <p>
         In questa sezione potrai assegnare le aule, la data e l'ora di ogni appello di cui è stata fatta una proposta
         da un docente, in modo definitivo, anche visualizzando le proposte dei docenti con vari filtri.   
        </p>
<form action="sceltaassaule.php" method="post">
    <input type="submit" class="button2" value="Clicca qui">
</form>
</div>
<div class="col-sm-3 areadoc"><br/>
<h2>Scelta inizio e fine sessioni</h2>
        <p>
          In questa sezione potrai scegliere l'inizio e la fine delle sessioni per ogni dipartimento.
        </p><br/>
        <form action="sceltasessione.php" method="post">
    <input type="submit" class="button2" value="Clicca qui">
</form>
<br/></div>

<?php

if(isset($_SESSION['messa'])){
    $messa = $_SESSION['messa'];
    echo "<div class='col-sm-12 centered testo'><hr><p style='color: green;'>$messa</p><hr></div>";
    unset($_SESSION['messa']);
}

if(isset($_POST["vista"])){
    if($_POST["vista"]!=""){
    $vista= $_POST["vista"];

$conn=connetti_al_database();

    $dip="SELECT idAppello, idCorso, nomeCorso, data, oraInizio, oraFine, dataDef, oraInizioDef, oraFineDef, matDocente, 
    aula, tipoAula, scritto, orale, posti, corsodiLaurea, anno, semestre, sessione, note
     FROM appello JOIN corso 
    ON idCorso=codCorso
     ORDER BY $vista";

$query=mysqli_query($conn,$dip);
$n=mysqli_num_rows($query);
$errore=mysqli_error($conn);

if($vista=="nomeCorso"){
    $titolo="nome del corso";
}elseif($vista=="corsodiLaurea, anno, semestre"){
    $titolo="corso di laurea, anno, semestre";
}elseif($vista=="data, tipoAula"){
    $titolo="data proposta, tipo di aula";
}elseif($vista=="tipoAula"){
    $titolo="tipo di aula";
}elseif($vista=="dataDef, tipoAula"){
    $titolo="data definitiva, tipo di aula";
}

if($errore)
{
    echo $errore;
}else{
            if($n!=0){

echo "<div class='col-sm-12 centered' style='font-size: 12px;
padding: 1%;'><form action='scarica.php' method='post'>
<input type='hidden' name='vista' value='$vista'>
<input type='submit' class='button2' value='Esporta la tabella'></form></div>";

echo "<center><div class='col-sm-12'><h1>Vista per $titolo </h1></div>";    
echo "<div style=\"margin-bottom: 10%\"><table>
                <tr><th>Id appello</th>  <th>Id corso</th><th>Nome corso</th><th>Data</th><th>Ora inizio</th>
                <th>Ora fine</th><th>Data def.</th><th>Ora inizio def.</th><th>Ora fine def.</th>
                <th>Matr. docente</th><th>Aula</th><th>Tipo di aula</th><th>Tipo esame</th><th>Posti</th>
                <th>Corso di laurea</th><th>Anno</th><th>Semestre</th><th>Sessione</th><th>Note</th></tr>";
                foreach($query as $riga){
                    $appello=$riga["idAppello"];
                    $corso=$riga["idCorso"];
                    $nomecorso=$riga["nomeCorso"];
                    $data=$riga["data"];
                    $orainizio=$riga["oraInizio"];
                    $orafine=$riga["oraFine"];
                    $datadef=$riga["dataDef"];
                    $orainiziodef=$riga["oraInizioDef"];
                    $orafinedef=$riga["oraFineDef"];
                    $matricola=$riga["matDocente"];
                    $aula=$riga["aula"];
                    $tipoaula=$riga["tipoAula"];
                    $posti=$riga["posti"];
                    $corsodilaurea=$riga["corsodiLaurea"];
                    $anno=$riga["anno"];
                    $semestre=$riga["semestre"];
                    $sessione=$riga["sessione"];
                    $note=$riga["note"];
                    if($riga["scritto"]==1)
                    {$scritto="Scritto";       }
                    else{$scritto="Orale";   }
                    
                    echo "<tr>
                    <td>$appello</td>
                    <td>$corso</td>
                    <td>$nomecorso</td>
                    <td>$data</td>
                    <td>$orainizio</td>
                    <td>$orafine</td>
                    <td>$datadef</td>
                    <td>$orainiziodef</td>
                    <td>$orafinedef</td>
                    <td>$matricola</td>
                    <td>$aula</td>
                    <td>$tipoaula</td>
                    <td>$scritto</td>
                    <td>$posti</td>
                    <td>$corsodilaurea</td>
                    <td>$anno</td>
                    <td>$semestre</td>
                    <td>$sessione</td>
                    <td>$note</td>
                    </tr>";
                }echo "</table></div></center><br/> <br/> ";
            }else{
            echo "<center><h2>Nessun appello disponibile</h2>
            <br></center>"  ;
        }}}}


include('footer.php');
?>
</body>
</html>