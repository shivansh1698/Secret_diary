<?php
  $link=mysqli_connect("localhost","root","3040","sample");
  if($_SERVER['REQUEST_METHOD']=="POST"){
    $error = "";
      if(isset($_POST['signup'])){
        if($_POST['email'] || $_POST['password']){
          if($_POST['email']==""){
            $error.= "<p>Email field is required</p>";
          }
          else if($_POST['password']==""){
            $error.="<p>Password field is required</p>";
          }
          else{
            $query="SELECT id from users where email='".mysqli_real_escape_string($link, $_POST['email'])."'";
            $result = mysqli_query($link,$query);
            if(mysqli_num_rows($result)>0){
              $error.="<p>The email is already registered. Please sign up from another email.</p>";
            }
            else{
              $query="INSERT INTO users(`email`,`password`) VALUES ('".mysqli_real_escape_string($link,$_POST['email'])."','".mysqli_real_escape_string($link,$_POST['password'])."')";
              mysqli_query($link,$query);
              $query="SELECT id from users where email='".mysqli_real_escape_string($link, $_POST['email'])."'";
              $result = mysqli_query($link,$query);
              $row=mysqli_fetch_array($result);
              $pass = md5(md5($row['id']).$_POST['password']);
              $query= "UPDATE users set password='".mysqli_real_escape_string($link, $pass)."' where email='".mysqli_real_escape_string($link, $_POST['email'])."'";
              mysqli_query($link,$query);
              header("Location: login.php");
            }
          }
        }
        else{
          $error.="<p>Email and Password fields are required.</p>";
        }
      }
  }

?>


<h2>Sign Up</h2>
<head>
  <style>
    div,h2{
      text-align: center;
      margin-top: 60px;
    }
  </style>
</head>


<div>
  <p id="error"><?php if(isset($_POST['signup'])||isset($_POST['login'])){ if($error){echo "There were error(s) in your form:".$error; }}?></p>
  <br><br>
</div>
<div>
  <form method="post">
    <input placeholder="Email "type="email" name="email">
    <input placeholder="Password" type="password" name="password" id="password">
    <input type="checkbox" onclick="myFunction()">Show Password
    <p><input type="submit" name="signup" value="Sign Up"></p>
    <p><a href="login.php">Log In</a></p>
  </form>
<div>

<script>
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
}
</script>
