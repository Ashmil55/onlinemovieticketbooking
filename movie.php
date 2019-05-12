<?php
include('connectdb.php');

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$useremail = $_SESSION['useremail'];
// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(E_ALL);

?>





 <?php
 if (isset($_POST['rate'])){
   $movieid = $_GET['movieid'];


   $getmovie = "SELECT * FROM movies WHERE movieid = $movieid ";
   $rungetmovie = mysqli_query($conn, $getmovie);
   $movie = mysqli_fetch_assoc($rungetmovie);
   // echo "I am here";
   $rating = $_POST['rating'];
   // echo $rating."\n";
   $currentrating = $movie['averagerating'];
   // echo $currentrating;
   $numberofusersrated = $movie['numberofusersrated'];

   // echo $numberofusersrated;

   $currentrating = (($currentrating * $numberofusersrated) + $rating)/($numberofusersrated+1);

   $currentrating = round($currentrating,2);
   $numberofusersrated = $numberofusersrated+1;
   $insertrating = "UPDATE movies SET averagerating = $currentrating, numberofusersrated = $numberofusersrated WHERE movieid = $movieid ";
   // echo $insertrating;
   mysqli_query($conn, $insertrating);

 }
?>

<?php
$movieid = $_GET['movieid'];


$getmovie = "SELECT * FROM movies WHERE movieid = $movieid ";
$rungetmovie = mysqli_query($conn, $getmovie);
$movie = mysqli_fetch_assoc($rungetmovie);

 ?>

 <!-- Getting data from shows table -->
 <?php
 // Getting dates
$getdates = "SELECT DISTINCT date FROM shows WHERE movieid = $movieid ";
$rungetdates = mysqli_query($conn, $getdates);
while($row = mysqli_fetch_assoc($rungetdates)){
  $dates[] = $row;
}

// Getting times
$gettimes = "SELECT DISTINCT time FROM shows WHERE movieid = $movieid ";
$rungettimes = mysqli_query($conn, $gettimes);
while($row = mysqli_fetch_assoc($rungettimes)){
  $times[] = $row;
}

// Getting shows
$getshowdata = "SELECT * FROM shows WHERE movieid = $movieid";
$rungetshowdata = mysqli_query($conn, $getshowdata);
while ($row = mysqli_fetch_assoc($rungetshowdata)){
  $shows[] = $row;
}

?>

<html>
  <head>
    <title>Home Page</title>
    <style>
    #image {
      /* width : 50%; */
      /* border : 1px solid red; */
      margin-right: 10px;
      float : left;
      overflow: hidden;
      /* width : 100%; */
    }
    #summary{
      /* float : left; */
      margin-right: 5px;
      overflow: hidden;
      height: 40%;
      padding-bottom: 10px;
    }

      img {
        width : 386px;
        height : 500px;
      }

      /* Styling the table  */
      table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      table td, table th {
        border: 1px solid #ddd;
        padding: 8px;
      }

      table tr:nth-child(even){background-color: #f2f2f2;}

      table tr:hover {background-color: #ddd;}

      table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #51C2DE;
        color: white;
      }
      /* End styling the table */

    </style>
  </head>

  <body>
    <div id = "navbar">
      <form>
        <button type="submit" name="home" formaction="home.php" formmethod="post">Home</button>
        <button type="submit" name="bookings" formaction="bookings.php" formmethod="post">Bookings</button>
        <button type="submit" name="logout" formaction="login.php" formmethod="post">Logout</button>
      </form>
    </div>
    <hr>

    <div id="movie">

      <h2><?php echo $movie['name'];?></h2>

      <div id = "image">
        <img src=<?php echo $movie['imageurl']; ?>>
      </div>

      <div id = "summary">
        <?php echo $movie['summary']; ?>
        <p>
          <b>Average rating : <?php echo $movie['averagerating'];?></b> (<?php echo $movie['numberofusersrated'];?>)
        </p>

        <p>
          <form>
            Watched the movie? Rate it!
            <input type="radio" name="rating" value="1">1</input>
            <input type="radio" name="rating" value="2">2</input>
            <input type="radio" name="rating" value="3">3</input>
            <input type="radio" name="rating" value="4">4</input>
            <input type="radio" name="rating" value="5">5</input>
            <button type="submit" name="rate" formaction="movie.php?movieid=<?php echo $movie['movieid'];?>" formmethod="post">Rate</button>
          </form>
        </p>

        <p>
          Book your tickets:
          <form>
            Choose a date:
            <select name = "date">
              <?php
                foreach ($dates as $date) { ?>
                  <option value="<?php echo $date["date"]; ?>"><?php echo $date["date"]; ?></option>
              <?php	}
              ?>
            </select></br>
            Choose a time:
            <select name = "time">
              <?php
                foreach ($times as $time) { ?>
                  <option value="<?php echo $time["time"]; ?>"><?php echo $time["time"]; ?></option>
              <?php	}
              ?>
            </select></br>
            <!-- Enter the number of tickets you want
            <input type="number" name="numberoftickets"></input> -->

            <button type="submit" name="selectseats" formaction="movie.php?movieid=<?php echo $movieid; ?>" formmethod="post">Select your seats</button>

          </form>
        </p>
      </div>

    </div>


  </body>
</html>


<?php

if (isset($_POST['selectseats'])){
  $_SESSION['showdate'] = $_POST['date'];
  $_SESSION['showtime'] =  $_POST['time'];

  // $_SESSION['ticketcount'] = $_POST['numberoftickets'];
  $movieid = $_GET['movieid'];
  $_SESSION['movieid'] = $movieid;
  header("Location: selectseats.php?movieid=$movieid");
}

 ?>
