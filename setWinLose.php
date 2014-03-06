<?php
  require_once('env.php');
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $sql="SELECT ID, Name FROM Decks ORDER BY Name";
  $rs = $conn->query($sql);
  $conn->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Magic</title>
    <link type='text/css' rel='stylesheet' href='main.css'></link>
    <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans+SC:400,900' rel='stylesheet' type='text/css'>
    <script src='http://code.jquery.com/jquery-1.11.0.min.js' type='text/javascript'></script>
    <script src='main.js' type='text/javascript'></script>
  </head>
  <body id='setWinLose'>
    <div id='header'>
      <h1>Magic</h1>
    </div>
    <div id='nav'>
      <a href='index.php'>Home</a>
      <a href='setWinLose.php'>Set Win Lose</a>
      <a href='randomGame.php'>Random Game</a>
    </div>
    <div id='main'>
      <div id='insideWinLose'>
        <h4>Winner</h4>
        <form name='winLose' method='post' action='assignWinLose.php'>
          <select name='winner' id='winner'>
          <?php
            $decks = array();
            while($row = $rs->fetch_assoc()):
              $decks[] = $row;
            endwhile;
          ?>
          <?php
            foreach($decks as $row) {
              echo "<option value='{$row['ID']}'>{$row['Name']}</option>";
            }
          ?>
          </select>
          <h4>Loser 1</h4>
          <select name='loser1' id='loser'>
          <?php
            foreach($decks as $row) {
              echo "<option value='{$row['ID']}'>{$row['Name']}</option>";
            }
          ?>
          </select>
          <h4>Loser 2</h4>
          <select name='loser2' id='loser2'>
          <?php
            foreach($decks as $row) {
              echo "<option value='{$row['ID']}'>{$row['Name']}</option>";
            }
          ?>
          </select>
          <div id='formSubWinLose'>
            <input id='submitWinLose' type='submit' />
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
