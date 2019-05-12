<?php
include('connectdb.php');

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$useremail = $_SESSION['useremail'];
?>
<?php
$getbookings = "SELECT * FROM bookings WHERE userid = $userid ";
$rungetbookings = mysqli_query($conn, $getbookings);
while ($row = mysqli_fetch_assoc($rungetbookings)){
  $bookings[] = $row;
}
 ?>


<html>
  <head>
    <title>Home Page</title>
    <style>

      img {
        width : 100px;
        height : 100px;
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
    <!-- The navigation bar -->
    <div id = "navbar">
      <form>
        <button type="submit" name="home" formaction="home.php" formmethod="post">Home</button>
        <!-- <button type="submit" name="bookings" formaction="bookings.php" formmethod="post">Bookings</button> -->
        <button type="submit" name="logout" formaction="login.php" formmethod="post">Logout</button>
      </form>
    </div>
    <hr>
    <div id = "bookings">
      <table>
        <tr>
          <th>Movie</th>
          <th>Show date</th>
          <th>Show time</th>
          <th>Number of tickets</th>
          <!-- <th></th> -->
        </tr>
        <?php
          foreach ($bookings as $booking) {?>
            <tr>
              <td>
                <?php echo $booking['moviename'];?></br>
              </td>
              <td><?php echo $booking['date'];?></td>
              <td><?php echo $booking['time'];?></td>
              <td><?php echo $booking['numberoftickets'];?></td>

            </tr>
        <?php  }
        ?>

      </table>
    </div>
  </body>
</html>
