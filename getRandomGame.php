<?php
  require_once('env.php');
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $sql="SELECT * FROM Games ORDER BY ID DESC LIMIT 1";
  $lastGame = $conn->query($sql)->fetch_assoc();
  $sql="SELECT Name FROM Decks WHERE ID != {$lastGame['Winner']} AND ID != {$lastGame['Loser1']} AND ID != {$lastGame['Loser2']} ORDER BY RAND() LIMIT 3";
  $rs = $conn->query($sql);
  $conn->close();
  $decks = array();
  while($row = $rs->fetch_assoc()) {
    $decks[] = $row['Name'];
  }
  echo json_encode($decks);
?>

