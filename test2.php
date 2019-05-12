<?php
include('connectdb.php');

?>

<?php

$getseats = "SELECT * FROM test";
$rungetseats = mysqli_query($conn, $getseats);
$data = mysqli_fetch_assoc($rungetseats);

echo $data['seats'];
echo "<br>";
// echo $data['seats'][1];

$arrayseats = explode(",",$data['seats']);
// echo $arrayseats[1];

$seats = implode(",",$arrayseats);
echo $seats;

?>
<style>
div {
/* width: 100%; */
/* padding: 12px 20px; */
/* margin: 4px 0; */
/* box-sizing: border-box; */
border: 3px;
border-style: solid;
border-color: coral;
display: inline;
}
</style>

<form>
  <?php
  $breakcount = 0;
  for ($i = 0; $i < sizeof($arrayseats); $i = $i+1){
    $breakcount = $breakcount+1;
    if ($breakcount >10){
      echo "<br>";
      $breakcount = 0;
    }
    ?>
    <!-- <div class = "seat" id = "seat1"> -->
      <input type="checkbox" value="seat1" name="A1" border=5px><?php echo $arrayseats[$i]; ?></input>
    <!-- </div> -->
    <?php
  }
  ?>

<form>

A1, A2, A3, A4, A5, A6, A7, A8, A9, A10, B1, B2, B3, B4, B5, B6, B7, B8, B9, B10, C1, C2, C3, C4, C5, C6, C7, C8, C9, C10, D1, D2, D3, D4, D5, D6, D7, D8, D9, D10, E1, E2, E3, E4, E5, E6, E7, E8, E9, E10, F1, F2, F3, F4, F5, F6, F7, F8, F9, F10, G1, G2, G3, G4, G5, G6, G7, G8, G9, G10, H1, H2, H3, H4, H5, H6, H7, H8, H9, H10, I1, I2, I3, I4, I5, I6, I7, I8, I9, I10, J1, J2, J3, J4, J5, J6, J7, J8, J9, J10, K1, K2, K3, K4, K5, K6, K7, K8, K9, K10, L1, L2, L3, L4, L5, L6, L7, L8, L9, L10, M1, M2, M3, M4, M5, M6, M7, M8, M9, M10, N1, N2, N3, N4, N5, N6, N7, N8, N9, N10, O1, O2, O3, O4, O5, O6, O7, O8, O9, O10
