<?php
    //nawiazanie polaczenia i usuniecie danego rekordu
    $id= $_POST['id'];
    $bd = new mysqli("localhost","root","","firma");
    echo $id;
    $zapytanie = $bd -> query("DELETE FROM urzadzenia WHERE id='$id'");

   header('Location:admin.php');
?>

