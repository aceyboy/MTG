<?php
  require_once('env.php');
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $sql="SELECT ID, Name FROM Decks ORDER BY Name";
  $rs = $conn->query($sql);
  $decks = array();
  while($row = $rs->fetch_assoc()) {
    $id = $row['ID'];
    $sql="SELECT COUNT(*) AS Wins FROM Games WHERE winner=$id";
    $winsRes = $conn->query($sql)->fetch_assoc();
    $winCount = $winsRes['Wins'];
    $row['Wins'] = $winCount;
    $sql="SELECT COUNT(*) AS Loses FROM Games WHERE loser1=$id";
    $loseRes = $conn->query($sql)->fetch_assoc();
    $sql="SELECT COUNT(*) AS Loses FROM Games WHERE loser2=$id";
    $loseRes2 = $conn->query($sql)->fetch_assoc();
    $loseCount = $loseRes['Loses'] + $loseRes2['Loses'];
    $gameCount = $winCount + $loseCount;
    $row['Wins'] = $winCount;
    $row['Lose'] = $loseCount;
    $row['Games'] = $gameCount;
    if ($gameCount != 0) {
      $winRate = ($winCount / $gameCount);
    } else {
      $winRate = 0;
    }
    $row['WinRate'] = number_format($winRate, 2);
    $decks[] = $row;
  }
  foreach ($decks as $key => $row) {
    $name[$key] = $row['Name'];
    $wins[$key] = $row['Wins'];
    $loses[$key] = $row['Lose'];
    $games[$key] = $row['Games'];
    $winRates[$key] = $row['WinRate'];
  }
  array_multisort($winRates, SORT_DESC, $wins, SORT_DESC, $loses, SORT_ASC, $games, SORT_DESC, $name, SORT_ASC, $decks);
  $conn->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Magic</title>
    <link type='text/css' rel='stylesheet' href='main.css'></link>
    <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans+SC:400,900' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <script src='http://code.jquery.com/jquery-1.11.0.min.js' type='text/javascript'></script>
    <script src='main.js' type='text/javascript'></script>
  </head>
  <body id='home'>
    <div id='header'>
      <h1>Magic</h1>
    </div>
    <div id='nav'>
      <a href='index.php'>Home</a>
      <a href='setWinLose.php'>Set Win Lose</a>
      <a href='randomGame.php'>Random Game</a>
    </div>
    <div id='main'>
      <h2>Ranking</h2>
      <table>
        <tr class='tableHeader'>
          <th>Ranking</th>
          <th>Name</th>
          <th>Wins</th>
          <th>Lose</th>
          <th>Games</th>
          <th>Win Rate</th>
        </tr>
        <?php
          $c = 0;
          foreach ($decks as $row) {
            $class = ($c % 2 == 0) ? 'odd' : 'even';
            $c++;
            echo "<tr class='$class'>";
            echo "<td>$c</td>";
            echo "<td>{$row['Name']}</td>";
            echo "<td>{$row['Wins']}</td>";
            echo "<td>{$row['Lose']}</td>";
            echo "<td>{$row['Games']}</td>";
            echo "<td>{$row['WinRate']}</td>";
            echo "</tr>";
          }
        ?>
      </table>
    </div>
  </body>
</html>
