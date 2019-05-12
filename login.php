<?php
include('connectdb.php');
?>
<html>
  <head>
    <script language=javascript>
    function moveImg() {
    	ani.style.pixelLeft = ani.style.pixelLeft + 15
    	if (ani.style.pixelLeft > winWidth.width + 50)
    		clearInterval(mover)
    }

    function startAni() {
    	mover = setInterval("moveImg()",20)
    }
    </script>
    <title>
      Online Movie Booking
    </title>
  </head>
  <body onLoad="startAni()">
  <!-- <body> -->

    <div id="loginbar" >
      <form>
        Email :<input type="email" name="email" placeholder="Enter your email"></input>
        Password :<input type="password" name="password" placeholder="Enter your password"></input>
        <button type="submit" name="login" formaction="login.php" formmethod="post">Login</button>
        <button type="submit" name="newuser" formaction="register.php" formmethod="post">New user</button>
      </form>
    </div>
    <!-- <img src="images/jersey.png" id="ani" style="position: absolute; top: 0px; left: 0px"> -->
    <!-- <img  src="images/trial.gif" style="position: absolute; top: 250px; left: -4000px"></img> -->

    <!-- <img src="images/trial.gif" width=100% height=0 border=0 id="winWidth"> -->
  </body>
</html>

<?php
  if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $checkemail = "SELECT * FROM users WHERE email = '$email' ";
    $runcheckemail = mysqli_query($conn, $checkemail);
    $count = mysqli_num_rows($runcheckemail);
    $row = mysqli_fetch_assoc($runcheckemail);
    //Check email and password
    //If email doesnt exist error
    if ($count > 0){
      if (SHA1($password) == $row['password']){
        // echo "login successfull";
        // echo $password;
        // echo SHA1($password);
        // echo $row['password'];
        session_start();
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['username'] = $row['name'];
        $_SESSION['useremail'] = $row['email'];
        header('Location: home.php');
      }
      else {
        echo "You entered the incorrect password";
      }
    }
    else {
      echo "No user is registered with the email you entered.";
    }
    //If email exists
      //If password doesnt match error

      //store session information and head to home page
  }

 ?>

<?php
if (isset($_POST['logout'])){
  session_destroy();
}
?>
