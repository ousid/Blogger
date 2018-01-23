<?php 
    session_start();
    $title = 'login';
    require_once 'ini.php';

    if (!isset($_SESSION['loggedIn'])) {

?>
        <div class="container">
            <h1 class="text-center">Login</h1>
            <div class="card-block">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Put Your Username or Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Put Your Password">
                    </div>
                    <input type="submit" value="Login" name="login" class="btn btn-primary btn-block">
                </form>
                <a href="register.php">register</a> | 
                <a href="forgetPass.php">Forget Password!</a>
            </div>
        </div>

<?php 
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        if (isset($_POST, $_POST['login'])) {
            
            $username =  htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
            $password = $_POST['password'];
    
            $error = [];
    
            if (empty($username)) {
                $error[] .= "You Can't Less Username Empty";
            }if (empty($password)) {
                $error[] .= "You Can't Less The Password Empty";
    
            }if (!preg_match('/^[a-zA-Z0-9-_.@]*$/i', $username)) {
                $error[] .= "Your Username Must Have Just letter and number";
    
            }if (strlen($username) <= 2) {
                $error[] .= "Your Username Must be Greater Than 2 Chars ";
    
            }if (strlen($username) >= 32) {
                $error[] .= "You Username Must be Less Than 32 Cahrs";
            }
    
            if (!empty($error)) {
                foreach ($error as $err) {
                    alert($err, 'danger');
                }        
            }else {
                
                $stmt =$pdo->prepare("SELECT * FROM users WHERE (username = :username OR email = :email)");
                $stmt->execute([
                    'username' => $username,
                    'email'    => $username,
                ]);
                $fetch = $stmt->fetch();
        
                if ($stmt->rowCount()) {
                    if (password_verify($password, $fetch['password'])) {
                        if ($fetch['activate'] === '0') {
                            
                            $_SESSION['username'] = $fetch['username'];
                                 $message =  'Hi ' . ucwords($username) . ' Your  Account is Not Activated yet Please Go to Your Email And Activate it :)' . 
                                 '<a href="activate.php?do=' . $_SESSION['username'] . '" class="text-warning"> Go To Activate it</a>';
                                 alert($message,'info');

                        }else {
                            $_SESSION['loggedIn'] = true;
                            $_SESSION['id'] = $fetch['id'];
                            $_SESSION['username'] = $fetch['username'];
                            $_SESSION['email'] = $fetch['email'];
                            $message = 'You are logged In successfuly';
                            alert($message);
                            header('refresh:2;url=dashboard.php');
                        }
                    }else {
                         $message =  'Username/Email or Password not correct'; 
                         alert($message, 'danger');
                    }
                }else {
                    $message =  'Username/Email or Password not correct'; 
                    alert($message, 'danger');        
                }   
            }
        }
    
    }

    require_once 'includes/template/footer.php';

    }else {
        header('Location: dashboard.php');
    }