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



<?php
$showdate = $_SESSION['showdate'];
$showtime = $_SESSION['showtime'];
// $ticketcount = $_SESSION['ticketcount'];
$movieid = $_GET['movieid'];

$getshowdata = "SELECT * FROM shows WHERE movieid = '$movieid' AND date = '$showdate' AND time = '$showtime' ";
// echo $getshowdata;
// echo $username;
$rungetshowdata = mysqli_query($conn, $getshowdata);
$show = mysqli_fetch_assoc($rungetshowdata);

$seatsavailablearray = explode(",",$show['seatsavailable']);
$seatsavailablearray[0] =" ".$seatsavailablearray[0];
$screenid = $show['screenid'];

$getallseats = "SELECT seats, screenname FROM screens WHERE screenid = $screenid ";
// screenid = $show['screenid']
$rungetallseats = mysqli_query($conn, $getallseats);
$allseats = mysqli_fetch_assoc($rungetallseats);
$allseatsarray = explode(",",$allseats['seats']);
$allseatsarray[0] = " ".$allseatsarray[0];

// echo $show['showid'];
$_SESSION['screenname'] = $allseats['screenname'];

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

     <div id="showdetails">
       Date selected : <?php echo $_SESSION['showdate']; ?></br>
       Show timing : <?php echo $_SESSION['showtime']; ?>
     </div>

     <div id="seatselection" >
       <form align="center">
         <p><h2>SCREEN THIS WAY</h2></p>

         <?php
         $breakcount = 0;
         for ($i = 0; $i < sizeof($allseatsarray); $i = $i+1){
           $breakcount = $breakcount+1;
           if ($breakcount > 10){
             echo "<br>";
             $breakcount = 1;
           }
           ?>
           <div  class="seats" id="seat" style="width:20px; height:10px;">
             <input type="checkbox" name="selectedseats[]" value="<?php echo $allseatsarray[$i]; ?>"  border=5px
              <?php if(!(in_array($allseatsarray[$i], $seatsavailablearray))){
                 // echo "style = background-color:#696969" ;
                 echo "disabled" ;
               } ?>
               > <code><?php echo $allseatsarray[$i]; ?></code></input>
          </div>
          <span class="tab"></span>
           <?php
         }
         ?>

         <p>
           <button type="submit" name="confirmselection" formaction="selectseats.php?movieid=<?php echo $movieid; ?>" formmethod="post">Confirm selection</button>
           <input type="reset" name="resetselection"></input>
           </br>
           <button type="submit" name="cancelselection" formaction="movie.php?movieid=<?php echo $movieid; ?>" formmethod="post">Cancel selection</button>

         </p>

       <form>
     </div>

   </body>

</html>


<?php
if (isset($_POST['confirmselection'])){
  echo "Clicked";
  $selectedseats = $_POST['selectedseats'];
  $_SESSION['selectedseats'] = $selectedseats;
  if (!(empty($selectedseats))){
    $seatsavailablearray = array_diff($seatsavailablearray,$selectedseats);
  }
  $seatsavailable = implode(",",$seatsavailablearray);

  $updateseatsavailable = "UPDATE shows SET seatsavailable = '$seatsavailable' WHERE movieid = '$movieid' AND date = '$showdate' AND time = '$showtime' ";
  // echo $updateseatsavailable;
  mysqli_query($conn, $updateseatsavailable);
  // var_dump($selectedseats);
  // echo "reached near";
  header("Location: bookingconfirmation.php");
}

ob_end_flush();
?>
