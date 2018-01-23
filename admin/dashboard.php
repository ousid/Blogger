<?php 

session_start();
$nav = '';
$title = 'Dashboard';
require_once 'ini.php';

if (isset($_SESSION['username']) && $_SESSION['loggedIn'] == true) {
        ?>
        <div class="container">
            <p class="lead text-center">Welcome <strong><?=ucwords($_SESSION['username'])?></strong></p>
        </div>
        <?  
        $s = Select('users', $_SESSION['username']);
        if (NULL !==  $s['last_login']) {
            
            $dateTime = explode(' ', $s['last_login']);
            $date = explode('-', $dateTime[0]);
            $time = explode(':', $dateTime[1]);
            
            alert('Your Last Login: ' . $date[2] .  '-' .  $date[1] .  '-' . $date[0] . ' at ' . $time[0] . ':' . $time[1]);
        }
}else {
    header('Location: index.php');
}

 require_once'includes/template/footer.php';