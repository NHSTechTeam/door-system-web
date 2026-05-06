<?php 
include_once 'db.php';
$stmt = $db->prepare("SELECT enabled FROM users WHERE id = :id");
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$enabled = $stmt->fetch(PDO::FETCH_ASSOC);
echo $enabled;
syslog(LOG_NOTICE, "Enabled: ".$enabled['enabled']);
if($enabled['enabled'] == 1) {
    $stmt = $db->prepare("UPDATE users SET enabled = 0 WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $db->prepare("UPDATE users SET enabled = 1 WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
}
?>