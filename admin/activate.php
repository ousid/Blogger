<?php 

session_start();

$title = 'activate';
require_once 'ini.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET, $_GET['do']) && $_GET['do'] === $_SESSION['username']) {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username'=> $_SESSION['username']]);

        if ($stmt->rowCount()) {
            $stmt = $pdo->prepare("UPDATE users SET activate = :active WHERE username = :username");
            $stmt->execute([
                'active' => 1,
                'username' => $_SESSION['username'],
                ]);
            if ($stmt->rowCount()) {
                
                $message = "Your Account Was Activated Successfuly";
                redirectHome($message,'dashboard.php', 3);
            }else {
                $message = 'there is error while activate Your account';
                redirectHome($message,'login.php', 3, 'danger');
            }
        }else {
                $message = 'This User Does not Exists';
                redirectHome($message,'login.php', 3, 'danger');        }
    }else {
        header('Location: login.php');
    }
}