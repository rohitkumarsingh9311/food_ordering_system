<?php
  session_start();
  include_once('database.inc.php'); 
  include_once('function.inc.php');
  unset($_SESSION['IS_LOGIN']);
  redirect('login.php')
?>