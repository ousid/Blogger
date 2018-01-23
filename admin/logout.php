<?php 

session_start();

require_once 'ini.php';

$stmt = $pdo->prepare("UPDATE `users` SET last_login = :lastLogin WHERE username = :username");
$stmt->execute([
    'lastLogin' => date('Y-m-d H:i'),
    'username' => $_SESSION['username'],
]);

session_unset();

session_destroy();


header('Location: index.php');

