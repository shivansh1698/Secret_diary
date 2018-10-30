<?php
  session_start();
  $link = mysqli_connect('localhost','root','3040','sample');
  if($_SESSION['user']){
    if(isset($_POST['content'])){
      $query="UPDATE users SET diary='".mysqli_real_escape_string($link,$_POST['content'])."'where email='".mysqli_real_escape_string($link,$_SESSION['user'])."'";
      mysqli_query($link,$query);
    }
  }
  else{
    header("Location: index.php");
  }

 ?>
