<?php
    //start i zakonczenie sesji
    session_start();
    session_unset();
    header('Location: index.php');
?>
