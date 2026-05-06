<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ldap_host = 'ldaps://192.168.1.251';
    $ldap_port = 389;
    putenv('LDAPTLS_REQCERT=never');
    $ldap_dn = 'DC=techteam,DC=local'; // Base DN
    $ldap_user = $_POST['username'];
    $ldap_pass = $_POST['password'];

    $ldap_conn = ldap_connect($ldap_host);
    ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    
    if ($ldap_conn) {
        $bind_dn = "$ldap_user@techteam.local";
        if (@ldap_bind($ldap_conn, $bind_dn, $ldap_pass)) {
            
            // Search for user info
            $search = ldap_search($ldap_conn, "OU=TechTeamUsers,".$ldap_dn, "(sAMAccountName=$ldap_user)", ["sAMAccountName", "cn", "displayname", "title", "thumbnailPhoto"]);
            $entries = ldap_get_entries($ldap_conn, $search);
            if ($entries['count'] > 0) {
                $user = $entries[0];
                error_log($user['cn'][0] ?? '');
                $_SESSION['photo'] = $user['thumbnailphoto'][0] ?? '';
                $_SESSION['username'] = $ldap_user;
                $_SESSION['displayname'] = $user['displayname'][0] ?? '';
                $_SESSION['name'] = $user['cn'][0] ?? '';
                $_SESSION['title'] = $user['title'][0] ?? '';

                header("Location: /");
                exit;
            } else {
                $error = "An unknown error occurred.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "There was an error connecting to the server.";
        
    }
    header("Location: /login/?error=" . urlencode($error));
    exit;
}
?>