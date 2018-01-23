<div class="navbar-wrapper">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Dashbord</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li ><a href="posts.php?post=add">Add Post</a></li>
                        <li><a href="posts.php">View Posts</a></li>
                        <?php if (Select('users', $_SESSION['username'])['privil'] === '3'){?>
                            <li><a href="users.php">Users</a></li>
                        <?
                            }
                        ?>
                        <?php if (Select('users', $_SESSION['username'])['privil'] === '3'){?>
                            <li><a href="prvl.php">Privlig</a></li>
                        <?
                            }
                        ?>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=ucwords($_SESSION['username'])?><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="../">Blogger</a></li>
                                <li><a href="edit.php">Edit Profile</a></li>
                                <li><a href="edit.php?do=editPass">Change Password</a></li>
                                <li class=""><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
</div>