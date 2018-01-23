
<?php 
 
 session_start();
 $title = 'Login';
 require_once 'ini.php';

    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
        
        header('Location: dashboard.php');
    }else {
        header('Location: login.php');   
    }

?>
