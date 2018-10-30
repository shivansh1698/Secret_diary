<?php
  session_start();
  $link = mysqli_connect('localhost','root','3040','sample');
  if($_SESSION['user']){
    echo "<p>You are Logged in!!</p>";
    echo "<p>Welcome <b>".$_SESSION['user']."</b></p>";
    $query="SELECT * from users where email='".mysqli_real_escape_string($link,$_SESSION['user'])."'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);
    $data = $row['Diary'];

    if(isset($_POST['logout'])){
      setcookie('user',"",time()-60*60);
      $_SESSION['user']="";
      header("Location: login.php");
    }
  }
  else{
    header("Location: index.php");
  }

 ?>


 <head>
   <style>
     div,h2{
       text-align: center;
       margin-top: 60px;
     }
     textarea{
       width: 1000px;
       height: 400px;
     }
   </style>
 </head>


<div>
  <h3>Your deepest thoughts!</h3>
  <textarea id="diary">
    <?php echo $data ?>
  </textarea>

</div>
<div>
  <form method="post">

  <input type="submit" value="Log Out" name="logout">

  </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
  $('#diary').bind('input propertychange',function(){
            $.ajax({
              method: "POST",
              url: "update_db.php",
              data: { content : $('#diary').val() }
            }).done(function( msg ){
                });
  });
</script>
