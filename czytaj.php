<?php
    session_start(); 
    
    if(@!isset($_SESSION['zalogowany']) || @($_SESSION['grupy']!=admin)){
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
        
        <script src="jquery.min.js"></script>
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-light">
              <a  class="navbar-brand" id="logo"><img src="logo1.png"/><span class="logo_color">PC-</span>Partner.pl</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="admin.php">Strona główna</a>
                  </li>
                  <li class="nav-item">
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
                            Wiadomość
                       </div>
                       <div class="col-xl-12" id="form">
                           <form method="post" action="wyslano_ad.php">
                               
                               <?php 
                                
                                
                                $id = $_POST['id'];
                                $id_user = $_POST['id_user'];
                                //nawiazanie polaczenia
                                $bd = new mysqli("localhost","root","","firma");
                                $zapytanie = $bd -> query("SELECT * FROM urzadzenia u JOIN wiadomosci w ON u.id=w.id_urzadzenia LEFT OUTER JOIN uzytkownicy o ON $id_user = o.id WHERE w.id_w=$id");
                               //SELECT * FROM wiadomosci w JOIN urzadzenia u ON u.id=w.id_urzadzenia LEFT OUTER JOIN uzytkownicy o ON o.id = w.id_user WHERE id_w = 11
                                echo "<input type='hidden' name='id' value='".$id."'/>";
                                echo "<input type='hidden' name='id_user' value='".$id_user."'/>";
                                $zapytanie2 = $bd -> query("SELECT * FROM uzytkownicy WHERE user='".$_SESSION['user']."'");
                               
                                if($ile_rekordow2 = $zapytanie2 -> num_rows>0){
                                    $rekord2 = $zapytanie2 -> fetch_object();
                                    echo "<input type='hidden' name='id_admin' value='".$rekord2->id."'/>";
                                }
                               
                                if($ile_rekordow = $zapytanie -> num_rows>0){
                                    $rekord = $zapytanie -> fetch_object();
                                        echo "Użytkownik <br /><input class='pole4' type='text'  name='nazwa' value='".$rekord->user."' disabled/><br />";
                                        echo "Nazwa <br /><input class='pole4' type='text'  name='nazwa' value='".$rekord->nazwa." ".$rekord->model."' disabled/><br />";
                                        echo "Numer seryjny <br /><input class='pole4' type='text'  name='nazwa' value='".$rekord->seryjny."' disabled/><br />";
                                        echo "Temat <br /><input class='pole4' type='text'  name='temat' value='".$rekord->temat."' required/><br />";
                                        echo "Wiadomość<br /><textarea class='pole4' rows='5' name='nazwa' wrap='off'>".$rekord->wiadomosc."</textarea><br />";
                                        echo "Napisz wiadomość<br /><textarea class='pole4' rows='5' name='send' wrap='off'></textarea><br />";
                                        echo "<input type='hidden' name='urzadzenia' value='".$rekord->id_urzadzenia."'/>";
                                        
                                }
                               
                               
                              ?>
                               
                               
                               
            
                               <input class="przycisk" type="submit" value="Odpowiedz"/>
                           
                           </form>
                            <br /><button action="action" type="submit" value="Back" onclick="history.go(-1);" class="przycisk">Wstecz</button>
                           
                       </div> 
                       
                   </div>
               </div>
           </section> 
       </main>
    </body>
</html>