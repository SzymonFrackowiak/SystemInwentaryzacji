<?php
    //start sesji
    session_start();
    //sprawdzanie poprawnosci przeslanego formularza
    if (isset($_POST['email']))
	{
		$wszystko_OK=true;
		
		$nick = $_POST['nick'];
		//sprawdzanie poprawnosci nazwy uzytkownika
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}
        
         
        if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
        
        $email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
        
        $haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		//sprawdzanie poprawnosci hasla
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	
        //hashowanie hasla
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
        //sprawdzenie czy regulamin zostal zaakceptowany
        if(!isset($_POST['regulamin'])){
            $wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
        }
        
        $_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
        
        mysqli_report(MYSQLI_REPORT_STRICT);
            
        try
        {
            $bd = new mysqli("localhost","root","","firma");
            if($bd->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());
            }
            else
            {   //pobieranie uzytkownika o danym e-mailu
                $rezultat = $bd->query("SELECT id FROM uzytkownicy WHERE email='$email' ");
                
                if(!$rezultat) throw new Exception($bd->error);
                //sprawdzenie czy istnieje konto o takim adresie e-mail
                $ile_takich_maili = $rezultat->num_rows;
                if($ile_takich_maili>0){
                     $wszystko_OK=false;
			         $_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
                }
                //pobieranie uzytkownikow o danej nazwie
                $rezultat = $bd->query("SELECT id FROM uzytkownicy WHERE user='$nick' ");
                
                if(!$rezultat) throw new Exception($bd->error);
                //sprawdzenie czy istnieje konto o takiej nazwie
                $ile_takich_nickow = $rezultat->num_rows;
                if($ile_takich_nickow>0){
                     $wszystko_OK=false;
			         $_SESSION['e_nick']="Istnieje użytkownik o takim loginie! Wybierz inny.";
                }
                
                 if ($wszystko_OK==true)
				{
					//dodanie uzytkownika do bazy danych
					
					if ($bd->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', 'user')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: index1.php');
					}
					else
					{
						throw new Exception($bd->error);
					}
					
				}
                
                $bd->close();
            }
        }
        catch(Exception $e)
        {
            echo '<span style="color: red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br />Informacja developerska'.$e;
        }
        
       
       
    }
    
   

?>
<!DOCTYPE html>

<html lang="pl-PL">
    
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-Ua-Compatible" content="IE=edge"> 
        <title>PC-Partner</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="main.css"/>
    </head>
    
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
              <a  class="navbar-brand" id="logo"><img src="logo1.png"/> <span class="logo_color">PC-</span>Partner.pl</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                     <a class="nav-link" href="nowe-konto.php" id="newkonto">Załóż konto</a>
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
       
           <section class="man1"> 
               <div class="container-fluid">
                   <div class="row">
                       <div class="col-xl-12" id="info">
                            Rejestracja, proszę wypełnić formularz
                       </div>
                       <div class="col-xl-12" id="form">
                           <form method="post">
                              Login: <br /> <input class="pole2" type="text" value="<?php
                                    if (isset($_SESSION['fr_nick']))
                                    {
                                        echo $_SESSION['fr_nick'];
                                        unset($_SESSION['fr_nick']);
                                    }
                                ?>" name="nick" /><br />
                               
                               <?php
                               if(isset($_SESSION['e_nick'])){
                                   echo "<div id='error'>".$_SESSION['e_nick']."</div>";
                                   unset($_SESSION['e_nick']);
                               }
                               ?>
                               
                               E-mail: <br /> <input class="pole2" type="email" value="<?php
                                    if (isset($_SESSION['fr_email']))
                                    {
                                        echo $_SESSION['fr_email'];
                                        unset($_SESSION['fr_email']);
                                    }
                                ?>" name="email" required/><br />
                               
                               <?php
                               if(isset($_SESSION['e_email'])){
                                   echo "<div id='error'>".$_SESSION['e_email']."</div>";
                                   unset($_SESSION['e_email']);
                               }
                               ?>
                               
                               Twoje hasło: <br /> <input class="pole2" type="password"  value="<?php
                                if (isset($_SESSION['fr_haslo1']))
                                {
                                    echo $_SESSION['fr_haslo1'];
                                    unset($_SESSION['fr_haslo1']);
                                }
                                ?>" name="haslo1" /><br />

                                <?php
                                if (isset($_SESSION['e_haslo']))
                                {
                                    echo '<div id="error">'.$_SESSION['e_haslo'].'</div>';
                                    unset($_SESSION['e_haslo']);
                                }
                                ?>		

                                Powtórz hasło: <br /> <input class="pole2" type="password" value="<?php
                                if (isset($_SESSION['fr_haslo2']))
                                {
                                    echo $_SESSION['fr_haslo2'];
                                    unset($_SESSION['fr_haslo2']);
                                }
                                ?>" name="haslo2" /><br /><br />
                               
                          
                                <label>
                                    <input type="checkbox" name="regulamin" <?php
                                    if (isset($_SESSION['fr_regulamin']))
                                    {
                                        echo "checked";
                                        unset($_SESSION['fr_regulamin']);
                                    }
                                    ?>/> Akceptuję regulamin
                                </label>
                                
                                 <?php
                                 if(isset($_SESSION['e_regulamin'])){
                                 echo "<div id='error'>".$_SESSION['e_regulamin']."</div>";
                                 unset($_SESSION['e_regulamin']);
                                 }
                                 ?>
                               
                                 <br />
                               
                               
                               <input class="przycisk" type="submit" value="Zarejestruj się"/>
                           
                           </form>
                              <br /><a href="index.php"><button action="action" type="submit" value="Back" onclick="history.go(-1);" class="przycisk">Wstecz</button></a>
                       </div>
                   </div>
               </div>
           </section> 
       
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="js/bootstrap.min.js"></script>
    </body>
</html>