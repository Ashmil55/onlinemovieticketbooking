<?php
include('connectdb.php');
?>

<html>
  <head>
    <title></title>
  </head>
  <body>

    <div id="registerbar">
      <form>
        Full Name :<input type="text" name="name" placeholder="Enter your full name"></input>
        Email :<input type="email" name="email" placeholder="Enter your email"></input>
        Password :<input type="password" name="password" placeholder="Enter your password"></input>
        Confirm password :<input type="password" name="confirmpassword" placeholder="Re-enter your password"></input>
        <!-- <button type="submit" name="login" formaction="login.php" formmethod="post">Login</button> -->
        <button type="submit" name="register" formaction="register.php" formmethod="post">Register</button>
        <button type="submit" name="backtologin" formaction="login.php" formmethod="post">Back to login</button>
      </form>
    </div>

  </body>
</html>


<?php
if (isset($_POST['register'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];

  //check if email already exists
  $checkemail = "SELECT * FROM users WHERE email = '$email' ";
  $runcheckemail = mysqli_query($conn, $checkemail);
  $count = mysqli_num_rows($runcheckemail);
  if ($count > 0){
    echo "An account for the given email id already exists";
  }

  //If email doesn't already exists
  else{
      //if password and confirm password match
      //Insert data into users table
    if ($password == $confirmpassword){
      $insertdata = "INSERT INTO users(name, email, password) VALUES('$name','$email',SHA1('$password'))";
      var_dump($insertdata);
      mysqli_query($conn,$insertdata);
      header('Location: login.php');
    }
    else {
      echo "The passwords did not match. Please re-enter";
    }
  }

}
 ?>
