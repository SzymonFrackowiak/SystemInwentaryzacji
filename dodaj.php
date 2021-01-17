<?php
    session_start(); 
    
    if(!isset($_SESSION['zalogowany']) || @($_SESSION['grupy']!=admin)){
        header('Location: index.php');
        exit();
    }
?>
<!DOCTYPE html>

<html lang="pl-PL">
    
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-Ua-Compatible" content="IE=edge"> 
        <title>PC-Partner.pl</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="main.css"/>
    </head>
    
    <body>
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-light">
              <a  class="navbar-brand" id="logo"><img src="logo1.png"/><span class="logo_color" >PC-</span>Partner.pl</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="admin.php">Strona główna</a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="dodaj.php">Dodaj</a>
                  </li>        
                </ul>
                    <a href="poczta.php"><button class="pocztaaa" type="submit"><img src="envelope.png"/></button></a>&nbsp;&nbsp;
                   <?php 
                    echo "<span id='bar'>".$_SESSION['user']."</span>&nbsp;<a class='przycisk form-group my-2 my-lg-0' href='logout.php'>Wyloguj się!</a>";
                    ?>
              </div>
        </nav>
       <main>
           <section class="man1"> 
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-xl-12" id="info2">
                            Dodaj nowy rekord
                       </div>
                       <div class="col-xl-12" id="form">
                           <form method="post" action="dodano.php">
                               Nazwa <br /><input class="pole3" type="text"  name="nazwa" required/><br />
                               Model <br /><input class="pole3" type="text"  name="model" required/><br />
                               Numer seryjny <br /><input class="pole3" type="text"  name="seryjny" required/><br />
                                 <?php 
                                    //nawizanie polaczenia i wyswietlenie danych do dodania elementu
                                    $bd = new mysqli("localhost","root","","firma");
                                    $zapytanie = $bd -> query("SELECT id, nazwa FROM kategorie");
                                    echo " Kategoria<br />";
                                    echo "<select class='pole3' name='kategorie'>";
                                    if($ile_kategori = $zapytanie -> num_rows>0){
                                        while($rekord = $zapytanie -> fetch_object())
                                        echo "<option name='kategorie' value='".$rekord->id."'>".$rekord->nazwa."</option>";
                                    }
                                    echo "</select><br />";
                        
                               ?>
                               Data dodania <br /><input class="pole3" type="date"  name="data_d" required/><br />
                             
                               <?php 
                                 
                               $zapytanie6 = $bd -> query("SELECT * FROM status");
                               echo " Status <br /><select class='pole3' name='stan'>";
                               if($ile_stanow = $zapytanie6 -> num_rows>0){
                                        while($rekord6 = $zapytanie6 -> fetch_object())
                                        
                                        echo "<option name='stan' value='".$rekord6->id."'>".$rekord6->nazwa."</option>";
                                    }
                                    echo "</select><br /><br />";
                               
                               ?>
                              
                               
            
                               <input class="przycisk" type="submit" value="Dodaj"/>
                           
                           </form>
                            <br /><button action="action" type="submit" value="Back" onclick="history.go(-1);" class="przycisk">Wstecz</button>

                           
                       </div>
                    
                       
                       
                   </div>
               </div>
           </section> 
       </main>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="js/bootstrap.min.js"></script>
    </body>
</html>