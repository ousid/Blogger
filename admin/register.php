<?php 

$title = 'register';
require_once 'ini.php';
?>
    <div class="container">
        <h1 class="text-center">Register</h1>
        <div class="card-block">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Put Your Username">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Put Your Email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Put Your Password">
                </div>
                <div class="form-group">
                    <label for="password_again">Password Confirm</label>
                    <input type="password" name="password_again" class="form-control" id="password_again" placeholder="Recrite Your Password">
                </div>
                <input type="submit" value="register" name="register" class="btn btn-primary btn-block">      
            </form>
            <a href="login.php">Login</a>
        </div>
    </div>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST, $_POST['register'])) {
        $username =  $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_again = $_POST['password_again'];
        $error = [];

        if (empty($username)) {
            $error[] .= "You Can't Less Username Empty";
        }if (empty($email)) {
            $error[] .= "You Can't Less Email Empty";

        }if (empty($password)) {
            $error[] .= "You Can't Less Password Empty";

        }if (empty($password_again)) {
            $error[] .= "You Can't Less conform Password Empty";

        }if (!preg_match('/^[a-zA-Z0-9-_.]*$/i', $username)) {
            $error[] .= "Your Username Must Have Just letter and number";

        }if (strlen($username) <= 2) {
            $error[] .= "Your Username Must be Greater Than 2 Chars ";

        }if (strlen($username) >= 32) {
            $error[] .= "You Username Must be Less Than 32 Cahrs";

        }if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] .= "You Must Put a Valid Email";

        }if ($password !== $password_again) {
            $error[] .= "Your Password Does't Match the Password Again";
        }if (strlen($password) <= 8) {
            $error[] .= "Your Password Must be Greater Than 8 Char";
        }
        $stmt_selct = $pdo->prepare("SELECT `username`,`email` FROM users WHERE username = ? OR email =?");
        $stmt_selct->execute([ $username, $email ]);
        $stmt_fetch = $stmt_selct->fetchAll();

        foreach ($stmt_fetch as $stmt) {

            if ($stmt['username'] === $username) {
                $error[] .= 'This Username Already Taken Please Try Another Username';
            }if ($stmt['email'] === $email) {
                $error[] .= 'This Email Already Taken Please Try Another Email';
            }
        }
        if(!empty($error)) {
                foreach ($error as $err) {

                    echo '<div class="alert alert-danger"><p class="text-center lead">' . $err . '</p></div>';
                }

        }else {
            $sanUsername = htmlentities($username, ENT_QUOTES, 'UTF-8');
            $sanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            $passHash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 9]);
            
            $stmt = $pdo->prepare("INSERT INTO `users`(`username`, `email`, `password`) VALUES(?, ?, ?)");
            $stmt->execute([ $sanUsername, $sanEmail, $passHash ]); // issue while registeration

            if ($stmt->rowCount()) { 
                $message = "Your Registration was Created Successfuly";
                redirectHome($message, null, 4  );

            }else {
                $message = "There is somthing Wrong While Registeration";
                redirectHome($message, null, 4, 'danger');            
            }

        }        
        
    }
}

require_once 'includes/template/footer.php';