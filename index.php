<!DOCTYPE html>
<html lang="it">
<head>
  <title>ESAMI UNITO - Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
 <link rel="stylesheet" type="text/css" href="style.css?ts=<?=time()?>""/>
</head>
<body>
<div>
        <img src="immagini/logo_unito.svg" style="width: 15%; heigth: 4%; margin-bottom: 1%; margin-top: 1%; margin-left: 1%;">
        </div>
        <div style="background-color: #e9ecef; padding: 1%;">
        <h1 class="centered">Benvenuta/o nella procedura personale che la guiderà
          nella gestione del calendario degli esami.<br><br/></h1>
<p class="centered testo">Scegli tra:<br></p></div>
<div class="container-fluid" style="margin-bottom: 15%">
<div class="col-sm-5 areadoc">
  <h2>Area Docenti</h2>
  <p>
    Area destinata alla proposta delle aule per gli esami da parte dei docenti. Si accede tramite 
    login con nome e cognome, dopodiché vengono presentati i corsi tenuti, si sceglie la sessione 
    di riferimento e poi si possono compilare dei form per proporre le date degli appelli. Le 
    proposte degli appelli verrano poi passate all'area segreteria.
  </p>
  <form action="docente.php"><button type="submit" class="button2">
    Clicca qui</button></form>
  </div>
  <div class="col-sm-1"></div>
  <div class="col-sm-5 areaseg">
  <h2>Area Segreteria</h2>
  <p>Area destinata alla gestione delle aule per gli esami da parte della segreteria. All'interno si trovano la
     possibilità di visionare le proposte dei docenti attraverso varie viste e 
    la possibilità di assegnare le aule ad ogni appello, anche filtrando la tabella delle proposte. Viene poi
     data la possibilità di scegliere data di inizio e fine delle sessioni.
  </p>
  <form action="segreteria.php"><button type="submit" class="button1">
    Clicca qui</button></form>
  </div>
</div>
<?php
include('footer.php');
?>
</body>
</html>