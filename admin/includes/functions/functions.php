<?php 


function redirectHome($message,$url = null,$second, $status = 'success') {
    if ($url === null) {
        $url = './index.php';
    }else {
        $url = isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']  : './index.php';
    }

    echo '<div class="alert alert-' . $status . '"><p class="lead text-center">'. $message . '</p></div>';
      
      echo '<div class="alert alert-info text-center">'. 'you will <strong>redirect</strong> after: '.'<strong>' . $second . '</strong>' . ' Seconds' . '</div>';

    header("refresh: {$second};url={$url}");
}

function getTitle() {
    global $title;
    if (isset($title)) {
        return  $title;
    }else {
        return 'Default';
    }
}

function Select($table, $user) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE username = :username");
    $stmt->execute(['username' => $user]);
    return $stmt->fetch();
}

function SelectFeild($table, $column, $status = true, $extra = '') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM {$table} =  ? $extra");
    $stmt->execute([$column]);

    if ($status === true) {
        return $stmt->fetch();
    }
    elseif ($status === false) {
        return $stmt->fetchAll();
    }
    elseif ($status == 'count') {
        return $stmt->rowCount();
    }
}

function SelectAll($table, $column = '', $return = 'fetch') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM {$table} {$column}");
    $stmt->execute([$column]);
    if ($return == 'fetch') {
        return $stmt->fetchAll();
    }elseif ($return == 'count') {
        return $stmt->rowCount();
    }
}

function SelectPost() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
}

function e($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function alert($message, $status = 'success') {
    echo '<div class="alert alert-'. $status .'">';
        echo '<p class="lead text-center">'. $message .'</p>';
    echo'</div>';
}