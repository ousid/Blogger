<?php 

try {

    $pdo = new PDO('mysql:dbname=blogs;host=localhost;charset=utf8', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    $pdo->exec('SET SQL_MODE = NO_BACKSLASH_ESCAPES');
    // $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
}catch (PDOException $e) {
    die($e->getMessage());
}