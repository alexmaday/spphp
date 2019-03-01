<?php
if (!isset($_REQUEST['firstname'])) {
    include 'name.html.php';
} 
else {
    $firstname = htmlspecialchars($_REQUEST['firstname']);
    $lastname = htmlspecialchars($_REQUEST['lastname']);

    if ($firstname == 'Alex' && $lastname == 'Maday') {
        $output = "Welcome to the site, oh glorious leader!";
    }
    else {
        $output = "Welcome to the site " . $firstname . ' ' . $lastname;
    }

    include 'welcome.html.php';
}