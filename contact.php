<?php 

session_start();
$title = 'About';

require_once 'ini.php';
?>
    <h1 class="text-center">Contact Us</h1>
<form role="form">
  <div class="form-group">
    <label for="email">Your Name:</label>
    <input type="name" name="name" class="form-control" id="email" placeholder="Please Put Your Name">
  </div>
  <div class="form-group">
    <label for="pwd">Your Email:</label>
    <input type="email" name="name" class="form-control" id="pwd" placeholder="Please Put Your Email">
  </div>

  <div class="form-group">
    <label for="pwd">Your Message:</label>
    <textarea class="form-control" name="message" placeholder="Your Message"></textarea>
  </div>
  <button type="submit" class="btn btn-success">Send</button>
</form>
<? 
require_once 'includes/template/side.php';
require_once 'includes/template/footer.php';