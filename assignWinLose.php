<?php
  require_once('env.php');
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $winner = $_POST['winner'];
  $loser1 = $_POST['loser1'];
  $loser2 = $_POST['loser2'];
  $sql="INSERT INTO Games (winner, loser1, loser2) VALUES ($winner, $loser1, $loser2)";

  $stmt = $conn->prepare($sql);
  if($stmt === false) {
    trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
  }

  $stmt->execute();
  $stmt->close();
  $conn->close();
  header("Location: index.php");
?>
