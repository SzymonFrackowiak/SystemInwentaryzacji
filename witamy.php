<?php
    session_start();
    if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany']==true))
    {
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
        <nav class="navbar sticky-top navbar-light bg-light navbar-expand-md form-inline">
            <a  class="navbar-brand" href="index.php"><img src="logo1.png"/> <span class="logo_color">PC-</span>Partner.pl</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="mainmenu" mr-auto >
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="nowe-konto.php" id="newkonto">Załóż konto <span class="sr-only"></span></a>
                        </li>
                    </ul>
                <form action="zaloguj.php" method="post" class="form-group my-2 my-lg-0">            
                    <input class="pole" type="text" name="login" placeholder="Login"/>&nbsp;
                    <input class="pole" type="password" name="haslo" placeholder="Hasło"/>&nbsp;
                    <input class="przycisk" type="submit" value="Zaloguj się"/>&nbsp;
                    <?php
                        if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
                        unset($_SESSION['blad']);
                    ?>              
                </form>           
            </div>
        </nav>   
       <main>
           <section class="man1"> 
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-xl-12" id="info">
                            Sprawdz swój sprzęt już dziś!
                        </div>
                        <div class="col-xl-12" id="zdj">
                            <img class="img-fluid" src="baner.png"/>
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