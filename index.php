<?php
  session_start();
  $title = "Blogger | Home";
  require_once 'ini.php';
  $allowed = ['manage', 'posts', 'about', 'tags', 'cat', 'page'];

  $posts = isset($_GET['post']) && ctype_alpha($_GET['post']) ? $_GET['post'] : 'manage';
  $id    = isset($_GET['id']) && preg_match('/^[0-9a-f]*$/i', $_GET['id']) ? $_GET['id'] :0;
?>
          <?php
            if ($posts === 'manage') {

              foreach (getPosts('DESC', 5) as $post) {

                ?>

                <!-- Blog Post -->
                <div class="card mb-4">
                  <img class="card-img-top" src="admin/includes/pic/1.jpg" alt="Card image cap">
                  <div class="card-body">
                    <h2 class="card-title"><?=$post['title']?></h2>
                    <p class="card-text"><?=$post['content']?></p>
                    <a href="?post=posts&id=<?=$post['post_hash']?>" class="btn btn-primary">Read More &rarr;</a>
                  </div>
                  <div class="card-footer text-muted">
                    Posted on <?=$post['date_created']?> by
                    <a href="profile?pro=<?=$post['username']?>"><?=$post['username']?></a>
                  </div>
                </div>

          <?
              }
              ?>
                <!-- Pagination -->
                <ul class="pagination justify-content-center mb-4">
                  <li class="page-item">
                    <a class="page-link" href="#">&larr; Older</a>
                  </li>
                  <li class="page-item disabled">
                    <a class="page-link" href="#">Newer &rarr;</a>
                  </li>
                </ul>
                <?
            }elseif ($posts === 'posts') {

              if (isset($id) && $id !== '0') { // issue here
                $postSection = SelectPosts('*', 'WHERE post_hash', $id);
                ?>
              <div class="container">
                <div class="jumbotron">
                  <h1 class="text-center"><?=$postSection['title']?></h1>
                </div>
              </div>

              <div class="container">
                <p><?=$postSection['content']?></p>
                <p>Date Created: <span class="text-info"><Strong><?=$postSection['date_created']?></Strong></span>
                <span>By: <span class="text-info"><Strong class="text-info"><?=$postSection['username']?></Strong></span>
                </span>
              </div>
              <?
              }elseif ($posts == 'about') {
                ?>
                  <h1 class="text-center">About</h1>
                <?

              }elseif ($posts == 'tags') {
                echo $_GET['tags'];

              }elseif ($posts == 'cat') {
                echo $_GET['id'];

              }elseif ($posts == 'services') {
                ?>
                <h1 class="text-center">Our Services</h1>

                <?
              }else {
                header('Location: index.php');
              }
            }
          ?>


<?
require_once 'includes/template/side.php';
require_once 'includes/template/footer.php';
