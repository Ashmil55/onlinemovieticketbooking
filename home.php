<?php
include('connectdb.php');

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$useremail = $_SESSION['useremail'];
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
        <button type="submit" name="bookings" formaction="bookings.php" formmethod="post">Bookings</button>
        <button type="submit" name="logout" formaction="login.php" formmethod="post">Logout</button>
      </form>
    </div>
    <hr>
    Hello <?php echo $username; ?>

    <div id = "searchbar">
      <form>
        <input type="text" name="searchstring" placeholder="Search any movie"></input>
        <button type="submit" name="search" formaction="home.php" formmethod="post">Search</button>
      </form>
      <form>
        Filter by genre :
        <input type="checkbox" name="genre[]" value="Action">Action</input>
        <input type="checkbox" name="genre[]" value="Horror">Horror</input>
        <input type="checkbox" name="genre[]" value="Comedy">Comedy</input>
        <input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input>
        <input type="checkbox" name="genre[]" value="Sports">Sports</input>
        <input type="checkbox" name="genre[]" value="Drama">Drama</input>
        </br>
        Filter by language :
        <input type="checkbox" name="language[]" value="English">English</input>
        <input type="checkbox" name="language[]" value="Hindi">Hindi</input>
        <input type="checkbox" name="language[]" value="Telugu">Telugu</input>
        <input type="checkbox" name="language[]" value="Tamil">Tamil</input>
        </br>
        <button type="submit" name="filter" formaction="home.php" formmethod="post">Filter</button>
      </form>
    </div>
    <!-- <table width="100%" class="table table-striped table-bordered table-hover" id="foundationcourse-view">
      <tr>
        <td>
          <img src="images/jersey.png"/>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/shazam.jpg"/>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/badla.jpg"/>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/avengersendgame.jpg"/>
        </td>
      </tr>
    </table> -->





<!--Normally only the first 10 movies from the movies database must be visible -->
<?php
if (!( (isset($_POST['search'])) OR (isset($_POST['filter'])) )){
  $showmovies = "SELECT * FROM movies WHERE status = 'now playing' LIMIT 0,3";
  $runshowmovies = mysqli_query($conn, $showmovies);

  while ($row = mysqli_fetch_assoc($runshowmovies)) {
    $movies[] = $row;
  }
?>
    <div id="initmovies">
      <table>
        <tr>
          <th>Movie</th>
          <th>Genre</th>
          <th>Language</th>
          <th>Average Rating</th>
          <th></th>
        </tr>
        <?php
          foreach ($movies as $movie) {?>
            <tr>
              <td>
                <h3><?php echo $movie['name'];?></h3></br>
                <?php echo $movie['director'];?></br>
                <?php echo $movie['actors'];?>
              </td>
              <td><?php echo $movie['genre'];?></td>
              <td><?php echo $movie['language'];?></td>
              <td><?php echo $movie['averagerating'];?></td>
              <td><form><button name="details" formaction="movie.php?movieid=<?php echo $movie['movieid'];?>" formmethod="post">Details</button></form></td>
            </tr>
        <?php  }
        ?>

      </table>
    </div>
<?php
}
?>

<!-- Show searched movie(s) -->
<?php
if (isset($_POST['search'])){
  $searchstring = $_POST['searchstring'];

  $searchmovies = "SELECT * FROM movies WHERE name LIKE '%$searchstring%' ";
  $runsearchmovies = mysqli_query($conn, $searchmovies);

  while ($row = mysqli_fetch_assoc($runsearchmovies)){
    $movies[] = $row;
  }
?>

  <div id="searched">
    <table>
      <tr>
        <th>Movie</th>
        <th>Genre</th>
        <th>Language</th>
        <th>Average Rating</th>
        <th></th>
      </tr>
      <?php
        foreach ($movies as $movie) {?>
          <tr>
            <td>
              <h3><?php echo $movie['name'];?></h3></br>
              <?php echo $movie['director'];?></br>
              <?php echo $movie['actors'];?>
            </td>
            <td><?php echo $movie['genre'];?></td>
            <td><?php echo $movie['language'];?></td>
            <td><?php echo $movie['averagerating'];?></td>
            <td><form><button name="details" formaction="movie.php?movieid=<?php echo $movie['movieid'];?>" formmethod="post">Details</button></form></td>
          </tr>
      <?php  }
      ?>

    </table>
  </div>

<?php
}
?>

<!-- Show movies after filtering  -->
<?php
if (isset($_POST['filter'])){
  $genre = $_POST['genre'];
  $genrelist= "'".implode("','", $genre)."'";

  $language = $_POST['language'];
  $languagelist= "'".implode("','", $language)."'";


  $filtermovies = "SELECT * FROM movies WHERE (genre IN ($genrelist)) OR (language IN ($languagelist))";
  // echo $genrelist;
  // echo $filtermovies;
  $runfiltermovies = mysqli_query($conn, $filtermovies);


  while ($row = mysqli_fetch_assoc($runfiltermovies)){
    $filteredmovies[] = $row;
  }
  // var_dump($filteredmovies);
?>

<div id="filtered">
  <?php if (!empty($filteredmovies)){?>
  <table>
    <tr>
      <th>Movie</th>
      <th>Genre</th>
      <th>Language</th>
      <th>Average Rating</th>
      <th></th>
    </tr>
    <?php
      foreach ($filteredmovies as $movie) {?>
        <tr>
          <td>
            <h3><?php echo $movie['name'];?></h3></br>
            <?php echo $movie['director'];?></br>
            <?php echo $movie['actors'];?>
          </td>
          <td><?php echo $movie['genre'];?></td>
          <td><?php echo $movie['language'];?></td>
          <td><?php echo $movie['averagerating'];?></td>
          <td><form><button name="details" formaction="movie.php?movieid=<?php echo $movie['movieid'];?>" formmethod="post">Details</button></form></td>
        </tr>
    <?php  }
    }
    else {
      echo "The are no movies matching your filter";
    ?>

  <?php }?>

  </table>
</div>

<?php
}
 ?>







  </body>
</html>
