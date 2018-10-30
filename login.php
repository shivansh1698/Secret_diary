<?php
  session_start();
  if(isset($_COOKIE['user'])){
    $_SESSION['user']=$_COOKIE['user'];
    header("Location: session.php");
  }
  $link=mysqli_connect("localhost","root","3040","sample");
  if($_SERVER['REQUEST_METHOD']=="POST"){
    $error = "";
    if(isset($_POST['login'])){
      if($_POST['email'] || $_POST['password']){
        if($_POST['email']==""){
          $error.= "<p>Email field is required</p>";
        }
        else if($_POST['password']==""){
          $error.="<p>Password field is required</p>";
        }
        else{
          $query="SELECT * from users where email='".mysqli_real_escape_string($link, $_POST['email'])."'";
          $result = mysqli_query($link,$query);
          if(mysqli_num_rows($result)==0){
            $error.="<p>Invalid Email or Password</p>";
          }
          else{
            $row=mysqli_fetch_array($result);
            $pass = md5(md5($row['id']).$_POST['password']);
            if($row['password']==$pass){
              $_SESSION['user']=$_POST['email'];
              if(isset($_POST['check_log'])){
                setcookie('user',$_POST['email'],time()+60*60*24);
              }
              header("Location: session.php");
            }
            else{
              $error.="<p>Invalid Email or Password</p>";
            }
          }
        }
      }
      else{
        $error.="<p>Email and Password fields are required.</p>";
      }
    }
  }
?>


<h2>Login</h2>
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
    <p><label for="log">Keep logged in</label>
      <input type="checkbox" name="check_log" id="log"></p>
    <input type="submit" name="login" value="Log In">
    <p><a href="signup.php">Sign Up</a></p>
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
