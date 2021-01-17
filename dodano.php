<?php
    //definiowanie zmiennych pobranych z formularza
    $nazwa = $_POST['nazwa'];
    $model = $_POST['model'];
    $kat = $_POST['kategorie'];
    $ser = $_POST['seryjny'];
    $data_d = $_POST['data_d'];
  
    $status = $_POST['stan'];
    
    //nawiazywanie polaczenie i dodanie rekordu do bazy
    $bd = new mysqli("localhost","root","","firma");
    $zapytanie = $bd -> query("INSERT INTO urzadzenia(id, nazwa, model, seryjny, data_d, data_w, id_kat, id_stan, id_user) VALUES ('null', '$nazwa','$model', '$ser', '$data_d', 'null', '$kat', '$status', '0')");

    header('Location:admin.php');
?>

