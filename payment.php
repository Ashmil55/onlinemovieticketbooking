
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
$numberoftickets = sizeof($selectedseats);
$totalcost = 15 * $numberoftickets;


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
        </p>
      </div>
        <p>
        <form>
          <!-- <button type="submit" name="payment" formaction="payment.php" formmethod="pay">Pay</button> -->
          <div id = "card details">
            Payment details : </br>
              Credit Card details
              Name on credit card : <input type="text" name="ccname" placeholder="Enter the name as it appears on your credit card"></input></br>
              Credit card number <input type="text" name = "ccnumber" id ="ccnumber" placeholder="Enter your credit card number" oninput="getCardType()"></input></br>
              Credit card type <input type="text" name="cctype" id = "cctype">
              Expires on <input type="month" name ="ccexp">
              <script>
                function good(){
                  var x = document.getElementById("ccnumber").value;
                  document.getElementById("cctype").value = "You wrote: " + x;
                }
                function getCardType() {
                  var cardNum = document.getElementById('ccnumber').value;
                  // document.getElementById("cctype").value = "You wrote: " + cardNum;

                  // if(!luhnCheck(cardNum)){
                  //     return "";
                  // }
                  var payCardType = "";
                  var regexMap = [
                    {regEx: /^4[0-9]{5}/ig,cardType: "VISA"},
                    {regEx: /^5[1-5][0-9]{4}/ig,cardType: "MASTERCARD"},
                    {regEx: /^3[47][0-9]{3}/ig,cardType: "AMEX"},
                    {regEx: /^(5[06-8]\d{4}|6\d{5})/ig,cardType: "MAESTRO"}
                  ];

                for (var j = 0; j < regexMap.length; j++) {
                  if (cardNum.match(regexMap[j].regEx)) {
                    payCardType = regexMap[j].cardType;
                    break;
                  }
                }

                if (cardNum.indexOf("50") === 0 || cardNum.indexOf("60") === 0 || cardNum.indexOf("65") === 0) {
                  var g = "508500-508999|606985-607984|608001-608500|652150-653149";
                  var i = g.split("|");
                  for (var d = 0; d < i.length; d++) {
                    var c = parseInt(i[d].split("-")[0], 10);
                    var f = parseInt(i[d].split("-")[1], 10);
                    if ((cardNum.substr(0, 6) >= c && cardNum.substr(0, 6) <= f) && cardNum.length >= 6) {
                     payCardType = "RUPAY";
                      break;
                    }
                  }
                }
                document.getElementById("cctype").value = payCardType;

                return payCardType;

            }

            function luhnCheck(cardNum){

                var numericDashRegex = /^[\d\-\s]+$/
                if (!numericDashRegex.test(cardNum)) return false;

                var nCheck = 0, nDigit = 0, bEven = false;
                var strippedField = cardNum.replace(/\D/g, "");

                for (var n = strippedField.length - 1; n >= 0; n--) {
                    var cDigit = strippedField.charAt(n);
                    nDigit = parseInt(cDigit, 10);
                    if (bEven) {
                        if ((nDigit *= 2) > 9) nDigit -= 9;
                    }

                    nCheck += nDigit;
                    bEven = !bEven;
                }

                return (nCheck % 10) === 0;
            }
            </script>
          </div>
          <button type="submit" name="confirmpayment" formaction="payment.php" formmethod="post">Confirm payment</button>
        </form>
      </p>


  </body>

</html>

<?php

if (isset($_POST['confirmpayment'])){

  $insertbooking = "INSERT INTO bookings(userid, moviename, date, time, numberoftickets)
  VALUES ($userid, '$moviename', '$date', '$time', '$numberoftickets')";
  mysqli_query($conn, $insertbooking);
  // echo $insertbooking;
  header("Location: bookingsuccessful.php");

  ob_end_flush();

}
 ?>
