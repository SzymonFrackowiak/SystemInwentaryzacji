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
        <title>Komputery.pl</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="main.css"/>
    </head>
    
    <body>
        
        <script src="jquery.min.js"></script>
        <nav class="navbar sticky-top navbar-expand-md navbar-light bg-light">
              <a  class="navbar-brand" id="logo"><img src="logo1.png"/><span class="logo_color" >PC-</span>Partner.pl</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="user.php">Strona główna</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="dodaj.php">Dodaj</a>
                  </li> 
                </ul>
                <form class="form-inline my-2 my-lg-0">
                  <input class="search form-control mr-sm-3" type="search" placeholder="Wyszukaj" aria-label="Search">
                </form>&nbsp;&nbsp;
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
                       <?php $i=1; ?>
                       <table class="table table-bordered table-hover table-striped results">
                           <thead class="thead-dark ">
                               <tr>
                                    <th scope="col"id="column">Lp.</th>
                                    <th scope="col"id="column">Temat</th>
                                    <th scope="col"id="column">Użytkownik</th>
                                    <th scope="col"id="column">Godzina</th>
                                    <th scope="col"id="column">Data</th>
                                    <th scope="col"id="column">Usuń</th>
                               </tr>
                            </thead>
                           <tbody>
                            <?php 
                                //nazwiazywanie polaczenie i pobranie wiadomosci
                                $bd = new mysqli("localhost","root","","firma");
                                $zapytanie = $bd -> query("SELECT * FROM wiadomosci w JOIN uzytkownicy u ON id_user=u.id WHERE grupy!='admin'");

                                //wyswietlenie wiadomosci
                                if($ile_rekordow = $zapytanie -> num_rows>0){
                                    while($rekord = $zapytanie->fetch_object())
                                    {
                                        echo "<tr class='table-light'>";
                                        echo "<th>".$i."</th>";
                                        echo "<td><form method='post' action='czytaj.php'><input type='hidden' name='id' value='".$rekord->id_w."'><input type='hidden' name='id_user' value='".$rekord->id_user."'><input class='wiadomosc' type='submit' value='".$rekord->temat."'/></form></td>";
                                        echo "<td>".$rekord->user."</td>";
                                        echo "<td>".$rekord->godzina."</td>";
                                        echo "<td>".$rekord->data."</td>";
                                        echo "<td><form method='post' action='usunwiad.php'><input type='hidden' name='id' value='".$rekord->id_w."'><input class='przycisk' type='submit' value='Usuń'/></form></td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                }
                               
                               
                            ?>
                           </tbody>
                        </table>
                       
                       
                   </div>
               </div>
           </section> 
       </main>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="js/bootstrap.min.js"></script>
            <script>
            $(document).ready(function(){
                $('.search').keyup(function(){
                    var searchTerm = $(".search").val();
                    var listItem = $('.results tbody').children('tr');
                    var searchSplit = searchTerm.replace(/ /g, "'):containsi('");
                    $.extend($.expr[':'],{
                        'containsi': function(elem,i,match,array){
                            return (elem.textContent || elem.innerText || '').toLowerCase().lastIndexOf((match[3] || "").toLowerCase()) >= 0;
                        }
                    })
                    $(".results tbody tr").not(":containsi('"+ searchSplit +"')").each(function(){
                        $(this).attr('visible','false');
                    })
                    $(".results tbody tr:containsi('"+ searchSplit +"')").each(function(){
                        $(this).attr('visible','true');
                    })
                    var jobCount = $('.results tbody tr[visible="true"]').length;
                    $(".counter").text(jobCount +' item');
                    if(jobCount == 0){
                        $('no-result').show();
                    }else{
                        $('no-result').hide();
                    }
                })
            })
            </script>
    </body>
</html>