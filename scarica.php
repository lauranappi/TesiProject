<?php
session_start();
include('functions.php');

$conn=connetti_al_database();

$vista=$_POST["vista"];

$sql="SELECT idAppello, idCorso, nomeCorso, data, oraInizio, oraFine, dataDef, oraInizioDef, oraFineDef, matDocente, 
aula, tipoAula, scritto, orale, posti, corsodiLaurea, anno, semestre, sessione, note
 FROM appello JOIN corso 
ON idCorso=codCorso
ORDER BY $vista";

$miofile=fopen("esporta.csv","w");

fwrite($miofile,"idAppello;");
fwrite($miofile,"idCorso;");
fwrite($miofile,"nomeCorso;");
fwrite($miofile,"data;");
fwrite($miofile,"oraInizio;");
fwrite($miofile,"oraFine;");
fwrite($miofile,"dataDef;");
fwrite($miofile,"oraInizioDef;");
fwrite($miofile,"oraFineDef;");
fwrite($miofile,"matDocente;");
fwrite($miofile,"aula;");
fwrite($miofile,"tipoAula;");
fwrite($miofile,"scritto;");
fwrite($miofile,"orale;");
fwrite($miofile,"posti;");
fwrite($miofile,"corsodiLaurea;");
fwrite($miofile,"anno;");
fwrite($miofile,"semestre;");
fwrite($miofile,"sessione;");
fwrite($miofile,"note\n");

$risp=mysqli_query($conn,$sql);

foreach ($risp as $riga)
{
  $idAppello=$riga["idAppello"];
  $idCorso=$riga["idCorso"];
  $nomeCorso=$riga["nomeCorso"];
  $data=$riga["data"];
  $oraInizio=$riga["oraInizio"];
  $oraFine=$riga["oraFine"];
  $dataDef=$riga["dataDef"];
  $oraInizioDef=$riga["oraInizioDef"];
  $oraFineDef=$riga["oraFineDef"];
  $matDocente=$riga["matDocente"];
  $aula=$riga["aula"];
  $tipoAula=$riga["tipoAula"];
  $scritto=$riga["scritto"];
  $orale=$riga["orale"];
  $posti=$riga["posti"];
  $corsodiLaurea=$riga["corsodiLaurea"];
  $anno=$riga["anno"];
  $semestre=$riga["semestre"];
  $sessione=$riga["sessione"];
  $note=$riga["note"];

  fwrite($miofile,"$idAppello;");
  fwrite($miofile,"$idCorso;");
  fwrite($miofile,"$nomeCorso;");
  fwrite($miofile,"$data;");
  fwrite($miofile,"$oraInizio;");
  fwrite($miofile,"$oraFine;");
  fwrite($miofile,"$dataDef;");
  fwrite($miofile,"$oraInizioDef;");
  fwrite($miofile,"$oraFineDef;");
  fwrite($miofile,"$matDocente;");
  fwrite($miofile,"$aula;");
  fwrite($miofile,"$tipoAula;");
  fwrite($miofile,"$scritto;");
  fwrite($miofile,"$orale;");
  fwrite($miofile,"$posti;");
  fwrite($miofile,"$corsodiLaurea;");
  fwrite($miofile,"$anno;");
  fwrite($miofile,"$semestre;");
  fwrite($miofile,"$sessione;");
  fwrite($miofile,"$note\n");

};

fclose($miofile);

$_SESSION['messa']="Esportazione in file csv avvenuta con successo; puoi aprire il file esporta.csv con Excel.";
header('Location: segreteria.php');
?>