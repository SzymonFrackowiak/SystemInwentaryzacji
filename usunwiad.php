<?php
    //nawiazanie polaczenia i usuniecie danego rekordu
    $id= $_POST['id'];
    $bd = new mysqli("localhost","root","","firma");
    echo $id;
    $zapytanie = $bd -> query("DELETE FROM wiadomosci WHERE id_w='$id'");

   header('Location:poczta.php');
?>
