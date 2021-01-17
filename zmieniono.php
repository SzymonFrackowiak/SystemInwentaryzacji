<?php
    //definiowanie zmiennych pobranych z formularza
    $id = $_POST['id'];
    $nazwa = $_POST['nazwa'];
    $model = $_POST['model'];
    $kat = $_POST['kategorie'];
    $ser = $_POST['seryjny'];
    $data_d = $_POST['data_d'];
    $data_w = $_POST['data_w'];
    $user = $_POST['user'];
    $status = $_POST['stan'];

    //nawiazanie polaczenie i update rekordu
    $bd = new mysqli("localhost","root","","firma");
    $zapytanie = $bd -> query("UPDATE urzadzenia SET nazwa = '$nazwa', model = '$model', seryjny = '$ser', data_d = '$data_d', data_w = '$data_w', id_kat = '$kat', id_stan = '$status', id_user = '$user'  WHERE id='$id'");

    header('Location:admin.php');
?>

