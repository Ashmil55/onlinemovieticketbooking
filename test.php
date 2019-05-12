<html>
  <head>
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
  </head>
  <body>
    <form>
      <?php
      for ($i = 0; $i <= 10; $i = $i+1){
        ?>
        <div class = "seat" id = "seat1">
          <input type="checkbox" value="seat1" name="A1" border=5px>A1</input>
        </div>
        <?php
      }
      ?>

    <form>
  </body>
</html>

 
