<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        html,
        body {
            margin: 0;
            height: 100%;
            overflow: hidden;
        }
    </style>
    <meta charset="UTF-8">
    <title>Screen For Door</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mqtt/5.14.1/mqtt.js"
        integrity="sha512-uG/po6GumLY4IdvHpELqwaEqTE7w01wuVZO970COhm6x59M6B9VaXfloyMxmv+i8KnPZi09fOE5Ob7QVxprC+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="hold-transition text-center sidebar-mini">
    <div class="wrapper">
        <div class="header">
            <img src="/images/logo.png" alt="Logo" class="img-fluid">
            <h1 class="mt-2">NHS Tech Team</h1>
        </div>
        <div class="center">
            <div id="message" class="display-3">Please scan your ID.</div>
        </div>
    </div>
    <div id="status-message">
        There is an error that may prevent access. (MQTT Disconnected)
    </div>
    <script>
        const mqtt_url = "<?= getenv('MQTT_URL'); ?>";
        //const mqtt_username = "<?= getenv('MQTT_USERNAME'); ?>";
        //const mqtt_password = "<?= getenv('MQTT_PASSWORD'); ?>";
    </script>
    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>