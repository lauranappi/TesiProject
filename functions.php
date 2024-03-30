<?php

function connessione()
{
    $conn=mysqli_connect('localhost','root','','Sql1595166_4');
}

function connetti_al_database()
{
    $server = '31.11.39.66';
    $user = 'Sql1595166';
    $password = '**Conferenza22';
    $database = 'Sql1595166_4';


    $conn = mysqli_connect($server, $user, $password, $database);

    if (!$conn) {

        die("Errore nella connessione: " . mysqli_connect_error());
    }

    return $conn;
}

function duratases(){



}

?>