<?php 

$title = 'Recover Password';
require_once 'ini.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
    
        $pdo->beginTransaction();
        if (isset($_GET['email'], $_GET['token'])) {
            
            $email = $_GET['email'];
            $token = $_GET['token'];
            $errors = [];
            if (empty($email)) {
                $errors[] .= 'The Email Cant be empty';
            }if (empty($token)) {
                $errors[] .= 'the token cant be empty';
            }if (!preg_match('/^[a-f0-9]*$/i', $token)) {
                $errors[] .= 'invalid token given';
            }
    
            if (!empty($errors)) {
                foreach ($errors as $err) {
        
                        echo '<div class="alert alert-danger"><p class="text-center lead">' . $err . '</p></div>';
                    }
                    echo '<a href="forgetPass.php" class="btn btn-info btn-block btn-err">Go Back</a>';
        
            }else {
                    $stmt = $pdo->prepare("SELECT email, token FROM `users` where email = :email AND token = :token");
                    $stmt->execute(['email' => $email, 'token' => $token]);
        
                    if ($stmt->rowCount()) {
    ?>
                        <h1 class="text-center">Recover Password</h1>
                        <div class="card-block">
                            <form action="" method="POST">
    
                                <div class="form-group">
                                    <label for="new">New Password</label>
                                    <input type="password" name="newpassword" class="form-control" id="new" placeholder="Recreate Your New Password">
                                </div>
    
                                <div class="form-group">
                                    <label for="newAgain">Repete Password</label>
                                    <input type="password" name="newpasswordagain" class="form-control" id="newAgain" placeholder="Please rebete Your New Password">
                                </div>
                                <input type="submit" value="Recover" name="recoverPass" class="btn btn-primary btn-block">
                            </form>
                        </div>
    <?
                        if (isset($_POST['newpassword'], $_POST['newpasswordagain'], $_POST['recoverPass'])) {
    
                                $newPass = $_POST['newpassword'];
                                $passAgain = $_POST['newpasswordagain'];
                                $errorsPost = [];
    
                                if (empty($newPass) OR empty($passAgain)) {
                                    $errorsPost[] .= 'Your Password or Repete Password cant be empty';
                                }
                                if (strlen($newPass) <= 8) {
                                    $errorsPost[] .= 'Your Password Should be Greater than 8 char for your securiry';
                                }
                                if ($newPass !== $passAgain) {
                                    $errorsPost[] .= 'Your password dosnt match with repeted password';
                                }
                                
    
                                if (!empty($errorsPost)) {
                                    foreach ($errorsPost as $err) {
                        
                                        echo '<div class="alert alert-danger"><p class="text-center lead">' . $err . '</p></div>';
                                    }
                                }else {
                                    $passHash = password_hash($newPass, PASSWORD_DEFAULT, ['cost' => 10]);
                                    $stmt = $pdo->prepare("UPDATE `users` SET `password` = :pass WHERE email = :email AND token = :token");
                                    $stmt->execute([
                                        'pass' => $passHash,
                                        'email' => $email,
                                        'token' => $token,
                                    ]);
    
                                    if ($stmt->rowCount()) {
                                        $stmtUpdate = $pdo->prepare("UPDATE `users` SET token = :token WHERE email = :email");
                                        $stmtUpdate->execute([
                                            'token' => NULL,
                                            'email' => $email,
                                        ]);
    
                                        if ($stmtUpdate->rowCount()) {
                                            $message = 'Your Password has been Updated succeffuly';
                                            redirectHome($message,null, 3);
    
                                        }else {
                                            echo 'there was an error while update Your Password';
                                        }
                                    }else {
                                        echo 'There was an error while updated Your Password';
                                    }
                                }                        
                        }
                    }else {
                        $message =  'The token or Email not found';
                        redirectHome($message, null, 3, 'danger');  
                    }
            }
        }else {
            header('Location: ./index.php');
        }
        $pdo->commit();
    }catch (PDOException $e) {
        $pdo->rollBack();
        die($e->getMessage());
    }
}