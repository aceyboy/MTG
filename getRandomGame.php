<?php
  require_once('env.php');
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $repeat = true;
  $max_games = 30;
  while($repeat) {
    $repeat = false;
    $sql="SELECT * FROM Games ORDER BY ID DESC LIMIT 1";
    $lastGame = $conn->query($sql)->fetch_assoc();
    $sql="SELECT ID, Name FROM Decks WHERE ID != {$lastGame['Winner']} AND ID != {$lastGame['Loser1']} AND ID != {$lastGame['Loser2']} ORDER BY RAND() LIMIT 3";
    $rs = $conn->query($sql);
    $decks = array();
    while($row = $rs->fetch_assoc()) {
      $decks[] = $row['Name'];
      $id = $row['ID'];
      $sql = "SELECT COUNT(*) AS TotalGames FROM Games WHERE Winner=$id OR Loser1=$id OR Loser2=$id";
      $gameCount = $conn->query($sql)->fetch_assoc();
      if ($gameCount['TotalGames'] > $max_games) {
        $repeat = true;
      }
    }
  }
  $conn->close();
  echo json_encode($decks);
?>

