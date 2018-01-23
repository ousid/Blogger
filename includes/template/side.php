
        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Search Widget -->
          <div class="card my-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="button">Search</button>
                </span>
              </div>
            </div>
          </div>

          <!-- Categories Widget -->
          <div class="card my-4">
            <h5 class="card-header">Categories</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <?
                        foreach(SelectAll('categories') as $cat) {
                          echo '<spna class="text-info"><a href="categories?cat='. $cat['categories'] .'">' . ucwords($cat['categories']) .'</a></spna> <span class="text-info select"> |  </span> ';
                        }
                      ?>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Categories Widget -->
          <div class="card my-4">
            <h5 class="card-header">Tags</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <?php
                        foreach (SelectAll('posts') as $post) {
                          $exp = explode(',', $post['tags']);
                          foreach ($exp as $ex) {
                            echo '<a href="tags.php?tag='. $ex .'"> ' . $ex . ' </a>  <span class="text-info select">|</span>';
                          }
                        }
                      ?>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">Side Widget</h5>
            <div class="card-body">
              You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->