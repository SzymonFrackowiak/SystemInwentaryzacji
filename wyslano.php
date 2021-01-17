<?php
    //definiowanie miennych przeslanych z formularza
    $id = $_POST['id'];
    $user = $_POST['id_user'];
    $temat = $_POST['temat'];
    $send = $_POST['send'];
    $data=date("Y-m-d");
    $czas=date("H:i");
    $urza = $_POST['urzadzenia'];
    //nawiazanie polaczenia i dodanie rekrdu do bazy danych
    $bd = new mysqli("localhost","root","","firma");
    $zapytanie = $bd -> query("INSERT INTO wiadomosci(id_w, id_user, id_urzadzenia, temat, wiadomosc, godzina, data) VALUES ('null', '$user', '$urza',  '$temat', '$send', '$czas', '$data')");

    header('Location:user.php');
?>

