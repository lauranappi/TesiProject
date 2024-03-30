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
form label {
        display: inline-block;
        text-align:left;
        width:100px;
        padding: 0;
    }
    select, input[type=date], input[type=time] {
    width: 80%;
}
    </style>
</head>
<body>
<div>
        <img src="immagini/logo_unito.svg" style="width: 15%; heigth: 4%; margin-top: 1%; margin-left: 1%;">
        </div>
    

    <div class="centered" style="font-size: 12px;
    padding: 1%;"><a href="index.php">TORNA ALLA HOME</a>&nbsp;&nbsp; | 
    &nbsp;&nbsp;<a href="segreteria.php">TORNA ALLA SEZIONE SEGRETERIA</a>
    | &nbsp;&nbsp;<a href="sceltaassaule.php">VAI ALLA SCLETA DEI FILTRI PER L'ASSEGNAZIONE</a></div>

</div>

    <?php
$conn=connetti_al_database();

if(isset($_POST["nappelli"])){
    if($_POST["nappelli"]=="-"){
        $_SESSION['mexx']="Seleziona un filtro prima di premere invio.";
     header('Location: sceltaassaule.php');    
    }else{
    $filtro="numero appello";
    $quale=$_POST["nappelli"];
    $cond="nappello='$quale'";
    }
}

if(isset($_POST["corsi"])){
    if($_POST["corsi"]=="-"){
        $_SESSION['mexx']="Seleziona un filtro prima di premere invio.";
     header('Location: sceltaassaule.php');    
    }else{
    $filtro="corso di laurea";   
    $quale=$_POST["corsi"];
    $cond="corsodiLaurea='$quale'";
    }
}

if(isset($_POST["tipo"]) && isset($_POST["posti"])){
    if($_POST["tipo"]=="-" || $_POST["posti"]=="-"){
        $_SESSION['mexx']="Seleziona un filtro prima di premere invio.";
     header('Location: sceltaassaule.php');    
    }else{
    $filtro="tipo di aula e dimensioni";
    $tipo=$_POST["tipo"];
    $posti=$_POST["posti"];
    $quale="$tipo e $posti";
$cond="tipoaula='$tipo' and $posti";
    }
}

if(isset($_POST["data"])){
    if($_POST["data"]=="-"){
        $_SESSION['mexx']="Seleziona un filtro prima di premere invio.";
     header('Location: sceltaassaule.php');    
    }else{
    $filtro="data proposta";
    $quale=$_POST["data"];
    $cond="data='$quale'";
}
}

if(isset($_POST["docente"])){
    if($_POST["docente"]=="-"){
        $_SESSION['mexx']="Seleziona un filtro prima di premere invio.";
     header('Location: sceltaassaule.php');    
    }else{
    $filtro="matricola docente";
    $quale=$_POST["docente"];
    $cond="matDocente='$quale'";
}
}

if(isset($_POST["nappelli"]) || isset($_POST["corsi"]) || isset($_POST["tipo"]) || isset($_POST["posti"]) 
|| isset($_POST["data"]) || isset($_POST["docente"])){

    $dip="SELECT idAppello, idCorso, nomeCorso, data, oraInizio, oraFine, dataDef, oraInizioDef, oraFineDef, matDocente, 
    aula, tipoAula, scritto, orale, posti, corsodiLaurea, anno, semestre, dipartimento, sessione, note
     FROM appello JOIN corso 
    ON idCorso=codCorso
    WHERE $cond";

}else{
    $dip="SELECT idAppello, idCorso, nomeCorso, data, oraInizio, oraFine, dataDef, oraInizioDef, oraFineDef, matDocente, 
    aula, tipoAula, scritto, orale, posti, corsodiLaurea, anno, semestre, dipartimento, sessione, note
     FROM appello JOIN corso 
    ON idCorso=codCorso";
    $filtro="";
    $quale="";
}

$query=mysqli_query($conn,$dip);
$n=mysqli_num_rows($query);
$errore=mysqli_error($conn);

$aule="SELECT nomeAula FROM aule";

$query1=mysqli_query($conn,$aule);
$n1=mysqli_num_rows($query1);

if($errore)
{
    echo $errore;
}else{
            if($n!=0){

echo "<center><h2>Assegnazione aule</h2>
<p class=\"testo\">Compila i form per assegnare le aule. Non è necessario compilare tutti i campi: il
sisitema modificherà solo le parti compilate.
Vedrai comparire le tue eventuali modifiche direttamente nella tabella qui sotto.</p><br/>";
if(isset($_SESSION['mess'])){
    $mess = $_SESSION['mess'];
    echo "<hr><p style='color: blue;' class='testo'>$mess</p>";
    unset($_SESSION['mess']);
}
echo "<hr>";
if($filtro!="" && $quale!=""){
echo "<h4>
Filtro per $filtro: $quale.</h4>
<hr>";
}
echo "<table>
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
                $dipartimento=$riga["dipartimento"];
                $sessione=$riga["sessione"];
                $note=$riga["note"];
                if($riga["scritto"]==1)
                {$scritto="Scritto";       }
                else{$scritto="Orale";   }

                if(!$datadef && !$orainiziodef && !$orafinedef && !$aula){
                    $pulsante="Aggiungi";
                }else{
                    $pulsante="Modifica";
                }

                if(!$datadef || !$orainiziodef || !$orafinedef || !$aula){
                    $alert=" style=\"border: 4px solid red;\"";
                }else{
                    $alert="";
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
        }
                 
                echo "<tr$alert>
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
                <td><form action='modificaaule.php' method='post'>
                    <input type='hidden' name='appello' value='$appello'></br>
                   <label for='data'>Data:</label> <input type='date' name='dataDef' class='aule' id='data'><br/>
                   <label for='orai'>Ora Inizio:</label> <input type='time' name='oraInizioDef' class='aule' id='orai'><br/>
                   <label for='oraf'>Ora Fine:</label> <input type='time' name='oraFineDef' class='aule' id='oraf'><br/>
                   <label for='aulaa'>Aula:</label> <select name='aula' class='aule' id='aulaa'>";
foreach($query1 as $riga){
    $nomeaula=$riga["nomeAula"];
    echo "<option value='$nomeaula'>$nomeaula</option>";
}
                    echo "</select></br></br>
                    <input type='submit' value='$pulsante'>";
                    
                   echo "</form>";
                echo "</td>
                </tr>";
            }echo "</table></center><br/> <br/> ";
        }else{
        echo "<center><h2>Nessun dato disponibile</h2>
        <br></center>"  ;
        }}
?>
<br/><br/>
<?php
    include('footer.php');
    ?>
</body>
</html>