<?php 

session_start();
$nav = '';
$title = 'Edit Info';
require_once 'ini.php';
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    
    $fetch = Select('users',  $_SESSION['username']);
    $valid = ['editEmail', 'editPass', 'editNname', 'editUsername', 'addNname'];
    $do = isset($_GET['do']) && in_array($_GET['do'], $valid) ? $_GET['do'] : 'manage';

    if ($do == 'manage') { ?>
            <div class="container">
                <div class='table-responsive'>
                    <table class='text-center table table-bordered'>
                            <tr>
                                <td class="table-names">Username</td>
                                <td class="info-names"><?=$fetch['username']?></td>
                                <td><a href="?do=editUsername" class="btn btn-success btn-information">Edit</a></td>
                            </tr>
                            <tr>
                                <td class="table-names">Email</td>
                                <td class="info-names"><?=$fetch['email']?></td>
                                <td><a href="?do=editEmail" class="btn btn-success btn-information">Edit</a></td>
                            </tr>
                            <tr>
                                <td class="table-names">Nick Name</td>
                                <? if (!empty($fetch['nickName'])) {?>
                                    <td class="info-names"><?=$fetch['nickName']?></td>
                                    <td><a href="?do=editNname" class="btn btn-success btn-information">Edit</a></td>
                                <?
                                }else {?>
                                    <td><b class="text-danger">There's No Nickname</b></td>
                                    <td><a href="?do=addNname" class="btn btn-primary btn-info btn-information">Add One</a></td>
                                <?
                                }
                                ?>
                            </tr>
                    </table>
                </div>
            </div>
    <?
    }elseif($do == 'editUsername') { ?>
            <h1 class="text-center">Edit Username</h1>
            <div class="card-block">
                <form action="update.php?update=updateUsername" method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="hidden" name="id" value="<?=$_SESSION['id']?>" class="form-control" id="username" placeholder="Put Your Username">
                        <input type="text" name="username" value="<?=$_SESSION['username']?>" class="form-control" id="username" placeholder="Put Your Username">
                    </div>
                    <input type="submit" value="Update" name="updateUser" class="btn btn-primary btn-block">
                </form>
            </div>
    <?
    }elseif($do == 'editEmail') {?>

        <h1 class="text-center">Update Email</h1>
        <div class="card-block">
            <form action="update.php?update=updateEmail" method="POST">
                <div class="form-group">
                    <label for="email">Update Email</label>
                    <input type="hidden" name="id" value="<?=$_SESSION['id']?>" />
                    <input type="email" name="email" value="<?=$_SESSION['email']?>" class="form-control" id="email" placeholder="Please Put a Valid Email">
                </div>
                <input type="submit" value="Update" name="updateEmail" class="btn btn-primary btn-block">
            </form>
        </div>
    </div>
    <?
    }elseif ($do == 'editNname') {?>
            <h1 class="text-center">Edit Nickname</h1>
            <div class="card-block">
                <form action="update.php?update=updateNname" method="POST">
                    <div class="form-group">
                        <label for="nickName">Update Nickname</label>
                        <input type="hidden" name="id" value="<?=$_SESSION['id']?>" />
                        <input type="text" name="nickname" value="<?=$fetch['nickName']?>" class="form-control" id="nickName" placeholder="Put Your Username">
                    </div>
                    <input type="submit" value="Update" name="updateNname" class="btn btn-primary btn-block">
                </form>
            </div>
    <?
    }elseif ($do == 'addNname') {?>
            <h1 class="text-center">Add Nickname</h1>
            <div class="card-block">
                <form action="update.php?update=addNewName" method="POST">
                    <div class="form-group">
                        <label for="add">Nickname</label>
                        <input type="text" name="addNname" class="form-control" id="add" placeholder="Put Your Username">
                    </div>
                    <input type="submit" value="Add" name="addNickname" class="btn btn-primary btn-block">
                </form>
            </div>
    <?
    }elseif ($do == 'editPass') {?>
            <h1 class="text-center">Edit Password</h1>
            <div class="card-block">
                <form action="update.php?update=updatePass" method="POST">
                    <div class="form-group">
                        <label for="old">Current Password</label>
                        <input type="password" name="oldpassword" class="form-control" id="old" placeholder="Please Your Old Password">
                    </div>

                    <div class="form-group">
                        <label for="new">New Password</label>
                        <input type="password" name="newpassword" class="form-control" id="new" placeholder="Recreate Your New Password">
                    </div>

                    <div class="form-group">
                        <label for="newAgain">Repete Password</label>
                        <input type="password" name="newpasswordagain" class="form-control" id="newAgain" placeholder="Please rebete Your New Password">
                    </div>
                    <input type="submit" value="Update" name="updatePass" class="btn btn-primary btn-block">
                </form>
            </div>
    <?
    }else {
        header('Location: edit.php');
    }

}else {
    header('Location: index.php');
}

require_once 'includes/template/footer.php';