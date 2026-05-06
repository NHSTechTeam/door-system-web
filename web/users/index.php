<?php
$title = "Users";
require_once '../db.php';

try {
    $stmt = $db->query("SELECT * FROM users;");
    #echo implode(', ', $stmt->fetchAll());
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Failed to fetch users: " . $e->getMessage());
}
ob_start();
?>
<div class="content">
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <a class="btn" href="/users/user">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['code']) ?></td>
                            <td>
                                <?php if (!empty($user['enabled'])): ?>
                                    <span class="badge badge-success">Enabled</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a title="Edit" class="btn btn-sm btn-primary" href="/users/user?user=<?= $user['id'] ?>">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <a title="Logs" class="btn btn-sm btn-primary" href="/logs?u=<?= $user['id'] ?>">
                                    <i class="fas fa-table-list"></i>
                                </a>
                                <?php if (!empty($user['enabled'])): ?>
                                    <button title="Disable" class="btn btn-sm btn-danger" onclick="fetch('/able.php?id=<?= $user['id'] ?>').then(response=> window.location.reload());">

                                    <i class="fas fa-ban"></i>
                                    </button>
                                <?php else: ?>
                                    <button title="Enable" class="btn btn-sm btn-success" onclick="fetch('/able.php?id=<?= $user['id'] ?>').then(response=> window.location.reload());">
                                        <i class="fas fa-check"></i>
                                    </button>
                                <?php endif; ?>
                                <?php 
                                    $qrpath = urlencode("otpauth://totp/Tech Team: {$user['name']}?secret={$user['mobilecode']}&issuer=Tech Team");
                                ?>
                                <a title="Mobile TOTP Code" class="btn btn-sm btn-primary" href="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $qrpath ?>" target="_blank">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

include '../base.php';