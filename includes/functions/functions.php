<?php

require_once './admin/includes/functions/functions.php';

function getPosts($order, $number) {
    global $pdo;    
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE approve = 1 order by  date_created {$order} LIMIT {$number}");
    $stmt->execute();
    return $stmt->fetchAll();
}

function SelectPosts($column, $cond = '', $cond1 = '', $bool = '') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT {$column} FROM posts {$cond} = ?");
    $stmt->execute([$cond1]);
    return $stmt->fetch();
    if (NULL === $boll) {
        return $stmt->fetchAll();
    }else {
        return $stmt->fetch();
    }
}