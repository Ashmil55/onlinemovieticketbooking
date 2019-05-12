
<?php
include('connectdb.php');
ob_start();
session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$useremail = $_SESSION['useremail'];
// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(E_ALL);
?>

<!-- Display
User's Name
movie
date and time
seats
Screen name
Total cost  -->
<?php
$movieid = $_SESSION['movieid'];

$getmovie = "SELECT * FROM movies WHERE movieid = $movieid ";
// echo $getmovie;
$rungetmovie = mysqli_query($conn, $getmovie);
$movie = mysqli_fetch_assoc($rungetmovie);
$moviename = $movie['name'];

$date = $_SESSION['showdate'];
$time = $_SESSION['showtime'];
$selectedseats = $_SESSION['selectedseats'];
$screenname = $_SESSION['screenname'];

$totalcost = 15 * sizeof($selectedseats);


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


      #seat {
        /* width: 100%; */
        /* padding: 12px 20px; */
        /* margin: 4px 0; */
        /* box-sizing: border-box; */
        /* border: 3px;
        border-style: solid;
        border-color: coral;*/
        cursor: pointer;


        /* content: ''; */
        position: relative;
        /* top: 0; */
        /* width: 100%; */
        /* height: 100%; */
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border-radius: 7px;



        display: inline;
        /* width: 5px; */
        /* height: 0px; */
       border-radius: 7px;
       background: linear-gradient(to top, #761818, #761818, #761818, #761818, #761818, #B54041,  #F3686A);
       margin-bottom: 10px;
       /* transform: skew(20deg);  */
       margin-top: -32px;
       box-shadow: 0 0 5px rgba(0, 0, 0, 0.5)

      }
      #seatselection{
        /* border-style: solid;
        border-color: coral; */
        background-color: #CCFFFF;

      }

      .seats{

        width : 50px;
        height : 10px;
        /* padding:10px; */
      }
      .tab{
         display:inline-block; width:15px;
       }
       :disabled{
         background-color: #FFFFFF;
         border-style: solid;
         border-color: coral;
       }

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

    <div id="summary">
      <p>
        <h3>Here's a summary of your booking <?php echo $username; ?></h3>
        Movie name :  <?php echo $moviename; ?> </br>
        Date : <?php echo $date; ?> </br>
        Time : <?php echo $time; ?> </br>
        Seats :
        <?php
        for ($i = 0; $i < sizeof($selectedseats); $i = $i+1){
          echo $selectedseats[$i];
        }
         ?> </br>
        Total number of tickets : <?php echo sizeof($selectedseats); ?> </br>
        Total cost : <?php echo $totalcost; ?> </br>
        <form>
          <button type="submit" name="payment" formaction="payment.php" formmethod="pay">Pay</button>
        </form>
      </p>
    </div>

  </body>

</html>
