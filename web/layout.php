<?php
$tabs = [
    ['name' => 'Dashboard', 'icon' => 'fas fa-home', 'path' => '/'],
    ['name' => 'Users', 'icon' => 'fas fa-users', 'path' => '/users'],
    ['name' => 'Logs', 'icon' => 'fas fa-table-list', 'path' => '/logs'],
];
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
        <img src="/images/logo.png" class="brand-image img-circle elevation-3"
         style="opacity: .8">
        <span class="brand-text font-weight-light">TechTeam Door</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <?php
                foreach ($tabs as $tab) {
                    if($tab['path'] === '/') {
                       $active =  $_SERVER['REQUEST_URI'] == '/' ? 'active' : '';
                    } else {
                        $active = str_starts_with($_SERVER['REQUEST_URI'], $tab['path']) ? 'active' : '';
                    }
                    echo '<li class="nav-item">
                        <a href="' . $tab['path'] . '" class="nav-link ' . $active . '">
                        <i class="nav-icon ' . $tab['icon'] . '"></i>
                        <p>' . htmlspecialchars($tab['name']) . '</p>
                        </a>
                        </li>';
                }
                ?>
            </ul>
        </nav>
        <div class="sidebar-footer text-center mt-3">
            <button class="btn btn-lg btn-success btn-block text-white" data-toggle="modal" data-target="#unlockModal">
                <i class="fas fa-door-open"></i> Unlock
            </button>
        </div>
    </div>
</aside>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="navbar-brand">
                <span class="brand-text"><?= $title ?></span>
            </a>
        </li>
    </ul>
</nav>

<div class="modal fade" id="unlockModal" tabindex="-1" role="dialog" aria-labelledby="unlockModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unlockModalLabel">Unlock Door?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to unlock the door?</p>
                <p>This action will be logged.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="fetch('/unlock.php?confirm')">Unlock Door</button>
            </div>
        </div>
    </div>
</div>