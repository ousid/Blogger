<?php 
session_start();
$title = 'Recover Password';
require_once 'ini.php';
$arr = ['pass', 'reset'];

$do = isset($_GET['do']) && in_array($_GET['do'], $arr) ? $_GET['do'] : 'pass';

if ($do === 'pass') {


?>
    <div class="container">
        <h1 class="text-center">Reset Password</h1>
        <div class="card-block">
            <form action="?do=reset" method="POST">
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" name="email" class="form-control" id="Email" placeholder="Put Your Email to recover Your Password">
                </div>
                <input type="submit" value="Recover" name="recover" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>
<?php 
}elseif ($do === 'reset') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        if (isset($_POST, $_POST['recover'])) {
            
            $email =  filter_var($_POST['email']);
            
            $error = [];
    
            if (empty($email)) {
                $error[] .= "You Can't Less Email Empty";
            }
            if (!filter_var($email, FILTER_SANITIZE_EMAIL)) {
                $error[] .= 'Please Put a Validate Email';
            }
            if (!empty($error)) {
                echo '<div class="container">';
                foreach ($error as $err) {
                    
                        alert($err, 'danger');
                    }    
                    echo '<a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn btn-info center-block">Go Back</a>';
            }else {
    
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE email = :email");
                $stmt->execute(['email' => $email]);
                
                if ($stmt->rowCount()) {
                    $hash = sha1(uniqid('', true)) . sha1(date('Y-m-d H:i'));
    
                    $stmt1 = $pdo->prepare("UPDATE `users` SET token = :token WHERE email = :email");
                    $stmt1->execute([
                        'token' => $hash,
                        'email' => $email,
                    ]);
    
                    if ($stmt1->rowCount()) {
                                $stmt2 = $pdo->prepare("SELECT email, token FROM `users` WHERE email = :email");
                                $stmt2->execute(['email' => $email]);
                                $fetch = $stmt2->fetch();
                                ?>
                                    <div class="container">
                                        <a href="recoverPass.php?email=<?=$fetch['email']?>&token=<?=$fetch['token']?>" class="btn btn-primary btn-block btn-recover"> Click Here to Recover Your Password</a>
                                    </div>
                                <?
                    }else {
                        $message = "There's an Error";
                        echo '<div class="alert alert-danger"><p class="lead text-center">'. $message . '</p></div>';
                                }
                }else {
                    $message = "This email doesn't Exist";
                    echo '<div class="alert alert-danger"><p class="lead text-center">'. $message . '</p></div>';
                
                }
            }
        }
    
    }else {
        header('Location: login.php');
    }
}
    

require_once 'includes/template/footer.php';