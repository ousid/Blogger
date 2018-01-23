<?php 

session_start();
$title = 'Users';
$nav = '';
require_once 'ini.php';

if (isset($_SESSION) && $_SESSION['loggedIn'] === true) {

    $allowed = ['manage', 'delete', 'approve',]; 
    $user    = isset($_GET['user']) && ctype_alpha($_GET['user']) ? $_GET['user'] : 'manage'; 
    $id      = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;       
        if ($user === 'manage') {
        ?>
            <div class="container">
                <div class='table-responsive'>
                    <table class='text-center table table-bordered'>
                            <tr>
                                <td class="table-names">#ID</td>
                                <td class="table-names">Username</td>
                                <td class="table-names">Email</td>
                                <td class="table-names">Last login</td>
                                <td class="table-names">Created at</td>
                                <td class="table-names">Level</td>
                                <td class="table-names">Control</td>
                            </tr>
                            <?
                                foreach (SelectAll('users ORDER BY approve AND privil') as $user) {
                                    ?>
                                    
                                    <tr>
                                        <td class="info-names"><?=$user['id']?></td>
                                        <td class="info-names"><?=$user['username']?></td>
                                                <td class="info-names"><?=$user['email']?></td>
                                        <?php 
                                            if (null === $user['last_login']) {
                                                ?>
                                                    <td class="info-names"><span class="text-danger">Unknown</span></td>
                                                <?
                                            }else {
                                                ?>

                                                    <td class="info-names"><?=$user['last_login']?></td>
                                                <?
                                            }
                                        ?>
                                        <td class="info-names"><?=$user['date_created']?></td>
                                        <?
                                        switch($user['privil']) {
                                            case '3':
                                            ?><td class="info-names"><span class="text-info">Super User</span></td><?
                                             break;
                                            case '2':
                                            ?><td class="info-names"><span class="text-info">Modarator</span></td><?
                                             break;
                                            case '1':
                                            ?><td class="info-names"><span class="text-info">Administrator</span></td><?                                            
                                             break;
                                            default:
                                            ?><td class="info-names"><span class="text-info">Normal User</span></td><?
                                             break;
                                        }
                                        ?>
                                        <td>
                                            <?
                                        if ($user['privil'] !== '3' && $user['privil'] !== '2') {
                                            ?>
                                            <a href="?user=edit&id=<?=$user['id']?>" class="btn btn-success ">Edit</a>
                                            <a href="?user=delete&id=<?=$user['id']?>" class="btn btn-warning confirm">Delete</a>
                                        <?
                                        }
                                        ?>
                                        </td>
                                    </tr>
                                    
                                    <?
                                }
                            ?>
                    </table>
                </div>
            </div>                
        <?

        }elseif ($user === 'delete') {
            if (isset($id) && !empty($id)) {

                $stmt = $pdo->prepare("DELETE FROM `users` WHERE id = ?");
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    $message = 'These User Was Deleted Susseccfuly';
                    redirectHome($message, '', 3);
                }else{
                    $message = 'There Was an Error While Delete These User';
                    redirectHome($message, '', 3, 'danger');
                }
            }
        }else {
                header('Location: index.php');
            }
}else {
    header('Location: index.php');
}

require_once 'includes/template/footer.php';

// add edit update user was deleted recreated 