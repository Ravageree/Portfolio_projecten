<?php
require_once 'website_php/config.php';

$conn = dbConnect();

// this will delete all the threads expect for one and that is the admins threads
try {
  $del = "DELETE FROM threads WHERE sub IN('Battlefied', 'CS2', 'Cod', 'R6')";
  $stmt = $conn->prepare($del);
  $stmt->execute();
  header("Location: index.php");
  exit();
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
