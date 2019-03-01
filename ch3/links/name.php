<?php
$firstname = htmlspecialchars($_GET['firstname'], ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($_GET['lastname'], ENT_QUOTES, 'UTF-8');
echo 'Welcome to our website, ' . $firstname . ' ' . $lastname . '!';