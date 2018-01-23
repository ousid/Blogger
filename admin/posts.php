<?php 

session_start();
$title = 'posts';
$nav = '';
require_once 'ini.php';
    
if (isset($_SESSION) && $_SESSION['loggedIn'] === true) {

    $allowed = ['manage', 'add', 'delete', 'update', 'approve', 'edit', 'insert']; 
    $post    = isset($_GET['post']) && ctype_alpha($_GET['post']) ? $_GET['post'] : 'manage'; 
    $id      = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;       
        if ($post === 'manage') {
            if (SelectFeild('posts WHERE username ', $_SESSION['username'], 'count') > 0) {
        ?>
            <div class="container">
                <div class='table-responsive'>
                    <table class='text-center table table-bordered'>
                            <tr>
                                <td class="table-names">#ID</td>
                                <td class="table-names">Title</td>
                                <td class="table-names">Created at</td>
                                <td class="table-names">Categorie</td>
                                <td class="table-names">Author</td>
                                <td class="table-names">Control</td>
                            </tr>
                            <?
                            if (Select('users', $_SESSION['username'])['privil'] == '3') {
                                foreach(SelectFeild('posts WHERE 1', 1 , false, 'ORDER BY approve') as $posts) {
                                    ?>
                                   <tr>
                                        <td class="info-names"><?=$posts['id']?></td>
                                        <td class="info-names"><?=$posts['title']?></td>
                                        <td class="info-names"><?=$posts['date_created']?></td>
                                        <td class="info-names"><?=ucwords(SelectFeild('categories WHERE id', $posts['cat_id'])['categories'])?></td>
                                        <td class="info-names"><?=ucwords($posts['username'])?></td>
                                        <td>
                                        <a href="?post=edit&id=<?=$posts['id']?>" class="btn btn-success ">Edit</a>
                                        <a href="?post=delete&id=<?=$posts['id']?>" class="btn btn-warning confirm">Delete</a>
                                        <?
                                            if (Select('users', $_SESSION['username'])['privil'] !== '0') {
                                                if ($posts['approve'] === '0' ) {
                                                ?>  
                                                
                                                <a href="?post=approve&id=<?=$posts['id']?>" class="btn btn-info">Approve</a></td>
                                                <?
                                                }
                                            }
                                        ?>
                                    </tr>
                                    <? 
                                } 
                            }else {
                                foreach (SelectFeild('posts WHERE username ', $_SESSION['username'], false) as $post) {
                                    ?>
                                    <tr>
                                        <td class="info-names"><?=$post['id']?></td>
                                        <td class="info-names"><?=$post['title']?></td>
                                        <td class="info-names"><?=$post['date_created']?></td>
                                        <td class="info-names"><?=ucwords(SelectFeild('categories WHERE id', $post['cat_id'])['categories'])?></td>
                                        <td class="info-names"><?=ucwords($post['username'])?></td>
                                        <td>
                                        <a href="?post=edit&id=<?=$post['id']?>" class="btn btn-success ">Edit</a>
                                        <a href="?post=delete&id=<?=$post['id']?>" class="btn btn-warning confirm">Delete</a>
                                        <?
                                            if (Select('users', $_SESSION['username'])['privil'] !== '0') {
                                                if ($post['approve'] === '0' ) {
                                                ?>  
                                                
                                                <a href="?post=approve&id=<?=$post['id']?>" class="btn btn-info">Approve</a></td>
                                                <?
                                                }
                                            }
                                        ?>
                                    </tr>
                                    
                                    <?
                            }
                                }
                            ?>
                    </table>
                </div>
            </div>                
        <?
            }else {
                $message = 'There\'s No Posts Yet <a href="?post=add" class="text-danger"><strong>Create One</strong></a>';
                alert($message, 'info');
            }
        }elseif ($post === 'add') {
        ?>
                <div class="container">
                    <h1 class="text-center">Add Post</h1>
                        <form action="?post=insert" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="Title">Title</label>
                                <input type="text" name="title" class="form-control" id="Title" placeholder="Put Your Title">
                            </div>
                            <div class="form-group">
                                <label for="Blog">Your Blog</label>
                                <textarea name="blog" class="form-control" rows="12" id="Blog" placeholder="Post Your Blog"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Tags">Tags</label>
                                <input type="text" name="tags" class="form-control" id="Tags" placeholder="Put Your Tags here < Separete Your Tags With comma (,) >">
                            </div>
                            <div class="form-group">
                                <label for="cat">Pick Categorie</label>
                                <select name="categories" class="form-control">
                                    <?
                                        foreach (SelectAll('categories') as $cat) {
                                            echo '<option value="'. $cat['id'] .'">' . $cat['categories']. '</option>';
                                        }
                                    ?>
                                </select>   
                            </div>
                                <input type="submit" value="Post" name="postBlog" class="btn btn-primary btn-block">
                        </form>
                </div>
        
        <?php 
        }elseif($post === 'insert') {
            if (isset($_POST, $_POST['postBlog'], $_POST['title'], $_POST['blog'])) {
                $title = $_POST['title'];
                $blog  = $_POST['blog'];
                $tags  = $_POST['tags'];
                $cat   = $_POST['categories'];
                $errors = [];

                if (empty($title)) {
                    $errors[] .= 'You Cant Leave The title Empty';
                }
                if (empty($blog)) {
                    $errors[] .= 'You Must fill up your Blog Content';
                }
                if (strlen($title) <= 5 || strlen($title) >= 32) {
                    $errors[] .= 'Your Title Must be Greate Than 5 Chars And Less Than 32 Chars';
                }
                if (!preg_match('/^[a-zA-Z0-9-_.@?:! ]*$/i', $title)) {  
                    $errors[] .= 'Your title Must Have Just Letters or Numbers or [-_.@!?:]';
                }
                if (!preg_match('/^[A-Za-z0-9-_.@!?: ]*$/i', $blog)) {
                    $errors[] .= 'Your Blog Must Have Just Letters or Numbers or [-_.@!?:]';
                }
                if (!preg_match('/^[A-Za-z0-9,]/i', $tags)) {
                    $errors[] .= 'Your Tags Must Only Have Letters or Numbers Separeted With comma(,)';
                }

                if (!empty($errors)) {
                    foreach ($errors as $error) {
                        alert($error, 'danger');
                    }
                    echo '<div class="container">';
                        echo '<a href="' . $_SERVER['HTTP_REFERER'] . '"class="btn btn-block btn-info">Go Back</a>';
                    echo '</div>';

                }else {
                    $sanTitle   = e($title);
                    $post_hash  = uniqid(time());
                    $sanBlog    = e($title);
                    $id         = (int)$_SESSION['id'];
                    $username   = e($_SESSION['username']);
                    $sanTags       = e($tags);

                    $stmt = $pdo->prepare("INSERT INTO posts(`user_id`, `cat_id`, `post_hash`,  `username`, `title`, `content`, `tags`) VALUES(:user_id, :cat_id, :post_hash, :post_user, :title, :content, :tags)");
                    $stmt->execute([
                        'user_id' => $id,
                        'cat_id'  => $cat,
                        'post_hash' => $post_hash,
                        'post_user' => $username,
                        'title' => $sanTitle,
                        'content' => $sanBlog,
                        'tags' => $sanTags,
                    ]);

                    if ($stmt->rowCount()) {
                        $message = 'Your Blog Was Add Susseccfuly';
                        redirectHome($message, 'posts.php', 3);
                    }else{
                        $message = 'There Was an Error While Create Your Blog';
                        redirectHome($message, 'posts.php', 3, 'danger');
                    }
                }
            }else {
                header('Location: posts.php');
            }
        }elseif ($post === 'edit') {
            $post  = SelectFeild('posts WHERE id ', $id, true);

            if (isset($id) && !empty($id)) {
?>
                <div class="container">
                    <h1 class="text-center">Edit Post</h1>
                        <form action="?post=update" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="Title">Title</label>
                                <input type="hidden" name="id" class="form-control" value="<?=$id?>" id="Title" placeholder="Put Your Title">
                                <input type="text" name="title" class="form-control" value="<?=$post['title']?>" id="Title" placeholder="Put Your Title">
                            </div>
                            <div class="form-group">
                                <label for="Blog">Your Blog</label>
                                <textarea name="blog" class="form-control" rows="12" id="Blog" placeholder="Post Your Blog"><?=$post['content']?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Tags">Tags</label>
                                <input type="text" name="tags" class="form-control" id="Tags" value="<?=$post['tags']?>" placeholder="Put Your Tags here < Separete Your Tags With comma (,) >">
                            </div>
                            <div class="form-group">
                                <label for="cat">Pick Categorie</label>
                                <select name="categories" class="form-control">
                                    <?
                                        foreach (SelectAll('categories') as $cat) {
                                            echo '<option value="'. $cat['id'] .'">' . $cat['categories']. '</option>';
                                        }
                                    ?>
                                </select>   
                            </div>
                                <input type="submit" value="Post" name="postBlog" class="btn btn-primary btn-block">
                        </form>
                </div>
<?
            }else {
                header('Location: posts.php');
            }

        }elseif ($post === 'update') {

            if (isset($_POST, $_POST['postBlog'], $_POST['title'], $_POST['blog'])) { 
                $id = $_POST['id'];
                $title = $_POST['title'];
                $blog  = $_POST['blog'];
                $tags  = $_POST['tags'];
                $cat   = $_POST['categories'];
                $errors = [];

                if (empty($title)) {
                    $errors[] .= 'You Cant Leave The title Empty';
                }
                if (empty($blog)) {
                    $errors[] .= 'You Must fill up your Blog Content';
                }
                if (strlen($title) <= 5 || strlen($title) >= 32) {
                    $errors[] .= 'Your Title Must be Greate Than 5 Chars And Less Than 32 Chars';
                }
                if (!preg_match('/^[a-zA-Z0-9-_.@?:! ]*$/i', $title)) {  
                    $errors[] .= 'Your title Must Have Just Letters or Numbers or [-_.@!?:]';
                }
                if (!preg_match('/^[A-Za-z0-9-_.@!?: ]*$/i', $blog)) {
                    $errors[] .= 'Your Blog Must Have Just Letters or Numbers or [-_.@!?:]';
                }
                if (!preg_match('/^[A-Za-z0-9,]/i', $tags)) {
                    $errors[] .= 'Your Tags Must Only Have Letters or Numbers Separeted With comma(,)';
                }

                $post_update  = SelectFeild('posts WHERE id ', $id, true);

                if ($post_update['title'] === $title && $post_update['content'] === $blog && $post_update['tags'] === $tags) {
                    $message = 'Your Post Does not Changed';
                    alert($message, 'info');
                    header('refresh:3;url=posts.php');
                }elseif (!empty($errors)) {
                    foreach ($errors as $error) {
                        alert($error, 'danger');
                    }
                    echo '<div class="container">';
                        echo '<a href="' . $_SERVER['HTTP_REFERER'] . '"class="btn btn-block btn-info">Go Back</a>';
                    echo '</div>';

                }else {

                    $sanTitle   = e($title);
                    $sanBlog    = e($blog);
                    $sanCat    = e($cat);
                    $id         = (int)$id;
                    $username   = e($_SESSION['username']);
                    $sanTags       = e($tags);

                    $stmt = $pdo->prepare("UPDATE `posts` SET `cat_id` = :cat_id, `title`= :title,`content`= :content, `updated_at`= :updated_date,`tags`= :tags,`approve`= :approved WHERE `id` = :id");
                    $stmt->execute([
                        'cat_id'     => $sanCat,
                        'title'      => $sanTitle,
                        'content'    => $sanBlog,
                        'updated_date' => date('Y-d-m H:i'),
                        'tags'       => $sanTags,
                        'approved'   => 0,
                        'id'         => $id
                        ]);
                    if ($stmt->rowCount()) {
                        $message = 'Your Blog Was Updated Susseccfuly';
                        redirectHome($message, '', 3);
                    }else{
                        $message = 'There Was an Error While Update Your Blog';
                        redirectHome($message, '', 3, 'danger');
                    }
                }
            }else {
                header('Location: posts.php');
            }

        }elseif ($post === 'delete') {
            if (isset($id) && !empty($id)) {

                $stmt = $pdo->prepare("DELETE FROM `posts` WHERE id = ?");
                $stmt->execute([$id]);
                if ($stmt->rowCount()) {
                    $message = 'Your Blog Was Deleted Susseccfuly';
                    redirectHome($message, '', 3);
                }else{
                    $message = 'There Was an Error While Delete Your Blog';
                    redirectHome($message, '', 3, 'danger');
                }
            }
        }elseif ($post === 'approve') {
                $stmt = $pdo->prepare("UPDATE `posts` SET `approve` = ? WHERE id = ?");
                $stmt->execute([1, $id]);
    
                if ($stmt->rowCount()) {    
                    $message = 'Your Blog Was Approved Susseccfuly';
                    redirectHome($message, 'posts.php', 3);
                }else{
                    $message = 'There Was an Error While Approved Your Blog';
                    redirectHome($message, 'posts.php', 3, 'danger');
                }
            }else {
                header('Location: index.php');
            }
}else {
    header('Location: index.php');
}

require_once 'includes/template/footer.php';

// fix issue the id redirect 