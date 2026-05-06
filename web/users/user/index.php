<?php
require_once '../../db.php';
function generate_totp_secret($length = 32){
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $secret = '';
    for ($i = 0; $i < $length; $i++) {
        $secret .= $chars[random_int(0, 31)];
    }
    return $secret;
}
ob_start();
if ($_GET['user']) {
  $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
  $stmt->bindParam(':id', $_GET['user'], PDO::PARAM_INT);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user) {
    $title = "Edit User";
    $name = $user['name'];
    $code = $user['code'];
  } else {
    die("User not found");
  }
} else {
  $title = "Create User";
  $name = "";
  $code = "";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['userName'];
  $code = $_POST['userCode'];
  if ($_GET['user']) {
    $stmt = $db->prepare("UPDATE users SET name = :name, code = :code WHERE id = :id");
    $stmt->bindParam(':id', $_GET['user'], PDO::PARAM_INT);
  } else {
    $stmt = $db->prepare("INSERT INTO users (name, code, mobilecode) VALUES (:name, :code, :mobilecode)");
  }
  
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':code', $code);
  $mobilecode = generate_totp_secret();
  $stmt->bindParam(':mobilecode', $mobilecode);
  if ($stmt->execute()) {
    header("Location: /users");
    exit();
  } else {
    echo "Error saving user.";
  }
}
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title"></h3>
    <div class="card-tools">
      <a class="btn" href="/users"><i class="fas fa-xmark"></i></a>
    </div>
  </div>
  <div class="card-body">
    <form id="userForm" method="POST">
      <div class="mb-3">
        <label for="userName" class="form-label">Name</label>
        <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter Name" required
          value="<?= htmlspecialchars($name) ?>">
      </div>
      <div class="mb-3">
        <label for="userCode" class="form-label">Code</label>
        <input type="text" class="form-control" id="userCode" name="userCode" placeholder="Enter Code" required
          value="<?= htmlspecialchars($code) ?>">
      </div>
    </form>
  </div>
  <div class="card-footer clearfix">
    <button type="button" class="btn btn-danger" onclick="fetch('/users/user/delete.php?user=<?= $_GET['user']?>').then(r=>window.location.href='/users')">Delete User</button>
    <div class="float-right">
      <a href="/users" class="btn btn-secondary">Cancel</a>
      <button type="submit" form="userForm" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();

include '../../base.php';