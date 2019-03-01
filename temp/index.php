<?php

$testvalue = 42;
echo "I am index.php - testvalue: $testvalue";

include './test1.html.php';
echo "testvalue: $testvalue";

include './test2.html.php';
echo "testvalue: $testvalue";
