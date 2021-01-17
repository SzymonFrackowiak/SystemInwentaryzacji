<?php
    //definiowanie zmiennych z formularza
    $id = $_POST['id'];
    $user = $_POST['id_admin'];
    $temat = $_POST['temat'];
    $send = $_POST['send'];
    $urza = $_POST['urzadzenia'];
    $data=date("Y-m-d");
    $czas=date("H:i");

    //nawiazanie polaczenia i dodanie rekordu
    $bd = new mysqli("localhost","root","","firma");
    $zapytanie = $bd -> query("INSERT INTO wiadomosci(id_w, id_user, id_urzadzenia, temat, wiadomosc, godzina, data) VALUES ('null', '$user', '$urza',  '$temat', '$send', '$czas', '$data')");

    header('Location:user.php');
?>

