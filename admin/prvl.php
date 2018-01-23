<?php 
    session_start();
    $nav = '';
    $title = 'login';
    require_once 'ini.php';

    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
?>
        <div class="container">
            <h1 class="text-center">Add Administrator</h1>
            <div class="card-block">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="Email" name="email" class="form-control" id="email" placeholder="Add Email">
                    </div>
                    <div class="form-group">
                        <label for="option">Pick</label>
                        <select class="form-control" name="privil">
                            <option value="0">Normal User</option>
                            <option value="1">Administrator</option>
                            <option value="2">Modiritor</option>
                        </select>
                    </div>
                    <input type="submit" value="Add" name="addEmail" class="btn btn-primary btn-block">
                </form>
            </div>
        </div>
<?
    }else {
        header('Location: index.php');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST, $_POST['addEmail'])) {
            
            $email  =  filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $privil = (int)$_POST['privil'];
            $user   = SelectFeild('users WHERE email', $email);
            $username = ucwords($user['username']);
            $error  = [];
    
            if (empty($email)) {
                $error[] .= "You Can't Less Email Empty";
            }if (!preg_match('/^[a-zA-Z0-9-_.@]*$/i', $email)) {
                $error[] .= "Your Email Must Have Just letter and number";
            }

                if ($user['privil'] == $privil) {
                    switch ($privil) {
                        case '0': 
                            $error[] = '<strong>' . $username . '</strong>' . ' Was Already Normal user';
                            break;
                        case '1': 
                            $error[] = '<strong>' . $username . '</strong>' . ' Was Already Administrator';
                            break;
                        case '2': 
                            $error[] = '<strong>' . $username . '</strong>'  . ' Was Already Modiritor';
                            break;
                        
                    }
                } 

            if (!empty($error)) {
                foreach ($error as $err) {
                    alert($err, 'danger');
                }        
            }else {
                
                $stmt =$pdo->prepare("UPDATE `users` SET privil = :privil WHERE email = :email");
                $stmt->execute([
                    'privil'    => $privil,
                    'email'     => $email,
                ]);        
                if ($stmt->rowCount()) {
                     if ($privil == '2') {
                        $message = '<strong>' . $username . '</strong>' .  ' Was Add As Modirator Successfuly';
                    }elseif($privil == '1') {
                        $message = '<strong>' . $username . '</strong>' . ' Was Add As Administrator Successfuly';                       
                    }else {
                        $message = '<strong>' . $username . '</strong>'  . ' Was Add as a Normal user';
                    }
                    alert($message, 'success');
                    header('resresh: 3; url=dashboard.php');
                }else {
                    $message =  'There is Somthing Wrong While Add This User'; 
                    alert($message, 'danger');        
                }   
            }
        }
    
    }

    require_once 'includes/template/footer.php';
