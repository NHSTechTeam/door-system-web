<?php
$title = "Logs";
require_once '../db.php';
try {
    $where = [];
    if (isset($_GET['u'])) {
        $where[] = 'user_id = ' . $_GET['u'];
    }
    if (isset($_GET['success'])) {
        $where[] = 'success = ' . $_GET['success'];
    }
    if (isset($_GET['code'])) {
        $where[] = 'code_scanned = ' . $_GET['code'];
    }
    if (isset($_GET['p'])) {
        $page = (int) $_GET['p'];
        if ($page < 1)
            $page = 1;
    } else {
        $page = 1;
    }
    $whereClause = '';
    if (!empty($where)) {
        $whereClause = 'WHERE ' . implode(' AND ', $where);
    }
    $sql = "SELECT * FROM access_log $whereClause ORDER BY timestamp DESC LIMIT 10 OFFSET " . (10 * ($page - 1));
    $stmt = $db->query($sql);
    $logs = $stmt->fetchAll();
    $sql = $sql = "SELECT COUNT(*) FROM access_log $whereClause";
    $stmt = $db->query($sql);
    $total_logs = $stmt->fetchColumn();
    $pages = ceil($total_logs / 10);
} catch (PDOException $e) {
    die("Failed to fetch users: " . $e->getMessage());
}
ob_start();
?>

<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Code</th>
                    <th>Success</th>
                    <th>Method</th>
                    <th>Failure Reason</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <?php
                    $date = new DateTime($log['timestamp'], new DateTimeZone('UTC'));
                    $date->setTimezone(new DateTimeZone('America/New_York'));
                    ?>
                    <tr>
                        <td>
                            <?php if ($log['user_id']): ?>
                                <?php
                                $stmt = $db->query("SELECT * FROM users WHERE id = " . $log['user_id']);
                                $user = $stmt->fetch();
                                $name = $user['name'];
                                ?>
                                <a href="/logs?u=<?= $log['user_id'] ?>"> <?= $log['user_id'] . " (" . $name . ")" ?> </a>
                            <?php else: ?>
                                <span class="badge badge-danger">Unknown</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $log['code_scanned'] ?></td>
                        <td>
                            <?php if ($log['success']): ?>
                                <span class="badge badge-success">Yes</span>
                            <?php else: ?>
                                <span class="badge badge-danger">No</span>
                            <?php endif; ?>

                        </td>
                        <td><?php echo $log['method'] ?></td>
                        <td><?php echo $log['failure_reason'] ?></td>
                        <td><?php echo $date->format('m/d/Y') . ", " . $date->format('h:i A') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        <?php
        $current_page = isset($_GET['p']) ? (int) $_GET['p'] : 1;
        $pages = $pages ?? 1; // Make sure $pages is defined beforehand
        ?>

        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item <?php if ($current_page <= 1)
                echo 'disabled'; ?>">
                <a class="page-link" href="?p=<?php echo max(1, $current_page - 1); ?>">«</a>
            </li>
            <li class="page-item <?php if ($page == $current_page)
                echo 'active'; ?>">
                <a class="page-link" href="?p=<?php echo $page; ?>"><?php echo $page; ?></a>
            </li>
            <li class="page-item <?php if ($current_page >= $pages)
                echo 'disabled'; ?>">
                <a class="page-link" href="?p=<?php echo min($pages, $current_page + 1); ?>">»</a>
            </li>
        </ul>
    </div>
</div>

<?php
$content = ob_get_clean();

include '../base.php';