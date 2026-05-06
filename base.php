<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /login/");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        html,body {
           margin: 0;
           height: 100%;
           overflow: hidden;
        }
    </style>
    <meta charset="UTF-8">
    <title><?php $title ?? 'Dashboard' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="hold-transition sidebar-mini" style="">
<div class="wrapper">
    <?php include 'layout.php'; ?>
    <div class="content-wrapper p-4">
        <?php if (isset($content)) echo $content; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>