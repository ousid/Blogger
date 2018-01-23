
   <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Blogger</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php?post=about">About Us
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?post=services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            <li class="nav-item">
              <?
                if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] = true) {
?>
                  <a class="nav-link text-info" target="_blank" href="admin/dashboard.php"><strong><?=$_SESSION['username']?></strong></a>
<?                  
                }else {
?>
                  <a class="nav-link" href="admin/login.php" target="_blank">Login</a>
<?                  
                }
              ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
