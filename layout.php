<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">Tech Team UAC</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                <li class="nav-item">
                    <a href="/" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/users" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/users' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/logs" class="nav-link <?= $_SERVER['REQUEST_URI'] === '/logs' ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-table-list"></i>
                        <p>Access Logs</p>
                    </a>
                </li>
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
                <span class="brand-text"><?php $title ?? 'Dashboard' ?></span>
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
                <button type="button" class="btn btn-primary">Unlock Door</button>
            </div>
        </div>
    </div>
</div>