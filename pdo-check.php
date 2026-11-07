<?php

echo "<h1>PDO Check</h1>";

echo "PDO: ";
var_dump(extension_loaded('pdo'));

echo "<br>";

echo "PDO_MYSQL: ";
var_dump(extension_loaded('pdo_mysql'));

echo "<br>PHP Version: " . phpversion();
