<?php
require_once '../../db.php';
ob_start();
if ($_GET['user']) {
  $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
  $stmt->bindParam(':id', $_GET['user'], PDO::PARAM_INT);
  $stmt->execute();
}
?>