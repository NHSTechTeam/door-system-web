<?php 
include_once 'db.php';
$code = $_GET['code'] ?? null;
if ($code) {
} else {
    die("No code provided.");
}
#this is how the RPI will check if the barcode is right
try {
    $stmt = $db->query("SELECT * FROM users WHERE code='".$code."';");
    $users = $stmt->fetchAll();
    
    $success = 0;
    $user_id = 0;
    $failure_reason = "";
    if(count($users) == 0){
        echo '{"valid": false, "error": "No user found"}';
        $failure_reason = "Invalid Barcode";
        $user_id = '';
    } else if($users[0]['enabled'] == 1) {
        echo '{"valid": true}';
        $user_id = $users[0]['id'];
        $success = 1;
    } else{ 
        echo '{"valid": false, "error": "Access is disabled for this user"}';
        $user_id = $users[0]['id'];
        $success = 0;
        $failure_reason = "Access is disabled for this user";
    }
    $stmt = $db->prepare("INSERT INTO access_log (user_id, code_scanned, success, method, failure_reason) VALUES (:user_id, :code, :success, :method, :reason);");
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':code', $code);
    $stmt->bindValue(':success', $success);
    $stmt->bindValue(':method', 'BARCODE');
    $stmt->bindValue(':reason', $failure_reason);
    $stmt->execute();
    exit();
} catch (PDOException $e) {
    die('{"valid": false, "error": "Internal Error"}' . $e->getMessage());
}
?>