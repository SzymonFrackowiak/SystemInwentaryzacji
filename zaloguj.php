<?php
    //start sesji
    session_start();
    
    if((!isset($_POST['login']))||(!isset($_POST['haslo']))){
        header('Location: index.php');
        exit();
    }
    // nawiazanie polaczenia
    $bd = @new mysqli("localhost","root","","firma");
    
    if($bd->connect_errno!=0){
        echo "Error".$bd->connect_errno;
    }
    else
    {
        //sprawdzanie poprawnosci danych logowania
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];
        
        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        
        if($wynik = $bd -> query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
            mysqli_real_escape_string($bd, $login))))
        {
            $ile_userow = $wynik->num_rows;
            if($ile_userow>0)
            {
                $rekord = $wynik->fetch_assoc();
                
                if(password_verify($haslo,$rekord['pass']))
                {
                    $_SESSION['zalogowany']= true;


                    $_SESSION['id'] = $rekord['id'];
                    $_SESSION['user'] = $rekord['user'];
                    $_SESSION['grupy'] = $rekord['grupy'];

                    if($_SESSION['grupy']==admin)
                    {
                        unset($_SESSION['blad']);
                        $wynik->free_result();
                        header('Location:admin.php');
                    }
                    else
                    {
                        unset($_SESSION['blad']);
                        $wynik->free_result();
                        header('Location:user.php');
                    }
                }
                else
                {
                    $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');
                }
                
                
            }
            else{
                $_SESSION['blad'] = '<span style="color: red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
            }
        }
        
        $bd->close();
    }
    
?>