<?php 

session_start();

$nav = '';
$title = 'Update';
require_once 'ini.php';
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST)) {

            $valid = ['updateUsername', 'updateEmail', 'updateNname', 'addNewName', 'updatePass'];
            $update = isset($_GET['update']) && in_array($_GET['update'], $valid) ? $_GET['update'] : '';
        
            if ($update == 'updateUsername') {

                if (isset($_POST['updateUser'])) {

                    $id = (int)$_POST['id'];
                    $username = $_POST['username'];
                    $errors = [];

                    if (empty($username)) {
                        $errors[] .= 'You Cant leave Your Name Empty';
                    }
                    if (strlen($username) <= 3 || strlen($username) >= 32) {
                        $errors[] .= 'Your Username Cant be less than 3 chars or grater than 32 chars';
                    }
                    if (!preg_match('/^[a-zA-z0-9-_.]*$/i', $username)) {
                        $errors[] .= 'Your Username Must have just letter or numbers';
                    }

                    foreach (SelectAll('users') as $value) {
                        if ($value['username'] === $username && $_SESSION['username'] !== $username) {
                            $errors[] .= 'This Username Is Already Taken';

                        }
                    }

                    if(!empty($errors)) {
                        foreach ($errors as $error) {

                            echo '<div class="alert alert-danger"><p class="text-center lead">' . $error . '</p></div>';
                        }
                        echo '<a href="'. $_SERVER['HTTP_REFERER'] . '" class="btn btn-info btn-block btn-err">Go Back</a>';
                    }else {
                        if ($username === $_SESSION['username']) {
                            $message = 'Your Username be The Same';
                            redirectHome($message, null, 4, 'info');
                        }else {
    
                            $sanUser = e($username);
                            $stmt  = $pdo->prepare("UPDATE `users` SET username = :username WHERE id = :id");
                            $stmt->execute([
                                'username' => $sanUser,
                                'id' => $id
                            ]);
                            if ($stmt->rowCount()) {
                                $_SESSION['username'] = $sanUser;
                                $message = 'Your Username Was Updated Successfuly';
                                redirectHome($message,null,4);
                            }else {
                                $message = 'There Was an Error While Update';
                                redirectHome($message, null,4, 'danger');
                            }
                        }
                    }
                }
            }elseif ($update == 'updateEmail') {
                if (isset($_POST['updateEmail'])) {

                    $id = (int)$_POST['id'];
                    $email = $_POST['email'];
                    $errors = [];

                    if (empty($email)) {
                        $errors[] .= 'You Cant leave Your Email Empty';
                    }
                    if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
                        $errors[] .= 'Your must put a valid Email';
                    }

                    foreach (SelectAll('users') as $value) {
                        if ($value['email'] === $email && $email !== $_SESSION['email']) {
                            $errors[] .= 'This Email Is Already Taken';

                        }
                    }

                    if(!empty($errors)) {
                        foreach ($errors as $error) {

                            echo '<div class="alert alert-danger"><p class="text-center lead">' . $error . '</p></div>';
                        }
                        echo '<a href="'. $_SERVER['HTTP_REFERER'] . '" class="btn btn-info btn-block btn-err">Go Back</a>';
                    }else {
                        if ($email === $_SESSION['email']) {
                            $message = 'Your Email be The Same';
                            redirectHome($message, null, 4, 'info');
                        }else {
    
                            $sanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                            $stmt  = $pdo->prepare("UPDATE `users` SET email = :email WHERE id = :id");
                            $stmt->execute([
                                'username' => $sanEmail,
                                'id' => $id
                            ]);
                            if ($stmt->rowCount()) {
                                $_SESSION['email'] = $sanEmail;
                                $message = 'Your Email Was Updated Successfuly go To Activated .. ';
                                redirectHome($message,null,4);
                            }else {
                                $message = 'There Was an Error While Update Your Email';
                                redirectHome($message, null,4, 'danger');
                            }
                        }
                    }
                }
            }elseif ($update == 'updateNname') {
                if (isset($_POST['updateNname'])) {

                    $id = (int)$_POST['id'];
                    $Nname = $_POST['nickname'];
                    $errors = [];

                    if (strlen($Nname) >= 12) {
                        $errors[] .= 'Your Nickname Cant be grater than 12 chars';
                    }
                    if (!preg_match('/^[a-zA-z0-9-_.]*$/i', $Nname)) {
                        $errors[] .= 'Your Nickname Must have just letter or numbers';
                    }

                    if(!empty($errors)) {
                        foreach ($errors as $error) {

                            echo '<div class="alert alert-danger"><p class="text-center lead">' . $error . '</p></div>';
                        }
                        echo '<a href="'. $_SERVER['HTTP_REFERER'] . '" class="btn btn-info btn-block btn-err">Go Back</a>';
                    }else {
                        if ($Nname === Select('users', $_SESSION['username'])['nickName']) {
                            $message = 'Your Nickname be The Same';
                            redirectHome($message, null, 4, 'info');
                        }else {
    
                            $sanName = e($Nname);
                            $stmt  = $pdo->prepare("UPDATE `users` SET nickName = :nickname WHERE id = :id");
                            $stmt->execute([
                                'nickname' => $sanName,
                                'id' => $id
                            ]);
                            if ($stmt->rowCount()) {
                                $message = 'Your Nickname Was Updated Successfuly';
                                redirectHome($message,null,4);
                            }else {
                                $message = 'There Was an Error While Update Your Nickname';
                                redirectHome($message, null,4, 'danger');
                            }
                        }
                    }
                }
            }elseif ($update == 'addNewName') {

                if (isset($_POST['addNickname'])) {

                    $Nname = $_POST['addNname'];
                    $errors = [];

                    if (empty($Nname)) {
                        $errors[] .= 'Your Nick name Cant be empty';
                    }
                    if (strlen($Nname) >= 12) {
                        $errors[] .= 'Your Nickname Cant be grater than 12 chars';
                    }
                    if (!preg_match('/^[a-zA-z0-9-_.]*$/i', $Nname)) {
                        $errors[] .= 'Your Nickname Must have just letter or numbers';
                    }

                    if(!empty($errors)) {
                        foreach ($errors as $error) {

                            echo '<div class="alert alert-danger"><p class="text-center lead">' . $error . '</p></div>';
                        }
                        echo '<a href="'. $_SERVER['HTTP_REFERER'] . '" class="btn btn-info btn-block btn-err">Go Back</a>';
                    }else {
    
                            $sanNick = e($Nname);
                            $stmt  = $pdo->prepare("UPDATE `users` SET nickName = ? WHERE username = ?");
                            $stmt->bindValue(1, $sanNick);
                            $stmt->bindValue(2, $_SESSION['username']);
                            $stmt->execute();
                            if ($stmt->rowCount()) {
                                $message = 'Your Nickname Was Inserted Successfuly';
                                redirectHome($message,null,4);
                            }else {
                                $message = 'There Was an Error While Set Your Nickname';
                                redirectHome($message, null,4, 'danger');
                            }
                    }
                }
            }elseif ($update == 'updatePass') {

                if (isset($_POST['updatePass'])) {
                    $oldPass = $_POST['oldpassword'];
                    $newPass = $_POST['newpassword'];
                    $newPassAgain = $_POST['newpasswordagain'];
                    $errors = [];

                    if (empty($oldPass)) {
                        $errors[] .= 'Your Cant leave Your Current Password Empty';
                    }
                    if (empty($newPass)) {
                        $errors[] .= 'Your Cant leave Your New Password Empty';
                    }
                    if (empty($newPassAgain)) {
                        $errors[] .= 'Your Must repete You  Password';
                    }

                    if (strlen($newPass) <= 8) {
                        $errors[] = 'Your Password Must be greater Than 8 chars for your security';
                    }

                    if ($newPass !== $newPassAgain) {
                        $errors[] = 'Your New Password And repeted Password dosnt Match';
                    }

                    if(!empty($errors)) {
                        foreach ($errors as $error) {

                            echo '<div class="alert alert-danger"><p class="text-center lead">' . $error . '</p></div>';
                        }
                        echo '<a href="'. $_SERVER['HTTP_REFERER'] . '" class="btn btn-info btn-block btn-err">Go Back</a>';
                    }else {
                        if (password_verify($oldPass, Select('users', $_SESSION['username'])['password'])) {
                            $newPassHash = password_hash($newPass, PASSWORD_DEFAULT,['cost' => 10]);

                            $stmt = $pdo->prepare("UPDATE `users` SET `password` = ? WHERE `username` = ? ");
                            $stmt->bindParam(1, $newPassHash, PDO::PARAM_STR);
                            $stmt->bindParam(2, $_SESSION['username'], PDO::PARAM_STR);
                            $stmt->execute();

                            if ($stmt->rowCount()) {
                                $message = 'Your Password Was Updated Successfuly';
                                redirectHome($message, null, 3);
                            }else {
                                $message = 'There was an error while update Your Password';
                                redirectHome($message, $_SERVER['HTTP_REFERER'], 3, 'danger');
                            }
                        }else {
                            $message = 'Your Password is incorrect';
                            redirectHome($message,'edit.php?do=updatePass', 3, 'danger');
                        }
                    }

                    }
                }

            }else {
                header('Location: edit.php');
            }

    }else {
        header('Location: dashboard.php');
    }

}else {
    header('Location: index.php');
}

require_once 'includes/template/footer.php';