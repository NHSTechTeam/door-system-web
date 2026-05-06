<?php
$title = "Dashboard";
require_once 'db.php';
try {
    // Count failed attempts in the last 1 day
    $stmt = $db->query("SELECT COUNT(*) FROM access_log WHERE success = 0 AND timestamp >= NOW() - INTERVAL 1 DAY");
    $bad = $stmt->fetchColumn();

    // Count successful attempts in the last 1 day
    $stmt = $db->query("SELECT COUNT(*) FROM access_log WHERE success = 1 AND timestamp >= NOW() - INTERVAL 1 DAY");
    $day = $stmt->fetchColumn();

    // Count successful attempts in the last 7 days
    $stmt = $db->query("SELECT COUNT(*) FROM access_log WHERE success = 1 AND timestamp >= NOW() - INTERVAL 7 DAY");
    $week = $stmt->fetchColumn();

    // Now you can echo or use $bad, $day, and $week
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
ob_start();
?>

<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $day ?></h3>
                    <p>Unlocks Today</p>
                </div>
                <div class="icon">
                    <i class="fa fa-door-open"></i>
                </div>
                <a href="/logs?success=true&time=-1d" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $week ?></h3>
                    <p>Unlocks This Week</p>
                </div>
                <div class="icon">
                    <i class="fa fa-calendar-week"></i>
                </div>
                <a href="/logs?success=true&time=-7d" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= $bad ?></h3>
                    <p>Failed Attempts Today</p>
                </div>
                <div class="icon">
                    <i class="fa fa-hand"></i>
                </div>
                <a href="logs?success=false&time=-1d" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

include 'base.php';